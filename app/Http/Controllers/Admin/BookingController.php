<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\VehicleMake;
use App\Models\UploadLog;
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


class BookingController extends Controller
{
    public function index()

    {
        $services = Service::where([['status','0'],['company_id',Auth::user()->company_id,0]])
        ->get();
        $vehiclemakes = VehicleMake::where('status','0')->whereIn('company_id',[Auth::user()->company_id,0])->orderBy('name')->get();

        return view('admin.bookings',compact('services','vehiclemakes'));
    }

    public function get_bookings(Request $request)
    {

        if($request->type == 'active')
        {
            $bookings = Customer::with('service')->where([['status','0'],['reg_status',0],['type','2']])->get();
            return  $bookings;
        }
        else
        {
            $bookings = Customer::with('service')->where([['status','0'],['reg_status',1],['type','2']])->get();
            return  $bookings;
        }
        

    }
    public function delete_booking(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $customer = Customer::find($request->id);
        $customer->status = -1;
        $customer->save();

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
    public function mark_completed(Request $request)
    {

     $api= Auth::user()->company->sms->api;
     $balance=SMS::getBalance($api);
     $booking = Customer::find($request->id);

     if($balance>0)
     {
         if($booking)
         {
            $booking->reg_status=1;
            $booking->completed_date=date('Y-m-d H:i:s');
            $booking->save();
            $station= Auth::user()->company->sms;
            $booking_sms=  $station->completion_sms;

            $service= DB::table('services')->where([['id', $booking->service_type],['status',0]])->first();
            $a = ['#NAME#','#REGNO#','#SERVICE#'];
            $b = [$booking->name,$booking->reg_no, $service->name];
            $message = str_replace($a,$b,$booking_sms);    
            try{
              SMS::send($message,$booking->mobile,$station->sender_id,$station->api);   
                }
            catch(Exception $e)
            {

             }

            return ['status'=>1,'response'=>'Success'];
        }
        else
        {
          return ['status'=>0,'response'=>'Error'];
        }
    }
    else
    {
        return ['status'=>0,'response'=>'Low SMS Credit, Please Top Up SMS'];
    }
}

public function mark_delivered(Request $request)
{
   
    $api= Auth::user()->company->sms->api;
    //$balance=0;
    $balance=SMS::getBalance($api);
    $booking = Customer::find($request->id);
    if( $balance>0)
    {
        if($booking)
        {
            $booking->reg_status=2;
            $booking->total_amount=$request->amount;
            $booking->delivered_date=date('Y-m-d H:i:s');
            $booking->save();
            $station= Auth::user()->company->sms;
            $booking_sms=  $station->delivery_sms;
            
            $service= DB::table('services')->where([['id', $booking->service_type],['status',0]])->first();
            
          $a = ['#NAME#','#REGNO#','#SERVICE#','#AMOUNT#'];
          $b = [$booking->name,$booking->reg_no, $service->name,$request->amount];
            $message = str_replace($a,$b,$booking_sms);    
            try
            {
               SMS::send($message,$booking->mobile,$station->sender_id,$station->api);   
            }
            catch(Exception $e)
            {

            }
            return ['status'=>1,'response'=>'Success'];
        }
        else
        {
            return ['status'=>0,'response'=>'Error'];
        }

    }
    else
    {
        return ['status'=>0,'response'=>'Low SMS Credit, Please Top Up SMS'];
    }
   

}
public function mark_creditdelivered(Request $request)
{
   
    $api= Auth::user()->company->sms->api;
    //$balance=0;
    $balance=SMS::getBalance($api);
    $booking = Customer::find($request->id);
    if( $balance>0)
    {
        if($booking)
        {
            $booking->reg_status=2;
            $booking->type=4;
            $booking->total_amount=$request->amount;
            $booking->delivered_date=date('Y-m-d H:i:s');
            $booking->save();
            $station= Auth::user()->company->sms;
            $booking_sms=  $station->delivery_sms;
            
            $service= DB::table('services')->where([['id', $booking->service_type],['status',0]])->first();
            
           $a = ['#NAME#','#REGNO#','#SERVICE#','#AMOUNT#'];
          $b = [$booking->name,$booking->reg_no, $service->name,$request->amount];
            $message = str_replace($a,$b,$booking_sms);    
            try
            {
               SMS::send($message,$booking->mobile,$station->sender_id,$station->api);   
            }
            catch(Exception $e)
            {

            }
            return ['status'=>1,'response'=>'Success'];
        }
        else
        {
            return ['status'=>0,'response'=>'Error'];
        }

    }
    else
    {
        return ['status'=>0,'response'=>'Low SMS Credit, Please Top Up SMS'];
    }
   

}

public function add_booking(Request $request)
{
    $request->validate([
        'name' => 'required',
        'mobile' => 'required',
        'location' => 'required',
        'make' => 'required',
        'model' => 'required',
        'reg_no' => 'required',
        'service_type' => 'required|exists:services,id',

    ]);
    $api= Auth::user()->company->sms->api;
    //$balance=0;
    $balance=SMS::getBalance($api);
    if($balance>0)
    {
            $customer = new Customer;
            $customer->name= $request->name;
            $customer->customer_id= $request->customer_id;
           // $customer->reg_no= $request->reg_no;
            $reg_no = str_replace(" ", "", $request->reg_no);
            $reg_no = str_replace("-", "", $reg_no);
            $customer->reg_no= $reg_no;
            $customer->location= $request->location;
            $customer->make= $request->make;
            $customer->model= $request->model;

            $service= DB::table('services')->where([['id', $request->service_type],['status',0]])->first();

            $customer->service_type = $request->service_type;
            $customer->service_string=$service->name;
            $customer->remarks= $request->remarks;
            $customer->mobile= $request->mobile;
            $customer->type= 2;
            $customer->save();
            
            $station= Auth::user()->company->sms;
            $booking_sms=  $station->booking_sms;
            
           
            $a = ['#NAME#','#REGNO#','#SERVICE#'];
            $b = [$request->name,$request->reg_no, $service->name];
            $message = str_replace($a,$b,$booking_sms);    
            try
            {
               SMS::send($message,$request->mobile,$station->sender_id,$station->api);   
             }
            catch(Exception $e)
            {

            }
         
            return 'Success';

    }
    else
    {
        return 'NoSMS';
    }

}


}
