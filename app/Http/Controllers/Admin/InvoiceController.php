<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\InvoiceItem;
use App\Models\SaleOrder;
use App\Models\OrderItem;
use App\Models\SaleDetail;
use App\Models\PaymentType;
use App\Models\Payment;
use App\Models\Jobcard;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use PDF;
class InvoiceController extends Controller
{
    public function index()
    {
       
        $products = Product::where('status',0)->orderBy('name')->get();
        $companies = Company::where('status',0)->orderBy('name')->get();
        $payment_types = PaymentType::where('status',0)->get();
        return view('admin.invoices',compact('products','payment_types','companies'));
    }

   
    public function get_todayinvoices(Request $request)
    {
      if($request->search)
      {
         $sales = Invoice::with('items','payments')->where([['status','0'],['invoice_no',$request->search]])
         ->get();

        if(count($sales)==0)
        {
          $sales = Invoice::with('items','payments')->where([['status','0'],['mobile',$request->search]])->orderBy('invoice_no','desc')->get();

        }
        return  $sales;
      }

        $sales =  Invoice::with('items')->where('status',0)->whereDate('created_at',date('Y-m-d'))->get();
        return $sales;
    }
    public function save(Request $request)
    {
     
      $request->validate([
          'name' => 'required',
          'mobile' => 'required|digits:10',
          'items' => 'required',
      ]);

      if($request->id)
      {
        $sale = Invoice::find($request->id);
        $new_invoice_no= $sale->invoice_no;
        $existings =InvoiceItem::where([['invoice_no',  $new_invoice_no],['status',0]])->get();   
        foreach ($existings as $existing) 
        {
             $part_stock = Stock::where([['product_id',$existing['product_id']],['status',0]])->first();
             $part_stock->qty = $part_stock->qty + $existing->qty;
             $part_stock->save();
             $existing->status = -1;
             $existing->save();
        } 
         Payment::where('invoice_no',  $new_invoice_no)
           ->delete();

       }
       else
       {
           $sale = new Invoice;
           $lastobject = Invoice::latest('id')->first();
         
           if($lastobject)
               $lastjcno=$lastobject->invoice_no;
           else
               $lastjcno=0;
           $new_invoice_no=$lastjcno+1;
           
           
        }



        $sale->name = strtoupper($request->name);
        $sale->mobile = $request->mobile;
        if($request->location)
          $sale->location = strtoupper($request->location);
        if($request->gst_no)
          $sale->gst_no =  strtoupper($request->gst_no);
        $sale->invoice_no= $new_invoice_no;
        $sale->invoice_date= date('Y-m-d H:i:s');
        $sale->remarks=$request->remarks;
        
       $spare_cgst= 0;
       $spare_igst= 0;
       $spare_sgst= 0;
       $spare_cess= 0;
       $spare_net= 0;
       $spare_amount= 0;
       $total_labour= 0;
      $items = $request->items;
      $total_items = 0;

      foreach ($items as $item)
      { 

        $sale_dertail = new InvoiceItem;
        $sale_dertail->invoice_no= $new_invoice_no;
        $sale_dertail->product=$item['product'];
        $product = Product::where('name',$item['product'])->first();
        if(!empty($product))
        {
          $sale_dertail->product_id=$product->id;
          $stock = Stock::where([['status',0],['product_id',$product->id]])->first();
          if(!empty($stock))
          {
             if($stock->qty<$item['qty'])
             {
                return ['product'=>$item['name'],'qty'=>$stock->qty,'response'=>'no stock'];
              }
              else{
                 
                 $stock->qty=$stock->qty - $item['qty'];  
              }
              //return $item['qty'];
              $stock->save();
          }
          else
          {
              return 'no stock';
          }
           
        }
        else
        {
          return 'Product not found';
        }
                

                

                $sale_dertail->qty= $item['qty'];
                $sale_dertail->rate=$item['rate'];
                $sale_dertail->discount=0;
               
                $sale_dertail->gst_percentage=$item['gst_percentage'];
                $sale_dertail->tax_type=$item['tax_type'];
                $type=$item['tax_type'];

              

                if($type==1)
                {
                   $amount=(($item['qty']*$item['rate'])*100)/($item['gst_percentage']+101);
                   $sale_dertail->amount= $amount;
                     $sale_dertail->cgst=$amount*(($item['gst_percentage']/2)/100);
                   $sale_dertail->sgst=$amount*(($item['gst_percentage']/2)/100);
                   $sale_dertail->cess=$amount*(1/100);
                   $sale_dertail->igst=0;
                }

                else if($type==2)
                {
                  $amount=(($item['qty']*$item['rate'])*100)/($item['gst_percentage']+100);
                   $sale_dertail->amount= $amount;
                     $sale_dertail->cgst=$amount*(($item['gst_percentage']/2)/100);
                   $sale_dertail->sgst=$amount*(($item['gst_percentage']/2)/100);
                   $sale_dertail->cess=0;
                   $sale_dertail->igst=0;
                }
                 
                 
                 
                 $sale_dertail->net_amount=($amount+  $sale_dertail->igst+  $sale_dertail->cgst+  $sale_dertail->sgst+  $sale_dertail->cess);
                  $spare_cgst= $spare_cgst+$sale_dertail->cgst;
                  $spare_igst= $spare_igst+$sale_dertail->igst;
                  $spare_sgst= $spare_sgst+$sale_dertail->sgst;
                  $spare_cess= $spare_cess+$sale_dertail->cess;
                  $spare_net=$spare_net+$sale_dertail->net_amount;
                  $spare_amount=$spare_amount+$amount;
               

                $sale_dertail->created_by=Auth::id();
                $sale_dertail->save();     
               }
        if($request->order_id){
          $order = SaleOrder::find($request->order_id);
          if(!empty($order)){
              $order->invoice_no = $new_invoice_no;
              $order->save();
          }
        }       
        $sale->total_cgst=  $spare_cgst;
        $sale->total_igst=    $spare_igst;
        $sale->total_sgst=    $spare_sgst;
        $sale->total_cess=    $spare_cess;
        
        $sale->total_gross_amount =$spare_net;
       

        $sale->total_discount=$request->discount?$request->discount:0;
        $sale->total_net_amount =$spare_net-$sale->total_discount;
      
        if(!$request->credit)
        {
            $payment = new Payment;
            $payment->payment_type = $request->payment_type;
            $payment->amount =   $sale->total_net_amount;
            $payment->invoice_no =  $new_invoice_no;
            $sale->received_amount=$sale->total_net_amount;
            $sale->payment_type=$request->payment_type;
            $sale->credit=0;
            $payment->save();
            
        }
        else
        {
           $sale->credit=1;
           $sale->received_amount=0;
        }


        $sale->created_by=Auth::id(); 
        $sale->save();



        return 'Success';
    }
    public function pay_balance_invoices()
    {
      $invoices = Invoice::where('status',0)->whereColumn('total_net_amount' ,'>','received_amount')->get();
        $total_balance = 0;
        foreach($invoices as $invoice)
        {

            $total = $invoice['total_net_amount'] - $invoice['received_amount'];
            $total_balance = $total_balance +  $total;
        }
          
      return view('admin.pay_balance_invoices',compact('total_balance'));  
    }
    public function InvoicePayBalanceReport(Request $request)
    {
       if($request->search)
          {

          $invoices = Invoice::where([['status',0],['invoice_no',$request->search]])->whereColumn('total_net_amount' ,'>','received_amount')->get();

          if(count($invoices)==0)
          {
              $invoices = Invoice::where([['status',0],['mobile',$request->search]])->whereColumn('total_net_amount' ,'>','received_amount')->orderBy('id','desc')->get();

          }

          return  $invoices;


      }

      else
      {
          $invoices = Invoice::where('status',0)->whereColumn('total_net_amount' ,'>','received_amount')->get();
          return  $invoices;
      }
    }
    public function delete_invoice(Request $request) {

      
        $request->validate([
            'id' => 'required',
        ]);

         $invoice = Invoice::find($request->id);
        $invoice_no = $invoice->invoice_no;
        $invoice_items = InvoiceItem::where([['invoice_no',  $invoice_no],['status',0]])->get(); 
        foreach ($invoice_items as $item) {
          $product = Product::where([['id',$item['product_id']],['status',0]])->first();
          if(!empty($product)){
            $stock = Stock::where([['product_id',$product->id],['status',0]])->first();
            if(!empty($stock)){

              $stock->qty = $stock->qty+$item['qty'];
              $stock->save();
            }
          }
        }
        InvoiceItem::where('invoice_no',  $invoice_no)
            ->delete();
        
            
            $invoice->delete();
            return 'Success';

        
    }
     public function print_invoice($id)
     {
         $invoice = Invoice::where([
            ['id',$id],
            ['status',0]
        ])->with(['items'])->first();
        
        

         if($invoice){

             $pdf = PDF::loadView('exports.print_invoice', ['invoice'=>$invoice])->setPaper('a5', 'potrait');
             $filename = uniqid();
             $filename='INVOICE_'.date('YmdHis').'.pdf';
             return $pdf->stream($filename);
             
         }
         else
            return false;
    }
    public function find_customer(Request $request) 
    {
        $sql = Invoice::where('status',0)->select('name','mobile','location','gst_no');

        if($request->mobile_no != '')
        {

            $check = $sql->where('name',$request->mobile_no)->first();
            if( $check==null)
            {
                $sql =  Invoice::where('status',0)->select('name','mobile','location','gst_no')->where('mobile',$request->mobile_no);
            }
        }

        $booking = $sql->orderBy('id','desc')->first();
        return  $booking;
    }
}
