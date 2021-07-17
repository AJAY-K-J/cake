<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseCredit;
use App\Models\PurchaseVendor;
use App\Models\UploadLog;
use App\Models\Product;
use App\Models\PaymentType;
use App\Models\Payment;
use App\Models\PurchaseLog;
use App\Models\Stock;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use PDF;
use App\Http\Controllers\SMS;
use App\Models\SmsSetting;
use Auth;


class PurchaseController extends Controller
{
    public function index()

    {
        $vendors = PurchaseVendor::where('status','0')->orderBy('name')->get();
        
        $products = Product::where('status',0)->orderBy('name')->get();
        $payment_types = PaymentType::where('status',0)->get();

        return view('admin.purchases',compact('vendors','products','payment_types'));
    }

    public function get_purchases()
    {

        
            $purchases = PurchaseCredit::with('vendor')->where('status',0)->whereDate('created_at',date('Y-m-d'))->orderBy('created_at','desc')->get();
            return  $purchases;
    
        

    }
    public function get_purchases_by_vendor($id)
    {

       $purchases =  PurchaseCredit::with('vendor')->where([['status','0'],['vendor_id',$id]])->orderBy('created_at','desc')->get();
        return $purchases;
    }
 
    public function save(Request $request)
    {
        // return $request->all();
        if($request->id){
            $purchase = PurchaseCredit::find($request->id);
        }
        else
            $purchase = new PurchaseCredit;
        if($request->created_at)
            $purchase->purchase_date = $request->created_at;
        else
          $purchase->purchase_date = date('Y-m-d');

        $purchase->vendor_id = $request->vendor_id;
        $purchase->amount = $request->amount;
        if($request->pay_type){
           $purchase->payment=1;
           $purchase->payment_type=$request->payment_type;
            $purchase->payed_amount= $request->amount;
          
            
        }   
        else{
           $purchase->payment=0; 
        }
        $purchase->remarks = strtoupper($request->remarks);
        $purchase->save();
        if($request->pay_type)
        {
           $payment = new Payment;
            $payment->payment_type = $request->payment_type;
            $payment->amount =   $request->amount;
            $payment->purchase_id = $purchase->id;
            $payment->save();
        }
        foreach ($request->items as $item)
        { 
          $product = Product::where('name',$item['product'])->first();
          if(!empty($product))
          {
            $stock = Stock::where('product_id',$product->id)->first();
            if(empty($stock))
            {
             $stock = new Stock;     
             $stock->qty=$item['qty'];
             $stock->product_id=$product->id;
             $stock->rate=$item['rate'];  
            }
            else
            {
              $stock->qty+=$item['qty']; 
            }  
            $product->ndp = $item['rate'];
            if($item['gst'])  
              $product->gst = $item['gst'];
            $product->save();
          }
          else
          {
            $new_product = new Product;
            $new_product->name = $item['product'];
            $new_product->save();

            $stock = new Stock;     
            $stock->qty=$item['qty'];
            $stock->product_id=$new_product->id;
            $stock->rate=$item['rate'];
                        
          }
          $product = Product::where('name',$item['product'])->first();
               $purchase_log = new PurchaseLog;
               $purchase_log->purchase_id=$purchase->id;
               $purchase_log->vendor_id=$request->vendor_id;
               $purchase_log->product_id = $product->id;
               $purchase_log->product = $item['product'];
               $purchase_log->qty = $item['qty'];
               $purchase_log->rate = $item['rate'];
               if($item['gst'])  
                  $purchase_log->gst = $item['gst'];
               $purchase_log->purchase_date = date('Y-m-d');
               $purchase_log->remarks = strtoupper($request->remarks);
               $purchase_log->save();

               $stock->save();
        }

       
        return 'Success';
    }

    public function delete_purchase(Request $request)
    {
        // return $request->all();
        if($request->id){
            $purchase = PurchaseCredit::find($request->id);
        }

         $payment= Payment::where('purchase_id',$purchase->id)->delete();

         $purchase_items= PurchaseLog::where('purchase_id',$purchase->id)->get();

        foreach ($purchase_items as $item)
        { 
            $stock = Stock::where('product_id',$item->product_id)->first();
            
            if($stock->qty > $item['qty'])
            {
                
                $stock->qty = $stock->qty-$item['qty']; 
               
            }

            else
            {
              
              $stock->qty=0;
            }

            $stock->save();

        }

        $purchase_items= PurchaseLog::where('purchase_id',$purchase->id)->delete();

        $purchase->status=-1;
        $purchase->save();
       
        return 'Success';
    }
    public function purchasecredit_payed(Request $request) {
        
        $request->validate([
            'payment_type' => 'required',
            'pay' => 'required',
        ]);
      
       $purchase = new PurchaseCredit;
       
                if($request->created_at)
                    $purchase->created_at = $request->created_at;
                $purchase->vendor_id = $request->vendor_id;
                $purchase->payment_type = $request->payment_type;
                $purchase->remarks = $request->remarks;
                $purchase->payment = 1;
                $purchase->amount=$request->pay;
                $purchase->save();
                return ['status'=>1, 'response'=>"PurchaseCredit payment received"];
      }


    public function check_puchase(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $purchase = PurchaseCredit::with('vendor','items')->where('id',$request->id)->first();
        return $purchase;

       
    }

    public function return_product(Request $request) {

       
        $request->validate([
            'vendor_id' => 'required',
            'purchase_id' => 'required',
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
           if($stock->qty<$request->qty){
            $stock->qty = 0;
           }
           else{
            $stock->qty = $stock->qty - $request->qty;
           }
         $stock->save(); 
         $return_amount = $request->qty * $stock->rate; 
         
         $purchase = PurchaseCredit::where('id',$request->purchase_id)->first();
         $purchase->amount=  $purchase->amount - $return_amount;

         $purchase_item = PurchaseLog::where([['purchase_id',$request->purchase_id],['product_id',$request['product']]])->first();
        
         $purchase_item->qty = $purchase_item->qty - $request->qty;
         $purchase_item->save();
         $purchase->save();

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
       $purchase_log = new PurchaseLog;
        $purchase_log->purchase_id = $request->purchase_id;
       $purchase_log->vendor_id = $request->vendor_id;
       $purchase_log->product_id = $request->product;
       $product = Product::where('id',$request['product'])->first();
       $purchase_log->product = $product->name;
       $purchase_log->qty = $request->qty;
       $purchase_log->rate = $stock->rate;
       $purchase_log->purchase_date = date('Y-m-d');
       $purchase_log->remarks = strtoupper($request->remarks);
       $purchase_log->return_status = 1;
       $purchase_log->save();

       return "Success";
    }


}
