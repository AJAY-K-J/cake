<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleOrder;
use App\Models\OrderItem;
use App\Models\Company;
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
class SalesOrderController extends Controller
{
    public function index()
    {
      
        $products = Product::where([['status',0],['rubber',0]])->orderBy('name')->get();
        $rubbers = Product::where([['status',0],['rubber',1]])->orderBy('name')->get();
        $companies = Company::where('status',0)->orderBy('name')->get();
        $payment_types = PaymentType::where('status',0)->get();
        return view('admin.sale_order',compact('products','payment_types','rubbers','companies'));
    }

    public function get_sales()
    {
        $sales =  SaleOrder::with('receipts')->where('status',0)->get();
        return $sales;
    }
    public function get_today_orders(Request $request)
    {
      if($request->search)
      {
         $sales = SaleOrder::with('items')->where([['status','0'],['id',$request->search]])
         ->get();

        if(count($sales)==0)
        {
          $sales = SaleOrder::with('items')->where([['status','0'],['mobile',$request->search]])->orderBy('id','desc')->get();

        }
        return  $sales;
      }

        $sales =  SaleOrder::with('items')->where([['status',0],['invoice_no',NULL]])->get();
        return $sales;
    }
    public function save(Request $request)
    {
     //return $request->all();
      $request->validate([
        'name' => 'required',
         'mobile' => 'required|digits:10',
        'items' => 'required',
      ]);
       if($request->id){
           $sale = SaleOrder::find($request->id);
           $new_order_id= $sale->id;
          
          OrderItem::where('order_id',  $new_order_id)
           ->delete();
          
       }
       else
       {
           $sale = new SaleOrder;
           $lastobject = SaleOrder::latest('id')->first();
           if($lastobject)
               $lastjcno=$lastobject->id;
           else
               $lastjcno=0;
           

           $new_order_id=$lastjcno+1;
          

        }

        $sale->name = strtoupper($request->name);
        $sale->mobile = $request->mobile;
        $sale->reg_no =  preg_replace('/[^A-Za-z0-9]/', '', strtoupper($request->reg_no));
        $sale->company_id = $request->company_id;
   
        $sale->remarks=  $request->remarks;
        
    

            $items = $request->items;
            $total_items = 0;
            foreach ($items as $item){ 

               $sale_dertail = new OrderItem;
               $sale_dertail->order_id= $new_order_id;
           
                 $total_items += 1; 
                $sale_dertail->qty= 1;
                    $sale_dertail->product=$item['product'];
                $sale_dertail->rate=$item['rate'];
                $sale_dertail->serial_no=$item['serial_no'];
                $sale_dertail->remarks=$item['remarks'];
                $sale_dertail->company=$item['company'];
                $sale_dertail->created_by=Auth::id();
              
                $sale_dertail->save();     
        }
        $sale->total_estimate =$request->total_spare;
        $sale->order_status =1;
        $sale->created_by=Auth::id(); 
        $sale->save();
        return 'Success';
    }

    public function delete_sale_order(Request $request) {

      
        $request->validate([
            'id' => 'required',
        ]);

        $order = SaleOrder::find($request->id);
        OrderItem::where('order_id',  $order->id)
                 ->delete();
        
            $order->status = -1;
            $order->save();
            return 'Success';
        
        
    }
     public function print_sale_order($id)
     {
         $sale_order = SaleOrder::where([
            ['id',$id],
            ['status',0]
        ])->with(['items'])->first();
        
        

         if($sale_order){

             $pdf = PDF::loadView('exports.print_sale_order', ['sale_order'=>$sale_order])->setPaper('a4', 'potrait');
             $filename = uniqid();
             $filename='SALEORDER_'.date('YmdHis').'.pdf';
             return $pdf->stream($filename);
             
         }
         else
            return false;
    }
}
