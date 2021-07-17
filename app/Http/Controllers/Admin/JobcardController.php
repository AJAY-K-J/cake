<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Jobcard;
use App\Models\Image;
use App\Models\Employee;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\CustomerCategory;
use App\Models\Company;
use App\Models\CustomerTechnician;
use App\Models\CustomerCall;
use App\Models\VehicleMake;
use App\Models\UploadLog;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use PDF;
use App\Http\Controllers\SMS;
use App\Models\SmsSetting;
use Auth;
use Session;


class JobcardController extends Controller
{
    public function index()

    {
        if(Input::has('company_id'))
            {
                $comp_id= Input::get('company_id');

            }
            else{
                $comp_id=Auth::user()->company_id;
            }
            $services = Service::where([['status','0'],['company_id', $comp_id]])
            ->orderBy('name')->get();
            $technicians = Employee::where([['status','0'],['employee_type','2'],['company_id', $comp_id]])
            ->orderBy('name')->get();
            $jobadvisors = Employee::where([['status','0'],['employee_type','1'],['company_id', $comp_id]])
            ->orderBy('name')->get();
            $vehiclemakes = VehicleMake::where('status','0')->whereIn('company_id',[$comp_id,0])->orderBy('name')->orderBy('name')->get();
            $categories = Category::where('status','0')->whereIn('company_id',[$comp_id,0])->orderBy('name')->orderBy('name')->get();

             $products = Product::where([['status','0'],['company_id',Auth::user()->company_id]])->orderBy('name')->get();  
            return view('admin.jobcards',compact('services','vehiclemakes','jobadvisors','technicians','categories','comp_id','products'));

        }

        public function get_jobcards(Request $request)
        {
            

            if($request->type == 'active')
            {
                if($request->search)
                {

                    $jobcards = Customer::with('jobcards','images','customercategories','techniciantimings','techniciantimings.technician','followupcalls')->where([['status','0'],['jobcard_no',$request->search]])->whereIn('type',[3,4])->get();

                    if(count($jobcards)==0)
                    {
                        $jobcards = Customer::with('jobcards','images','customercategories','techniciantimings','techniciantimings.technician','followupcalls')->where([['status','0'],['mobile',$request->search]])->whereIn('type',[3,4])->orderBy('id','desc')->get();

                    }

                    return  $jobcards;


                }else{
                    $jobcards = Customer::with('jobcards','images','customercategories','techniciantimings','techniciantimings.technician','followupcalls')->where([['status','0'],['reg_status',0],['return_status',0]])->whereIn('type',[3,4])->orderBy('id','desc')->get();
                    return  $jobcards;
                }
                
            }
            else
            {
                if($request->search)
                {
                    $jobcards = Customer::with('jobcards','images','customercategories','techniciantimings','techniciantimings.technician','followupcalls')->where([['status','0'],['jobcard_no',$request->search]])->whereIn('type',[3,4])->get();

                    if(count($jobcards)==0)
                    {
                     $jobcards = Customer::with('jobcards','images','customercategories','techniciantimings','techniciantimings.technician','followupcalls')->where([['status','0'],['mobile',$request->search]])->whereIn('type',[3,4])->orderBy('id','desc')->get();

                 }

                 return  $jobcards;
             }
             else
             {

                $jobcards = Customer::with('jobcards','images','customercategories','techniciantimings','techniciantimings.technician','followupcalls')->where([['status','0'],['reg_status',1]])->whereIn('type',[3,4])->orderBy('completed_date','desc')->get();
                return  $jobcards;
            }
        }


    }

    public function find_jobcard($id)
    {
        $booking = Customer::where('id',$id)->first();
        if($booking->sale_status==0)
        {
             $jobcard = Customer::with('jobcards','images','advisor','customercategories','customercategories.category',
            'customercategories.catremark','jobcards.service','jobcards.technician')->where('id',$id)->first();
        }
        else
        {
            $jobcard = Customer::with('receipts','advisor')->where('id',$id)->first();
        }
       
        return  $jobcard;
    }

