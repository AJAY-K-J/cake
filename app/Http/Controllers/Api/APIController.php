<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Models\Service;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\Thankyoulog;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Api\ApiHelper;
use App\Http\Controllers\Controller;
use App\Station;
use Auth;
use DB;
use App\Http\Controllers\SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\StationController;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    use ApiHelper;
    public function add_expense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'expensecategory' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
        }

        $expense = new Expense;
        $expense->name = $request->name;
        $expense->expensecategory = $request->expensecategory;
        $expense->amount = $request->amount;
        $expense->company_id = Auth::user()->company_id;
        $expense->save();
        return $this->sendResponse(true,[],'Expense Added Successfully',200);
    }


    public function create_booking(Request $request)
    {
       $api=Auth::user()->company->sms->api;
       $balance = SMS::getBalance($api);
       if($balance >0)
          $expiry = 0;
      else
          $expiry = 1;
      if($expiry!=1)
      {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile_no' => 'required',
            'location' => 'required',
            'make' => 'required',
            'model' => 'required',
            'register_no' => 'required',
            'service' => 'required',
        ]);
                //return $request;

        if($validator->fails()){
            return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
        }

        $customer = new Customer;
        $customer->name = $request->name;
        $customer->mobile = $request->mobile_no;
        $customer->location = $request->location;
        $make=VehicleMake::where([['name', strtoupper($request->make)],['status',0]])->whereIn('company_id',[Auth::user()->company->id,0])->first();

        if(!$make)
        {
            $make = new VehicleMake;

            $make->name = strtoupper($request->make);
            $make->company_id = Auth::user()->company_id;
            $make->save();
            $model = new VehicleModel;
            $model->name = strtoupper($request->model);
            $model->make_id = $make->id;
            $model->company_id = Auth::user()->company_id;
            $model->save();
        }
        else {
          $model=VehicleModel::where([['name',strtoupper($request->model)],['status',0]])->whereIn('company_id',[Auth::user()->company->id,0])->first();
          if(!$model)
          {
            $model = new VehicleModel;

            $model->name = strtoupper($request->model);
            $model->make_id = $make->id;
            $model->company_id = Auth::user()->company_id;
            $model->save();
        }
    }

    $customer->make = strtoupper($request->make);
    $customer->model = strtoupper($request->model);
    $customer->color = $request->color;
    $customer->reg_no =  preg_replace('/[^A-Za-z0-9]/', '', strtoupper($request->register_no));
    $customer->created_at = DATE('Y-m-d H:i:s');
    $service = DB::table('services')->where([['name', $request->service],['status',0],['company_id',Auth::user()->company->id]])->first();
    $customer->service_type = $service->id;
    $customer->service_string=$service->name;
    $customer->remarks=$request->remarks;
    $customer->type=2;
    $regno= preg_replace('/[^A-Za-z0-9]/', '', strtoupper($request->register_no));
    $customer->save();

    $data = [
        "data" => ["order_id"=>$customer->id]
    ];
    $station= Auth::user()->company->sms;
    $booking_sms=  $station->booking_sms;

    $a = ['#NAME#','#REGNO#','#SERVICE#'];
    $b = [$request->name,$regno, $service->name];
    $message = str_replace($a,$b,$booking_sms);   


    try{
     SMS::send($message,$request->mobile_no,$station->sender_id,$station->api);

 }
 catch(Exception $e)
 {

 }

 return $this->sendResponse(true,["order_id"=>$customer->id],'Booking Saved Successfully',200);
}
else
{
    return $this->sendResponse(false,[],'SMS Expired, Please topup SMS',200);
}


}


    public function create_thankyou(Request $request)
    {
       $api=Auth::user()->company->sms->api;
       $balance = SMS::getBalance($api);
       if($balance >0)
          $expiry = 0;
      else
          $expiry = 1;
      if($expiry!=1)
      {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile_no' => 'required',
            'register_no' => 'required',
            'service' => 'required',
         
        ]);
                //return $request;

        if($validator->fails()){
            return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
        }

        $customer = new Thankyoulog;
        $customer->name = $request->name;
        $customer->mobile = $request->mobile_no;
        $customer->company_id = Auth::user()->company->id;
        $customer->location = $request->location;
        $make=VehicleMake::where([['name', strtoupper($request->make)],['status',0]])->whereIn('company_id',[Auth::user()->company->id,0])->first();

        if(!$make)
        {
            $make = new VehicleMake;

            $make->name = strtoupper($request->make);
            $make->company_id = Auth::user()->company_id;
            $make->save();
            $model = new VehicleModel;
            $model->name = strtoupper($request->model);
            $model->make_id = $make->id;
            $model->company_id = Auth::user()->company_id;
            $model->save();
        }
        else {
          $model=VehicleModel::where([['name',strtoupper($request->model)],['status',0]])->whereIn('company_id',[Auth::user()->company->id,0])->first();
          if(!$model)
          {
            $model = new VehicleModel;

            $model->name = strtoupper($request->model);
            $model->make_id = $make->id;
            $model->company_id = Auth::user()->company_id;
            $model->save();
        }
    }

    $customer->make = strtoupper($request->make);
    $customer->model = strtoupper($request->model);
    $customer->reg_no =  preg_replace('/[^A-Za-z0-9]/', '', strtoupper($request->register_no));
    $customer->created_at = DATE('Y-m-d H:i:s');
    $service = DB::table('services')->where([['name', $request->service],['status',0],['company_id',Auth::user()->company->id]])->first();
    $customer->service_type = $service->id;
    $customer->service_string=$service->name;
    $regno= preg_replace('/[^A-Za-z0-9]/', '', strtoupper($request->register_no));
    $customer->save();

    $data = [
        "data" => ["order_id"=>$customer->id]
    ];
    $station= Auth::user()->company->sms;
    $booking_sms=  $station->thankyou_sms;

    $a = ['#NAME#','#REGNO#','#SERVICE#'];
    $b = [$request->name,$regno, $service->name];
    $message = str_replace($a,$b,$booking_sms);   


    try{
     SMS::send($message,$request->mobile_no,$station->sender_id,$station->api);

 }
 catch(Exception $e)
 {

 }

 return $this->sendResponse(true,["order_id"=>$customer->id],'Thankyou Message Delivered Successfully',200);
}
else
{
    return $this->sendResponse(false,[],'SMS Expired, Please topup SMS',200);
}


}

