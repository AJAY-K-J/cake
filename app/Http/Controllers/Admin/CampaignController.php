<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Service;
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


class CampaignController extends Controller
{
	public function index()

	{
		$services = Service::where([['status','0'],['company_id',Auth::user()->company_id]])->get();
     

		return view('admin.campaigns',compact('services'));
	}

	public function get_campaigns(Request $request)
	{
		$sql = Campaign::with('service','company')->withCount(['redeemed_customers', 'customers'])->where([['status','0'],['company_id',Auth::user()->company_id]]);
		if($request->type == 'expired')
			$sql->whereDate('to_date','<',DATE('Y-m-d'));
		else
			$sql->whereDate('to_date','>=',DATE('Y-m-d'));
		$campaigns = $sql->get();
		
		return $campaigns;
	}

	public function add_campaign(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'code' => [
				'required',
				Rule::unique('campaigns','code')
				->ignore($request->campaign_id,'campaign_id')
				->where(function ($query) {
					return $query->where([['status','0'],['company_id',Auth::user()->company_id]]);
				}),
			],
			'type' => 'required',
			'from_date' => 'required',
			'to_date' => 'required',
			'service_type' => 'required|exists:services,id',
			'discount_type' => 'required',
			'discount_amount' => 'required',
			'template' => 'required',
		]);

		DB::beginTransaction();
		try {

			if($request->campaign_id)
			{
				$old_campaign = Campaign::where([['status',0],['campaign_id',$request->campaign_id],['company_id',Auth::user()->company_id]])->first();

				if($old_campaign->to_date < DATE('Y-m-d'))
					return "Can't update expired campaign";
				if(Customer::where([['status',0],['campaign_id', $request->campaign_id]])->exists())
					return "Can't update campaigns that have customers";

					$campaign = $old_campaign->replicate();
					$old_campaign->status = -1;
					$old_campaign->save();
				}
				else
				{
					$campaign = new Campaign;
				}

				$campaign->name = $request->name;
				$campaign->code = strtoupper($request->code);
				$campaign->type = $request->type;
				$campaign->amount = $request->amount;
				$campaign->from_date = $request->from_date;
				$campaign->to_date = $request->to_date;
				$campaign->service_type = $request->service_type;
				$campaign->discount_type = $request->discount_type;
				$campaign->discount_amount = $request->discount_amount;
				$campaign->initiated_by = $request->initiated_by;
				$campaign->approved_by = $request->approved_by;
				$campaign->template = $request->template;
				$campaign->company_id = Auth::user()->company_id;
				$campaign->days = implode(",",$request->days);
				$campaign->save();

				if(!$request->campaign_id) {
					$campaign->campaign_id = $campaign->id;
					$campaign->save();
				}

				DB::commit();
				return 'Success';
			} catch(Exception $e) {
				DB::rollBack();
				return 'Failed';
			}


			return 'Success';
		}

		public function import_customers(Request $request)
		{

			$request->validate([
				'id' => 'required',
				'customers' => 'required'
			]);


			DB::beginTransaction();
			try{
				$id = $request->id;
				$campaign = Campaign::where([
					['status',0],
					['company_id',Auth::user()->company_id],
				])->find($id);
				if($campaign)
				{
					$messages = [];
					$template = $campaign->template;
					$duplicates = [];
					$path = $request->file('customers')->getRealPath();
					$datas = Excel::selectSheetsByIndex(0)->load($path)->get();

                    $api= Auth::user()->company->sms->api;
                    $balance=SMS::getBalance($api);

                    $datas->count();
                   /* if($datas->count()> $balance)
                    {

                        return ['status'=>0,'response'=>"Low SMS Credit, Please Top Up SMS"];
                    }*/
                   

					foreach ($datas as $data) {
						if($data->filter()->isEmpty())
							continue;
						if(isset($data['regno'])) {
							$regno = preg_replace('/[^A-Za-z0-9]/', '', strtoupper($data['regno']));
							$exists = Customer::where([
								['reg_no', $regno],
								['campaign_id',$campaign->campaign_id],
								['status',0]
							])->exists();

							if($exists) {
								array_push($duplicates, strtoupper($regno));
							}
							else {
								$customer = new Customer;
								$generated_template = $template;

								$generated_template = str_replace("#REGNO#",$regno,$generated_template);
								$customer->reg_no = $regno;

								if(isset($data['name'])){
									$generated_template = str_replace("#NAME#",$data['name'],$generated_template);
									$customer->name = $data['name'];
								}

								if(isset($data['mobno'])){
									$customer->mobile = $data['mobno'];
								}

								if(isset($data['service_center'])){
									$generated_template = str_replace("#CENTER#",$data['service_center'],$generated_template);
								// $customer->service_center = $data['service_center'];
								}

								if(isset($data['crm_no'])){
									$generated_template = str_replace("#CRM#",$data['crm_no'],$generated_template);
								// $customer->crm_no = $data['crm_no'];
								}

								do {
									$referral_code = $campaign->code.strtoupper(str_random(6));
								} while(Customer::where([['status',0],['referral_code', $referral_code]])->exists());

								$generated_template = str_replace("#REFERRAL#",$referral_code,$generated_template);
                                $customer->type = 1;
                                $customer->referral_code = $referral_code;
                                $customer->campaign_id = $campaign->campaign_id;
                                $customer->template = $generated_template;
							// $customer->cc_status = 1;
                                $customer->added_date = DATE('Y-m-d H:i:s');
                                $customer->save();
                                $customer->customer_id = $customer->id;

                                $customer->save();

                                array_push($messages, [
                                   'template'=>$customer->template,
                                   'mobile'=>$customer->mobile,
                                   'id'=>$customer->id,
                               ]);
                            }
                        }
                        else
                         return ['status'=>0,'response'=>"Couldn't find REGNO in excel sheet"];
                 }

                 $upload_log = new UploadLog;
                 $upload_log->campaign_id = $campaign->campaign_id;
                 $upload_log->duplicate_entries = implode(',',$duplicates);
                 $upload_log->save();
                 $api= Auth::user()->company->sms->api;
                 $sender_id= Auth::user()->company->sms->sender_id;
                 DB::commit();
                 if($campaign->type==1)
                 {
                  foreach ($messages as $message) {
                    if( $balance >0)
                    {
                        SMS::send($message['template'],$message['mobile'],$sender_id,$api);
                        $customer=Customer::find($message['id']);
                        $customer->sent_date = DATE('Y-m-d');
                        $customer->save();
                    }
                    else{
                        return ['status'=>0,'response'=>"Low SMS Credit, Please Top Up SMS"];
                    }

                     
                 }
             }
             if($campaign->type==2 && count($messages)>0)
             {
              $pdf = PDF::loadView('exports.vouchers', ['messages'=>$messages,'logo'=>Auth::user()->company->logo])->setPaper('a4', 'landscape');
              $filename = uniqid();
              $filename=$campaign->code.'_VOUCHER_'.date('YmdHis').'.pdf';
              $pdf->save('temp/'.$filename);
              return ['status'=>1,'response'=>'Success','duplicates'=>$duplicates,'pdf'=>$filename];
          }
          return ['status'=>1,'response'=>'Success','duplicates'=>$duplicates];
      }
      else
      {
       return ['status'=>0,'response'=>'Campaign not found'];
   }
} catch(Exception $e) {
    DB::rollBack();
    return ['status'=>0,'response'=>"Couldn't import file. Please check if the excel has correct fields"];
} 
}