    public function delete_jobcard(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $customer = Customer::find($request->id);
        $newjc= $customer->jobcard_no;
        $customer->status = -1;
        $customer->save();

        $table="jobcards_".Auth::user()->company->id; 
        DB::table($table)->where('jobcard_no',  $newjc)
        ->delete();

        $techtable="customertechnicians_".Auth::user()->company->id; 
        DB::table($techtable)->where('jobcard_no',  $newjc)
        ->delete();

        $calltable="calls_".Auth::user()->company->id; 
        DB::table($calltable)->where('jobcard_no',  $newjc)
        ->delete();

        $cattable="customercategories_".Auth::user()->company->id; 
        DB::table($cattable)->where('jobcard_no',  $newjc)
        ->delete();
    }
    public function print_jobcard($id)
    {
        $customer = Customer::where([
         ['id',$id],
         ['status',0]
     ])->with(['customercategories','customercategories.category','customercategories.catremark','advisor'])->first();
        if(Input::has('company_id'))
        {
            $company_id = Input::get('company_id');
            $company=Company::find($company_id);

        }
        else
        {
          $company= Auth::user()->company;
        }
       

        if($customer){

            $pdf = PDF::loadView('exports.printjobcard', ['company'=>$company,'customer'=>$customer,'logo'=>$company->logo])->setPaper('a5', 'potrait');
            $filename = uniqid();
            $filename='BILL_'.date('YmdHis').'.pdf';
            return $pdf->stream($filename);

        }
        else
         return false;
 }
 public function print_bill($id)
 {

    $customer = Customer::where([
     ['id',$id],
     ['status',0]
 ])->with(['jobcards','jobcards.technician','advisor'])->first();
    if(Input::has('company_id'))
    {
        $company_id = Input::get('company_id');
        $company=Company::find($company_id);

    }
    else
    {
      $company= Auth::user()->company;
    }
    

    if($customer){

        $pdf = PDF::loadView('exports.printbill', ['company'=>$company,'customer'=>$customer,'logo'=>$company->logo])->setPaper('a5', 'potrait');
        $filename = uniqid();
        $filename='BILL_'.date('YmdHis').'.pdf';
        return $pdf->stream($filename);

    }
    else
     return false;
}

public function return_delivered($id)
{

    $customer = Customer::where(
     'id',$id
 )->first();

    $customer->reg_status=2;
    $customer->delivered_date=date('Y-m-d H:i:s');   
    $customer->save();
    $deliveries = Customer::with(['jobcards','customercategories','customercategories.category','customercategories.catremark','advisor'])->where([['status','0'],['return_status',1]]);
    $deliveries= $deliveries->get();

    return view('reports.return_list',compact('deliveries'));

}
public function return_delivered_from_jobcard(Request $request)
{


    $customer = Customer::find($request->id);

    $customer->reg_status=2;
    $customer->delivered_date=date('Y-m-d H:i:s');   
    $customer->save();


    return ['status'=>1,'response'=>'Success'];

}

public function upload_image(Request $request)
{
    $image = new Image;
    $filepath='company_'. Auth::user()->company_id.'/uploads';
    $path = Storage::disk('public')->putFileAs($filepath, $request->file('image'), Str::uuid().'-'.$request->file('image')->getClientOriginalName());
    $image->image_path = $path;
    $image->jobcard_no=$request->upload_id;
    $image->type=1;
    $image->save();
}

public function delete_image(Request $request)
{
    $image = Image::findOrFail($request->id);
    Storage::disk('public')->delete($image->image_path);
    $image->delete();
    return ['status'=>1];
}

public function get_images(Request $request)
{
    $images = Image::where('jobcard_no', $request->jobcard_no)->get();
    return  $images;
}


public function add_technician(Request $request)
{
    if(!$request->technician_id)
    {
        return 'Error';
    }
    $customertechnician = new CustomerTechnician;
    $customertechnician->jobcard_no=$request->jobcard_no;
    $customertechnician->technician_id=$request->technician_id;
    $customertechnician->start_time=date('Y-m-d H:i:s');
    $customertechnician->save();

    $customer=Customer::where([['jobcard_no',$request->jobcard_no],['status',0]])->first();
    $customer->technician_status=1;
    $customer->save();

    return 'Success';
}

public function add_followup(Request $request)
{
    
    $followup = new CustomerCall;
    $followup->jobcard_no=$request->jobcard_no;
    $followup->remarks=$request->call_remarks;
    $followup->call_status=$request->call_status;
    $followup->save();

    return 'Success';
}

public function receive_technician(Request $request)
{

    $customertechnician = CustomerTechnician::where('jobcard_no',$request->jcno)->orderBy('id','desc')->first();
    $customertechnician->end_time=date('Y-m-d H:i:s');
    $customertechnician->save();

    $customer=Customer::where([['jobcard_no',$request->jcno],['status',0]])->first();
    $customer->technician_status=2;
    $customer->save();
    return 'Success';
}
public function mark_holded(Request $request)
{
    if(!$request->holding_remarks)
    {
        return 'Error';
    }
    $customer=Customer::where([['jobcard_no',$request->jcno],['status',0]])->first();
    $customer->holding_status=1;
    $customer->holding_remarks=strtoupper($request->holding_remarks);
    $customer->holding_date=date('Y-m-d H:i:s');
    $customer->save();
    return 'Success';
}
public function mark_return(Request $request)
{
    if(!$request->return_remarks)
    {
        return 'Error';
    }

    $customer=Customer::where([['jobcard_no',$request->jcno],['status',0]])->first();
    $customer->return_status=1;
    $customer->return_remarks=strtoupper($request->return_remarks);
    $customer->return_date=date('Y-m-d H:i:s');
    $customer->save();
    return 'Success';
}
public function add_list(Request $request)
{
    $customer = Customer::find($request->id);
    $customer->renter_date=date('Y-m-d H:i:s');
    if($customer->reg_status==2)
    {
       
        $new_customer=$customer->replicate();
        $new_customer->type=3;
        $new_customer->return_status=0;
        $new_customer->reg_status=0;
        $new_customer->renter_status=1;
        $new_customer->reenter_jobcard_no=$customer->id;
        $customer->status=1;
        $new_customer->save();
    }
    else
    {
        $customer->type=3;
        $customer->return_status=0;
        $customer->reg_status=0;
        
    }
   
    
    $customer->save();
    return 'Success';
}
public function add_adminlist(Request $request)
{
   
    
            
   
    $table="customers_".$request->comp_id;
    $customer = DB::table($table)->where('id',$request->id)->update(['delivered_date' => NULL,'reg_status'=>1]);
   
    return 'Success';
}
public function mark_returnback(Request $request)
{


    $customer=Customer::where([['jobcard_no',$request->jcno],['status',0]])->first();
    $customer->return_status=0;
    $customer->return_remarks='';
    $customer->save();
    return 'Success';
}
public function release_hold(Request $request)
{
    $customer=Customer::where([['jobcard_no',$request->jcno],['status',0]])->first();
    $customer->holding_status=0;
    $customer->holding_remarks='';
    $customer->save();
    return 'Success';
}
public function add_jobcard(Request $request)
{

   
 $serial_no =  preg_replace('/[^A-Za-z0-9]/', '', strtoupper($request->serial_no));

 if($request->id){
    $customer = Customer::find($request->id);
    $newjc= $customer->jobcard_no;

    Jobcard::where('jobcard_no',  $newjc)
    ->delete();
    CustomerCategory::where('jobcard_no',  $newjc)
    ->delete();
}
else 
{
    $customer = new Customer;
    $lastobject = Customer::where([['sale_status',0],['renter_status',0]])->whereIn('type',[3,4])->latest('id')->first();
    if($lastobject)
        $lastjcno=$lastobject->jobcard_no;
    else
        $lastjcno=0;
    do{


    $newjc=$lastjcno+1;
    $job= Customer::where('jobcard_no',$newjc)->whereIn('type',[3,4])->latest('id')->first();
    }while($job);
    

}


$capsname= strtoupper($request->name);
$customer->name= $capsname;
$customer->jobcard_prefix=Auth::user()->company->jobcard_prefix;
$customer->serial_no= $serial_no;
$customer->location= strtoupper($request->location);
$customer->make= strtoupper($request->make);
$customer->item_type= $request->item_type;
$customer->item_size= $request->item_size;
if($request->item_type)
   $customer->recovery=1; 
$customer->model= strtoupper($request->model);
$customer->remarks= strtoupper($request->remarks);
$customer->mobile= $request->mobile;
if($request->mobile2)
$customer->mobile2= $request->mobile2;
$customer->jobadvisor_id=$request->jobadvisor_id;
$customer->type= 3;
$customer->dealer= $request->dealer;
$customer->jobcard_no= $newjc;
$customer->customer_voice=strtoupper($request->customer_voice);
if($request->technician_voice)
    $customer->technician_voice=strtoupper($request->technician_voice);
if($request->estimate_amount)
$customer->estimate_amount=$request->estimate_amount;
else
    $customer->estimate_amount=0;
if($request->hasFile('signature')) {
    $old_image = $customer->signature_path;
    $filepath='company_'. Auth::user()->company_id.'/uploads/signatures';
    $path = Storage::disk('public')->putFileAs($filepath, $request->file('signature'), Str::uuid().'-'.time().'.jpg');
    $customer->signature_path = $path;
    if($old_image)
     Storage::disk('public')->delete($old_image);
}


$items = json_decode($request->items,TRUE);
$tot_rate=0;
foreach ($items as $item){ 

 $jobcard = new Jobcard;
 if(isset($item['service_string'])){
    $jobcard->service_string=strtoupper($item['service_string']);
    $product = Product::where('name',$item['service_string'])->first();
       if(!empty($product)){
        $stock = Stock::where([['status',0],['product_id',$product->id],['company_id',Auth::user()->company_id]])->first();
        
        if($stock->qty<$item['qty']){
           return ['product'=>$item['service_string'],'qty'=>$stock->qty,'response'=>'no stock'];
        }
        else{
           $stock->qty=$stock->qty - $item['qty'];  
        }
        $stock->save();
       }
 }              
 $jobcard->jobcard_no= $newjc;
 $jobcard->qty=$item['qty'];
 $jobcard->rate=$item['rate'];
 $jobcard->labour=$item['labour'];
 $tot_rate=$tot_rate+$item['rate'];
 if(isset($item['technician_id']))
     $jobcard->technician_id=$item['technician_id'];
 if(isset($item['service_id']))
    $jobcard->service_id=$item['service_id'];

$jobcard->save();
}

$customercategories = json_decode($request->customercategories,TRUE);
foreach ($customercategories as $item){ 

 $customercategory = new CustomerCategory;
 $customercategory->jobcard_no= $newjc;
 $customercategory->category_id=$item['category_id'];
 $customercategory->catremark_id=$item['catremark_id'];
 $customercategory->save();
}

if($request->bag=="true")
    $customer->bag= 1;
else
    $customer->bag=$request->bag;
if($request->charger=="true")
    $customer->charger= 1;
else
    $customer->charger=$request->charger;
if($request->battery=="true")
    $customer->battery= 1;
else
    $customer->battery=$request->battery;
if($request->sim=="true")
    $customer->sim= 1;
else
    $customer->sim=$request->sim;
if($request->dvd_drive=="true")
    $customer->dvd_drive= 1;
else
    $customer->dvd_drive=$request->dvd_drive;
if($request->without_warranty=="true")
    $customer->without_warranty= 1;
else
    $customer->without_warranty=$request->without_warranty;
if($request->with_warranty=="true")
    $customer->with_warranty= 1;
else
    $customer->with_warranty=$request->with_warranty;
if($request->customer_dead_risk=="true")
    $customer->customer_dead_risk= 1;
else
    $customer->customer_dead_risk=$request->customer_dead_risk;
$customer->reenter_jobcard_no=$request->renter_jobcard_no;
$customer->spare_amount=$tot_rate;
$customer->labour_amount=$request->total_labour?$request->total_labour:0;
$customer->discount=$request->discount?$request->discount:0;
$customer->total_amount=$customer->spare_amount+$customer->labour_amount-$customer->discount;

if($request->id)
{
    $customer->save();
    return 'Success';
}
else{
    $station= Auth::user()->company->sms;         
    $booking_sms=  $station->booking_sms;
    $jccc=$customer->jobcard_prefix.$newjc;
    $a = ['#NAME#','#SERVICE#','#JOBCARD#'];
    $b = [$capsname,"service",$jccc];
    $message = str_replace($a,$b,$booking_sms);
    SMS::send($message,$request->mobile,$station->sender_id,$station->api);
    $customer->save();
    return 'Success';
}   

}
public function mark_jobcardcompleted(Request $request)
{

 $booking = Customer::find($request->id);

 if($booking)
 {
    $booking->reg_status=1;
    $booking->completed_date=date('Y-m-d H:i:s');
    $booking->save();
    $station= Auth::user()->company->sms;

    $booking_sms=  $station->completion_sms;


    $service= DB::table('services')->where([['id', $booking->service_type],['status',0]])->first();
    $a = ['#NAME#','#REGNO#','#SERVICE#','#AMOUNT#'];
    $b = [$booking->name,$booking->reg_no, 'service',$booking->total_amount];
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

public function mark_jobcarddelivered(Request $request)
{
    $booking = Customer::find($request->id);
    if($booking)
    {

        $booking->reg_status=2;
        if($request->delivery_date)
        {
            $booking->delivered_date=$request->delivery_date;
        }
        else{
                  $booking->delivered_date=date('Y-m-d H:i:s');
        }

        $booking->payment_type=$request->payment_type;
        $booking->type=3;
        $booking->save();

        return ['status'=>1,'response'=>'Success'];
        
   }
   else
   {
        return ['status'=>0,'response'=>'Error'];
    }
}

public function mark_jobcardcreditdelivered(Request $request)
{
   
    $booking = Customer::find($request->id);
    if($booking)
    {
        $booking->reg_status=2;
        if($request->delivery_date)
        {
            $booking->delivered_date=$request->delivery_date;
        }
        else{
                  $booking->delivered_date=date('Y-m-d H:i:s');
         }
            
        $booking->type=4;
        $booking->save();
        return ['status'=>1,'response'=>'Success'];
        
        }

   else
   {
        return ['status'=>0,'response'=>'Error'];
    }

}

public function mark_adminjobcarddelivered(Request $request)
{

    if($request->company_id!=null)
    {
        $table='customers_'.$request->company_id;
        DB::table($table)->where('id', $request->id)->update(['reg_status' => 2, 'type'=>3]);
        if($request->delivery_date)
             DB::table($table)->where('id', $request->id)->update(['delivered_date' => $request->delivery_date]);
         if($request->payment_type)
            DB::table($table)->where('id', $request->id)->update(['payment_type' => $request->payment_type]);
          return ['status'=>1,'response'=>'Success'];

    }
    else
    {   
         $booking = Customer::find($request->id);
         
    }
    if($booking)
    {

        $booking->reg_status=2;
        if($request->delivery_date)
        {
            $booking->delivered_date=$request->delivery_date;
        }
        else{
                  $booking->delivered_date=date('Y-m-d H:i:s');
        }

        $booking->payment_type=$request->payment_type;
        $booking->type=3;
        $booking->save();

        return ['status'=>1,'response'=>'Success'];
        
   }
   else
   {
        return ['status'=>0,'response'=>'Error'];
    }
}

public function mark_adminjobcardcreditdelivered(Request $request)
{
    if($request->company_id)
    {
        $table='customers_'.$request->company_id;
        DB::table($table)->where('id', $request->id)->update(['reg_status' => 2, 'type'=>4]);
        if($request->delivery_date)
             DB::table($table)->where('id', $request->id)->update(['delivered_date' => $request->delivery_date]);
          return ['status'=>1,'response'=>'Success'];

    }
    else
    {
         $booking = Customer::find($request->id);
    }
    if($booking)
    {
        $booking->reg_status=2;
        if($request->delivery_date)
        {
            $booking->delivered_date=$request->delivery_date;
        }
        else{
                  $booking->delivered_date=date('Y-m-d H:i:s');
         }
            
        $booking->type=4;
        $booking->save();
        return ['status'=>1,'response'=>'Success'];
        
        }

   else
   {
        return ['status'=>0,'response'=>'Error'];
    }

}



public function send_otp(Request $request)
{
    $request->validate([
        'id' => 'required',
        'mobile' => 'required',
    ]);

    $otp = rand(1000,9999);

    $mobile = $request->mobile;
    $id = $request->id;

    $now = Carbon::now();
    $expiry = $now->addMinutes(5);
    $session = [
        'OTP' => $otp,
        'EXPIRY' => $expiry,
        'ID' => $id,
        'MOBILE' => $mobile,

    ];
    
    $station= Auth::user()->company->sms;
    $booking_sms=  $station->delivery_sms;
    $a = ['#NAME#','#OTP#'];
    $b = ['Customer',$otp];
    $message = str_replace($a,$b,$booking_sms);    

    Session::put('OTP',$session);
    
    SMS::send($message,$mobile,$station->sender_id,$station->api);   
    return ['status'=>1, 'response'=>"SMS sent to $mobile"];
}

public function verify_otp(Request $request)
{
    $request->validate([
        'id' => 'required',
        'mobile' => 'required',
        'otp' => 'required',
        'payment_type' => 'required',
    ]);

    $customer = Customer::where('status',0)->findOrfail($request->id);
    $customer->payment_type = $request->payment_type;
    if(Session::has('OTP'))
    {
        $session = Session::get('OTP');
        $now = Carbon::now();
        if($session['EXPIRY'] > $now)
        {
            $mobile = $request->mobile2 ? $request->mobile2 : $request->mobile;
            if($session['OTP']==$request->otp && $session['ID']==$request->id && $session['MOBILE']==$mobile)
            {
                Session::forget('OTP');

                if($request->mobile2) {
                    $customer->mobile2 = $request->mobile2;
                    $customer->save();
                }
                return ['status'=>1, 'response'=>"Verified"];
            }
            else
                return ['status'=>0, 'response'=>'Invalid OTP'];
        }
        else
            return ['status'=>0, 'response'=>'OTP Expired'];
    }
    else
        return ['status'=>0,'response'=>'Invalid OTP'];
}
}