public function mark_completed(Request $request)
{
  $validator = Validator::make($request->all(), [
     'order_id' => 'required',
 ]);

  if($validator->fails()){
     return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
 }
 $api=Auth::user()->company->sms->api;
 $balance = SMS::getBalance($api);
 if($balance >0)
    $expiry = 0;
else
    $expiry = 1;
if($expiry!=1)
{
    $customer = Customer::where('status',0)->find($request->order_id);
    if($customer) {
        $customer->completed_date = DATE('Y-m-d H:i:s');
        $customer->reg_status = 1;
        $customer->save();
        
        $station= Auth::user()->company->sms;
        $completion_sms=  $station->completion_sms;

        $service= DB::table('services')->where([['id', $customer->service_type],['status',0]])->first();

        $a = ['#NAME#','#REGNO#','#SERVICE#'];
        $b = [$customer->name,$customer->reg_no,$service->name];
        $message = str_replace($a,$b,$completion_sms);
        try{
         SMS::send($message,$customer->mobile,$station->sender_id,$station->api);

     }
     catch(Exception $e)
     {

     }

     return $this->sendResponse(true,[],'Service Completed Successfully');
 } else {
    return $this->sendResponse(false,[],'Invalid order id',404);
}
}
else
{
    return $this->sendResponse(false,[],'SMS Expired, Please topup SMS',200);
}

}