public function delete_campaign(Request $request) {
 $request->validate([
    'campaign_id' => 'required',
]);

 $campaign = Campaign::where([['campaign_id',$request->campaign_id],['status','!=','-1'],['company_id',Auth::user()->company_id]])->first();

 if($campaign->to_date < DATE('Y-m-d'))
    return "Can't delete expired campaign";
if(Customer::where([['status',0],['campaign_id', $request->campaign_id]])->exists())
    return "Can't delete campaigns that have customers";

    $campaign->status = -1;
    $campaign->save();

    return 'Success';
}

public function test()
{
    $messages = [

    ];

    return view('exports.vouchers',compact('messages'));
}

public function download_voucher($filename) {
    	// return response()->download(public_path().'/temp/'.$filename,'voucher_'.date('Y_m_d_h_i').'.pdf')->deleteFileAfterSend();
    return response()->download(public_path().'/temp/'.$filename);
}

public function download_customers($id)
{
    $customers = Customer::where('campaign_id',$id)->select([
       'name as NAME',
       'reg_no as REGNO',
       'mobile as MOBNO',
       'redeem_status as Status',
   ])->orderBy('redeem_status','desc')->get();

    $campaign = Campaign::where([['campaign_id',$id],['status',0],['company_id',Auth::user()->company_id]])->first();

    foreach ($customers as $customer) {
       if($customer->Status==1)
          $customer->Status='Redeemed';
      else
          $customer->Status="Not Redeemed";
  }

  Excel::create(str_replace(" ","_",$campaign->name).Date("_Y_m_d_His"), function($excel) use($customers) {
   $excel->sheet('Sheet', function($sheet) use($customers) {
      $sheet->fromArray($customers);
  });
})->download('xlsx');
}
}
