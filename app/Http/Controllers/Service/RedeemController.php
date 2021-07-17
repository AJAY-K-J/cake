<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use Auth;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use SMS;
use Session;

class RedeemController extends Controller
{
    public function index()
    {
    	$services = Service::where('status',0)->get();
        return view('service.redeem')->with('services',$services);
    }

    public function search(Request $request)
    {
    	$type = $request->type;
    	$value = $request->value;

    	$referrals = Customer::where([['status',0],['type',1]])
    	->with([
    		'campaign' => function($query) { $query->where('status',0); },
    		'campaign.service' => function($query) { $query->where('status',0); }
    	]);
    	switch($type)
    	{
    		case 1: $referrals->where('referral_code','LIKE',$value); break;
    		case 2: $referrals->where('reg_no','LIKE',$value); break;
    		case 3: $referrals->where('mobile',$value); $referrals->orWhere('mobile2',$value); break;
    		default: return false; break;
    	}

    	$referrals = $referrals->get();
    	$today = DATE('Y-m-d');	
    	foreach ($referrals as $referral) {
    		if($referral->campaign->to_date < $today)
    			$referral->campaign->expired = true;
    		else
    			$referral->campaign->expired = false;

    		if($referral->campaign->days) {
    			$active_days = explode(',',$referral->campaign->days);
    			sort($active_days);
    			$referral->active_days = $active_days;
    		}
    		else
    			$referral->active_days = false;
    	}
    	
    	return $referrals;

    }

    public function send_otp(Request $request)
    {    	
    	$request->validate([
    		'customer_id' => 'required',
    		'mobile' => 'required',
    	]);

    	$otp = rand(1000,9999);

    	$mobile = $request->mobile;
    	$customer_id = $request->customer_id;
    	
      $customer = Customer::where([
       ['status',0],
       ['customer_id',$request->customer_id]
   ])->first();

      if($customer)
      {
          $now = Carbon::now();
          $expiry = $now->addMinutes(5);
          $redeem = [
            'OTP' => $otp,
            'EXPIRY' => $expiry,
            'CUSTOMER_ID' => $customer_id,
            'MOBILE' => $mobile,
        ];
        Session::put('REDEEM',$redeem);
        $message = "Dear Customer, $otp is your OTP for redeeming your coupon.\n".Auth::user()->company->name;
    		// return ['status'=>1, 'response'=>"SMS sent to 8157983243", 'redeem'=>$redeem];
        $status = SMS::send($message,$mobile);
        return $status;
    }
    else
      return ['status'=>0, 'response'=>'Invalid Referral'];


}

public function verify_otp(Request $request)
{
 $request->validate([
  'customer_id' => 'required',
  'discounted_amount' => 'required',
  'spare_amount' => 'required',
  'tax' => 'required',
  'labour_amount' => 'required',
  'mobile' => 'required',
  'otp' => 'required',
]);

 if(Session::has('REDEEM'))
     {
      $redeem = Session::get('REDEEM');
      $now = Carbon::now();
      if($redeem['EXPIRY'] > $now)
      {
        $customer = Customer::where([
         ['status',0],
         ['customer_id',$request->customer_id]
     ])->first();

        if($customer)
        {
            if($customer->redeem_status==0)
            {
             $mobile = $request->mobile2 ? $request->mobile2 : $request->mobile;
             if($redeem['OTP']==$request->otp && $redeem['CUSTOMER_ID']==$request->customer_id && $redeem['MOBILE']==$mobile)
             {
              DB::beginTransaction();
              try {
                $new_customer = $customer->replicate();
                $customer->status = -1;
                $customer->save();
                $new_customer->redeem_status = 1;
                $new_customer->redeem_date = DATE('Y-m-d H:i:s');
                $new_customer->service_user_id = Auth::user()->employee_id;
                $new_customer->redeem_amount = $request->discounted_amount;
                $new_customer->spare_amount = $request->spare_amount;
                $new_customer->tax = $request->tax;
                $new_customer->labour_amount = $request->labour_amount;
                $new_customer->total_amount = $request->spare_amount + $request->labour_amount + $request->tax;
                $new_customer->mobile2 = $request->mobile2;
                $new_customer->save();

                DB::commit();

                Session::forget('REDEEM');
    							// SMS::send("Thank you for servicing your vehicle ".$new_customer->reg_no." at ".Auth::user()->company->name.". We wish you a safe and happy motoring. For any assistance please call our 24Hrs Helpline No: 9895953333",$mobile);
                return ['status'=>1, 'response'=>"Redeemed"];
            } catch(Exception $e) {
               DB::rollBack();
               return ['status'=>0, 'response'=>"Couldn't redeeem this referral"];
           }
       }
       else
          return ['status'=>0, 'response'=>'Invalid OTP'];
  }
  else
     return ['status'=>0, 'response'=>'Referral Code already redeemed'];
}
else
    return ['status'=>0, 'response'=>'Invalid Referral'];
}
else
   return ['status'=>0, 'response'=>'OTP Expired'];
}
else
  return ['status'=>0,'response'=>'Invalid OTP'];
}

public function redeem_submit(Request $request)
{
    $request->validate([
        'customer_id' => 'required',
        'discounted_amount' => 'required',
        'labour_amount' => 'required',
    ]);
    $customer = Customer::where([
        ['status',0],
        ['customer_id',$request->customer_id],
        ['type',1]
    ])->first();
    if($customer)
    {
        if($customer->redeem_status==0)
        {
            DB::beginTransaction();
            try {
               
                $customer->redeem_status = 1;
                $customer->redeem_date = DATE('Y-m-d H:i:s');
                $customer->service_user_id = Auth::user()->employee_id;
                $customer->redeem_amount = $request->discounted_amount;
                $customer->spare_amount = $request->spare_amount;
                $customer->tax = $request->tax;
                $customer->labour_amount = $request->labour_amount;
                $customer->total_amount = $request->spare_amount + $request->labour_amount + $request->tax-$request->discounted_amount;
                $customer->mobile2 = $request->mobile2;
                $customer->save();

                DB::commit();
                return ['status'=>1, 'response'=>"Redeemed Successfully"];
            }  catch(\Exception $e) 
            {
                DB::rollBack();
                return ['status'=>0, 'response'=>"Couldn't redeeem this referral"];
            }
        }
        else
            return ['status'=>0, 'response'=>'Referral Code already redeemed'];
    }
    else
        return ['status'=>0, 'response'=>'Invalid Referral'];



}
public function print_receipt($referral_code)
{
   $customer = Customer::where([
      ['referral_code',$referral_code],
      ['redeem_status',1],
      ['status',0]
  ])->with([
      'campaign' => function($query) {
         $query->where('status', 0);
         $query->select('campaign_id','name');
     }
 ])->orderBy('redeem_date','DESC')->first();

  if($customer){
      return view('exports.receipt')->with('customer',$customer);
  }
  else
      return false;
}
}