public function mark_delivered(Request $request)
{
  $validator = Validator::make($request->all(), [
     'order_id' => 'required',
     'amount' => 'required',
 ]);

  if($validator->fails()){
     return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
 }
 $api= Auth::user()->company->sms->api;
 $balance=SMS::getBalance($api);
 if($balance >0)
{
    $customer = Customer::where('status',0)->find($request->order_id);

    if($customer) {
        $customer->total_amount = $request->amount;
        $customer->reg_status = 2;
        $customer->delivered_date = DATE('Y-m-d H:i:s');
        $customer->save();

        $station= Auth::user()->company->sms;
        $delivery_sms=  $station->delivery_sms;

        $service= DB::table('services')->where([['id', $customer->service_type],['status',0]])->first();


        $a = ['#NAME#','#REGNO#','#SERVICE#','#AMOUNT#'];
        $b = [$customer->name,$customer->reg_no,$service->name,$request->amount];
        $message = str_replace($a,$b,$delivery_sms);
        try{
         SMS::send($message,$customer->mobile,$station->sender_id,$station->api);

     }
     catch(Exception $e)
     {

     }
     return $this->sendResponse(true,[],'Vehicle Delivered Successfully');
 } else {
    return $this->sendResponse(false,[],'Invalid order id',404);
}
}
else
{
    return $this->sendResponse(false,[],'SMS Expired, Please topup SMS',200);
}

}
public function mark_creditdelivered(Request $request)
{
  $validator = Validator::make($request->all(), [
     'order_id' => 'required',
     'amount' => 'required',
 ]);

  if($validator->fails()){
     return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
 }
 $api= Auth::user()->company->sms->api;
 $balance=SMS::getBalance($api);
if($balance>0)
{
    $customer = Customer::where('status',0)->find($request->order_id);

    if($customer) {
        $customer->total_amount = $request->amount;
        $customer->type = 4;
        $customer->reg_status = 2;
        $customer->delivered_date = DATE('Y-m-d H:i:s');
        $customer->save();

        $station= Auth::user()->company->sms;
        $delivery_sms=  $station->delivery_sms;

        $service= DB::table('services')->where([['id', $customer->service_type],['status',0]])->first();


        $a = ['#NAME#','#REGNO#','#SERVICE#','#AMOUNT#'];
        $b = [$customer->name,$customer->reg_no,$service->name,$request->amount];
        $message = str_replace($a,$b,$delivery_sms);
        try{
         SMS::send($message,$customer->mobile,$station->sender_id,$station->api);

     }
     catch(Exception $e)
     {

     }
     return $this->sendResponse(true,[],'Vehicle Delivered Successfully');
 } else {
    return $this->sendResponse(false,[],'Invalid order id',404);
}
}
else
{
    return $this->sendResponse(false,[],'SMS Expired, Please topup SMS',200);
}

}

public function pending_booking_lists()
{


  $bookings = Customer::where([
     ['reg_status',0],
     ['status',0],
     ['type',2]
 ])
  ->select('id','name','mobile as mobile_no','location','make','model','color','reg_no as register_no','created_at',
    'service_string as service','remarks')
  ->get();

  return $this->sendResponse(true,['vehicle_list'=>$bookings],'Pending Booking List');
}


public function dashboard()
{    

    $api=Auth::user()->company->sms->api;
    $balance = SMS::getBalance($api);
    if($balance >0)
        $expiry = 0;
    else
        $expiry = 1;
    $today_date=date('Y-m-d');

    $todaybookings = Customer::where('status',0)->whereIn(
         'type',[2,4])
    ->whereDate('created_at','=',$today_date)
    ->get();

    $todayexpenses = Expense::where('status',0)
    ->whereDate('created_at','=',$today_date)
    ->get();

    $todaycredits =Customer::where([
        ['status',0],
        ['type',4]
    ])
        ->whereDate('created_at','=',$today_date)
        ->get();


    $todaycollections = Customer::where([
        ['status',0],
        ['type',2]
    ])
    ->whereDate('delivered_date','=',$today_date)
    ->get();

    $todaycollectionssagainstcredit = Customer::where([
        ['status',0],
        ['type',5]
    ])
    ->whereDate('created_at','=',$today_date)
    ->get();


   

    $totalbookings = Customer::where([
        ['status',0],
        ['type',2]
    ])->get();

    $data = [

        "today_date" => date("d-m-Y", strtotime($today_date)),
        "today_bookings" => $todaybookings->count(),
        "today_delivered" => $todaybookings->where('reg_status',2)->count(),
        "today_amount_collected" => $todaycollections->sum('total_amount')+$todaycollectionssagainstcredit->sum('total_amount'),
        "today_credit_collected" => $todaycredits->sum('total_amount'),
        "today_expenses" => $todayexpenses->sum('amount'),
        "total_pending_delivery" => $totalbookings->where('reg_status',1)->count(),
        "total_pending_completion" => $totalbookings->where('reg_status',0)->count(),
        "balance" => $balance,
        "expiry"=>$expiry
    ];

    return $this->sendResponse(true,$data,'Dashboard',200);
}


