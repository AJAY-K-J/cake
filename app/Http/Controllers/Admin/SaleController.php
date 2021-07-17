<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\PaymentType;
use App\Models\Payment;
use App\Models\Jobcard;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use PDF;
class SaleController extends Controller
{
    public function index()
    {
        $products = Product::where('status',0)->orderBy('name')->get();
        $payment_types = PaymentType::where('status',0)->get();
        return view('admin.sales',compact('products','payment_types'));
    }

    public function get_sales()
    {
        $sales =  Sale::with('receipts')->where('status',0)->get();
        return $sales;
    }
    public function get_todaysales(Request $request)
    {
      if($request->search)
      {
         $sales = Sale::with('receipts')->where([['status','0'],['receipt_no',$request->search]])
         ->get();

        if(count($sales)==0)
        {
          $sales = Sale::with('receipts')->where([['status','0'],['mobile',$request->search]])->orderBy('id','desc')->get();

        }
        return  $sales;
      }

        $sales =  Sale::with('receipts')->where('status',0)->whereDate('sale_date',date('Y-m-d'))->get();
        return $sales;
    }
    public function save(Request $request)
    {
      // return $request->all();
      $request->validate([
        'customer_name' => 'required',
         'mobile' => 'required|digits:10',
        'items' => 'required',
      ]);
       if($request->id){
           $sale = Sale::find($request->id);
           $new_receipt_no= $sale->receipt_no;
          
          SaleDetail::where('receipt_no',  $new_receipt_no)
           ->delete();
          
       }
       else
       {
           $sale = new Sale;
           $lastobject = Sale::where('status',0)->latest('id')->first();
           if($lastobject)
               $lastjcno=$lastobject->receipt_no;
           else
               $lastjcno=0;
           do{


           $new_receipt_no=$lastjcno+1;
           $job= Sale::where('receipt_no',$new_receipt_no)->latest('id')->first();
           }while($job);
          

        }

        $sale->customer_name = strtoupper($request->customer_name);
        $sale->mobile = $request->mobile;
       // $sale->payment_type= $request->payment_type;
        $sale->receipt_no= $new_receipt_no;
        $sale->sale_date= date('Y-m-d H:i:s');
        $sale->remarks=  $request->remarks;
        
    

            $items = $request->items;
            $total_items = 0;
            foreach ($items as $item){ 

               $sale_dertail = new SaleDetail;
               $sale_dertail->receipt_no= $new_receipt_no;
              if($item['service_string']){               
                
                 $product = Product::where('name',$item['service_string'])->first();
                    if(!empty($product)){
                       $sale_dertail->product_id=$product->id;
                       $sale_dertail->service_string=$item['service_string'];
                      $stock = Stock::where([['status',0],['product_id',$product->id]])->first();
                       if(!empty($stock)){
                         if($stock->qty<$item['qty']){
                            return ['product'=>$item['service_string'],'qty'=>$stock->qty,'response'=>'no stock'];
                          }
                          else{
                             $stock->qty=$stock->qty - $item['qty'];  
                          }
                          $stock->save();
                        }
                        else{
                          'no stock';
                        }
                       
                       }
                       else{
                        return 'not found';
                       }
                 } 
                 $total_items += 1; 
                $sale_dertail->qty= $item['qty'];
                $sale_dertail->rate=$item['rate'];
                $sale_dertail->remarks=$request->remarks;
                $sale_dertail->save();     
               }
               
         $sale->total_items = $total_items;
        $sale->total_gross_amount =$request->total_spare?$request->total_spare:0;
        $sale->total_discount_amount=$request->discount?$request->discount:0;
        $sale->total_net_amount =$sale->total_gross_amount-$sale->total_discount_amount;
      
       if($request->credit){
          $sale->credit= 1;
        }
        else{
           $sale->credit= 0; 
           $payment = new Payment;
           $payment->receipt_no = $new_receipt_no;
           $payment->payment_type = $request->payment_type;
           $payment->amount = $sale->total_net_amount;
           $payment->remarks = $request->remarks;
           $payment->save();
           $sale->received_amount = $sale->total_net_amount;
         }    




        $sale->save();
        return 'Success';
    }
    public function pay_balance_receipts()
    {
      $receipts = Sale::where('status',0)->whereColumn('total_net_amount' ,'>','received_amount')->get();
        $total_balance = 0;
        foreach($receipts as $receipt)
        {

            $total = $receipt['total_net_amount'] - $receipt['received_amount'];
            $total_balance = $total_balance +  $total;
        }
          
      return view('admin.pay_balance_receipts',compact('total_balance'));  
    }
    public function ReceiptPayBalanceReport(Request $request)
    {
       if($request->search)
          {

          $receipts = Sale::where([['status',0],['invoice_no',$request->search]])->whereColumn('total_net_amount' ,'>','received_amount')->get();

          if(count($receipts)==0)
          {
              $receipts = Sale::where([['status',0],['mobile',$request->search]])->whereColumn('total_net_amount' ,'>','received_amount')->orderBy('id','desc')->get();

          }

          return  $receipts;


      }

      else
      {
          $receipts = Sale::where('status',0)->whereColumn('total_net_amount' ,'>','received_amount')->get();
          return  $receipts;
      }
    }

