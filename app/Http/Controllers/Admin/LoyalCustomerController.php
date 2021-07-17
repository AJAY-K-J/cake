<?php
namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\LoyalCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class LoyalCustomerController extends Controller
{
    public function index()
    {
        return view('admin.loyalcustomer');
    }

    public function find_loyalcustomer(Request $request)
    {

        $type = $request->type;
        $value = $request->value;
        $credit_left=0;
        $credit = ['credit'=> $credit_left];

        if($type==1)
        {

            $customer = LoyalCustomer::where([['customer_code',$request->value],['status',0]])->orderBy('created_at', 'desc')->first();
            
            if($customer)
            {
                $total_credit=Customer::where([['type',4],['status',0],['customer_code',$request->value]])->sum('total_amount');
                $total_payed=Customer::where([['type',5],['status',0],['customer_code',$request->value]])->sum('total_amount');
                $credit_left=$total_credit-$total_payed;
                $credit = ['credit'=> $credit_left];
            }

            $array= array_merge($customer->toArray(), $credit);
            return $array;
        }
        
        if($type==3)
        {

            $customer = Customer::where([['mobile',$request->value],['status',0]])->orderBy('created_at', 'desc')->first();
            if($customer)
            {
                $total_credit=Customer::where([['type',4],['mobile',$request->value]])->sum('total_amount');
                $total_payed=Customer::where([['type',5],['mobile',$request->value]])->sum('total_amount');
                $credit_left=$total_credit-$total_payed;
                $credit = ['credit'=> $credit_left];


                $array= array_merge($customer->toArray(), $credit);
                return $array;
            }
        }
     }
 

 public function save(Request $request) {
   $table="loyalcustomers_".Auth::user()->company->id; 
    $this->validate($request, [
        'name' => 'required',
        'location' => 'required',
        'mobile' => 'required',
        'customer_code' => [
            'required',
            Rule::unique($table,'customer_code')
            ->ignore($request->id,'id')
            ->where(function ($query) {
                return $query->where([['status','0']]);
            }),
        ],
    ],[
        'customer_code.required' => 'Customer code is required',
    ]);

    if($request->id)
    {
        $lc = LoyalCustomer::find($request->id);
        $lc->name = strtoupper($request->name);
        $lc->location = $request->location;
        $lc->mobile = $request->mobile;
        $lc->customer_code = strtoupper($request->customer_code);
        $lc->save();

    }
    else
    {
        $lc = new LoyalCustomer;
        $lc->name = strtoupper($request->name);
        $lc->location = $request->location;
        $lc->mobile = $request->mobile;

        $lc->customer_code = strtoupper($request->customer_code);
        $lc->save();
        Customer::where([['status',0],['type','>',1],['mobile',$request->mobile]])->update([
         'customer_code' => strtoupper($request->customer_code)
     ]);
    }



    return ['status'=>1];
}

public function get_history($mobile) {
    return $mobile;
    $history = Customer::where([['status',0]]);
    if($request->customer_code)
        $history->where([['customer_code', $request->customer_code]]);
    else if($request->mobile)
        $history->where([['mobile', $request->mobile]]);
    else
        return [];

    if($request->from)
        $history->whereDate('created_at', '>=' ,$request->from);

    if($request->to)
        $history->whereDate('created_at', '<=' ,$request->to);

    return $history->orderBy('created_at','desc')->get();
}
public function credit_payed(Request $request) {

    $request->validate([
        'payment_type' => 'required',
        'pay' => 'required',
    ]);
  
    $customer= new Customer;
    $customer->customer_code = $request->customer_code;

            if( $request->created_at)
                $customer->created_at = $request->created_at;
            if( $request->type=='sale'){
                $customer->sale_status = 1;
            }
            else{
                $customer->sale_status = 0;
            }    
            $customer->name = $request->name;
            $customer->payment_type = $request->payment_type;
            $customer->location = $request->location;
            $customer->mobile = $request->mobile;
            $customer->type = 5;
            $customer->total_amount=$request->pay;
            $customer->remarks=$request->remarks;
            $customer->save();
            return ['status'=>1, 'response'=>"Credit against payment received"];
  }

}