public function pending_delivery_lists()
{
  $bookings = Customer::where([
     ['reg_status',1],
     ['status',0],
     ['type',2]
 ])
  ->select('id','name','mobile as mobile_no','location','make','model','color','reg_no as register_no','created_at','service_string as service','remarks','created_at','completed_date as completed_at')
  ->get();

  return $this->sendResponse(true,['vehicle_list'=>$bookings],'Pending Delivery List');
}

public function delivery_lists(Request $request)
{
  $sql = Customer::where([
     ['reg_status',2],
     ['status',0]
 ])->whereIn('type', [2,4])
  ->select('id','name','mobile as mobile_no','location','make','model','color','reg_no as register_no','created_at','service_string as service','remarks','created_at','completed_date as completed_at','delivered_date as delivered_at','total_amount as amount');

        //if($request->delivery_date)
  $today_date=date('Y-m-d');
  $sql->whereDate('delivered_date',$today_date);

  $bookings = $sql->orderBy('delivered_date', 'desc')->get();

  $appends = [
     "Delivery Count" => $bookings->count(),
     "Delivery Date" => $request->delivery_date
 ];

 return $this->sendResponse(true,['vehicle_list'=>$bookings],'Delivery List',200,$appends);
}



public function collection_report(Request $request)
{   
    $validator = Validator::make($request->all(), [
        'start_date' => 'required',
        'end_date' => 'required',
    ]);

    if($validator->fails()) {
        return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
    }

    $bookings = Customer::where([
       ['status',0],
       ['type',2]
   ])
    ->whereDate('delivered_date','>=',$request->start_date)
    ->whereDate('delivered_date','<=',$request->end_date)
    ->select('id','name','mobile as mobile_no','location','make','model','color','reg_no as register_no','service_string as service','remarks','created_at','completed_date as completed_at','delivered_date as delivered_at','total_amount as amount')->where('reg_status',2)
    ->get();

    $appends = [
        "from_date" => $request->start_date,
        "to_date" => $request->end_date,
        "total_amount_collected" => $bookings->where('reg_status',2)->sum('total_amount'),
    ];

    return $this->sendResponse(true,['vehicle_list'=>$bookings],'Complete Report',200,$appends);
}

public function delete_booking(Request $request)
{
  $validator = Validator::make($request->all(), [
     'order_id' => 'required',
 ]);

  if($validator->fails()) {
     return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
 }

 $booking = Customer::where('status',0)->find($request->order_id);
 if($booking) {
     $booking->status = -1;
     $booking->save();
     return $this->sendResponse(true,[],'Booking Deleted');
 }
 else {
     return $this->sendResponse(false,[],'Invalid order id',404);
 }
}