    public function delete_sale(Request $request) {

      
        $request->validate([
            'id' => 'required',
        ]);

        $customer = Customer::find($request->id);
        Jobcard::where('receipt_no',  $customer->receipt_no)
                 ->delete();
        
            $customer->status = -1;
            $customer->save();
            return 'Success';
        
        
    }
     public function print_sale($id)
     {
         $customer = Sale::where([
            ['id',$id],
            ['status',0]
        ])->with(['receipts'])->first();
        
        

         if($customer){

             $pdf = PDF::loadView('exports.printsale', ['customer'=>$customer])->setPaper('a5', 'potrait');
             $filename = uniqid();
             $filename='SALEBILL_'.date('YmdHis').'.pdf';
             return $pdf->stream($filename);
             
         }
         else
            return false;
    }


    public function check_sale(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);


        $sale = Invoice::with('payments','items')->where('invoice_no',$request->id)->first();
        return $sale;

       
    }

    public function return_sale(Request $request) {
      //return $request;
       
        $request->validate([
           
            'invoice_no' => 'required',
            'product' => 'required',
            'qty' => 'required',
        ]);

         $product = Product::where('id',$request['product'])->first();
         if(!empty($product)){
            $stock = Stock::where('product_id',$product->id)->first();

          }
          else{
            return "not product";
          }  

         if(!empty($stock)){ 
           
            $stock->qty = $stock->qty + $request->qty;
           
         $stock->save(); 
         $return_amount = $request->qty * $stock->rate; 
         
         $item = InvoiceItem::where([['invoice_no',$request->invoice_no],['product_id',$request->product],['status',0]])->first();
         $item->net_amount= $item->net_amount - $return_amount;
          $item->qty = $item->qty - $request->qty;
          if($item->qty==0)
          $item->delete();
        else
          $item->save();


          $invoice= Invoice::where([['invoice_no',$request->invoice_no],['status',0]])->first();
          $invoice->total_net_amount=$invoice->total_net_amount - $return_amount;
          $invoice->save();

         // $purchase = new PurchaseCredit; 
         // $purchase->vendor_id = $request->vendor_id;
         // $purchase->company_id = Auth::user()->company_id;
         // $purchase->amount= $return_amount;
         // $purchase->remarks = $request->remarks;
         // $purchase->payment = 1; 
         // $purchase->save(); 

        }
        else{
            return 'not stock';
        }
       $item_new = new InvoiceItem;
       
       $item_new->invoice_no = $request->invoice_no;
       $item_new->product_id = $request->product;
       $product = Product::where('id',$request['product'])->first();
       $item_new->product = $product->name;
       $item_new->qty = $request->qty;
       $item_new->rate = $product->mrp;
       $item_new->gst_percentage = $product->gst;
    
       $item_new->remarks = strtoupper($request->remarks);
       $item_new->return_status = 1;
       $item_new->status = 1;
       $item_new->save();

       return "Success";
    }

}