public function find_customer(Request $request) 
{

    $sql = Customer::where('status',0)->whereIn('type',[2,4])->select('id','name','mobile as mobile_no','location','make','model','color','reg_no as register_no','created_at','service_string as service','remarks','created_at','completed_date as completed_at','delivered_date as delivered_at','total_amount as amount');

    if($request->register_no != '')
    {
        $sql->where('reg_no',$request->register_no);
        if($sql)
        {
            $booking = $sql->orderBy('id','desc')->first();
        }
        else
        {
            $booking = null;
        }
        return $this->sendResponse(true,['customer'=>$booking], $booking ? 'Customer found' : 'No customer found');
    }

    if($request->mobile_no != '')
    {
        $check = $sql->where('customer_id',$request->mobile_no)->first();
        $sql->where('customer_id',$request->mobile_no);
        if( $check==null)
        {
            $sql =   Customer::where('status',0)->whereIn('type',[2,4])->select('id','name','mobile as mobile_no','location','make','model','color','reg_no as register_no','created_at','service_string as service','remarks','created_at','completed_date as completed_at','delivered_date as delivered_at','total_amount as amount')->where('mobile', 'LIKE', "%$request->mobile_no");
            $count =$sql->distinct('mobile')->count('mobile');
            if( $count==1)
            {
                $booking = $sql->orderBy('id','desc')->first();
                return $this->sendResponse(true,['customer'=>$booking], $booking ? 'Customer found' : 'No customer found');
            }
            else{
                $booking = null;
                return $this->sendResponse(true,['customer'=>$booking], $booking ? 'Customer found' : 'No customer found');
            }
        }
       $booking = $sql->orderBy('id','desc')->first();
                      return $this->sendResponse(true,['customer'=>$booking], $booking ? 'Customer found' : 'No customer found');
    }
    
   
}
public function add_service(Request $request)
{
   $validator = Validator::make($request->all(), [
    'service_name' => [
        'required',
        Rule::unique('services','name')
        ->where(function ($query) {
            return $query->where([['company_id',Auth::user()->company->id],['status',0]]);
        })
    ],
],[
    'service_name.unique' => 'Service name already exist'
]);

   if($validator->fails()) {
    return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
}


$service = new Service;

$service->name = $request->service_name;
$service->company_id = Auth::user()->company->id;
$service->save();

return $this->sendResponse(true,[],'New Service Added');
}
public function list_services()
{
    $services = Service::where([
        ['company_id',Auth::user()->company->id],
        ['status',0]
    ])
    ->select('id','name')->get();   

    $data = ['services'=>$services];
    $appends = ['service_count'=>$services->count()];
    return $this->sendResponse(true,$data,'Service List',200,$appends);
}

public function list_expensecategories()
{
    $expensecategories = ExpenseCategory::where([
        ['company_id',Auth::user()->company->id],
        ['status',0]
    ])
    ->select('id','name')->get();   

    $data = ['expensecategories'=>$expensecategories];
    return $this->sendResponse(true,$data,'Expense Category List',200);
}

public function list_makes()
{
    $makes = VehicleMake::with(['models'=>function($query){
        $query->orderBy('name')->select('id','make_id','name');

    }])->where([   
        ['status',0]
    ])->whereIn( 'company_id',[0,Auth::user()->company->id])
    ->select('id','name')->orderBy('name')->get();   

    $data = ['makes'=>$makes];
    $appends = ['makes_count'=>$makes->count()];
    return $this->sendResponse(true,$data,'Vehicle Make List',200,$appends);
}

public function delete_service(Request $request)
{

    $validator = Validator::make($request->all(), [
        'service_id' => 'required',
    ]);

    if($validator->fails()) {
        return $this->sendResponse(false, $validator->errors(),'Validation Error',422);
    }

    $service = Service::where('status',0)->find($request->service_id);
    if($service) {
        $service->status = -1;
        $service->save();
        return $this->sendResponse(true,[],'Service Deleted');
    }
    else {
        return $this->sendResponse(false,[],'Invalid service id',404);
    }
}


public function find_model_by_make(Request $request)
{
    $models = VehicleModel::where([   
        ['status',0],
        ['make_id',$request->id]
    ])->whereIn( 'company_id',[0,Auth::user()->company->id])
    ->select('id','name')->orderBy('name')->get();   

    $data = ['models'=>$models];
    $appends = ['models_count'=>$models->count()];
    return $this->sendResponse(true,$data,'Vehicle Model List by Make',200,$appends);
}
public function logout(Request $request)
{
    $request->user()->token()->revoke();
    return $this->sendResponse(true,[],'Successfully logged out'); 
}

}
