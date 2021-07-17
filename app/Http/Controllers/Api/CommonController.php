<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\VehicleModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    public function reports()
    {
        $sme_id = Input::get('sme_id');
        $data['status']    = 1;
        $data['today']     = $this->reports_sme($sme_id,'today')->count();
        $data['thisMonth'] = $this->reports_sme($sme_id,'monthly')->count();
        $data['redeemed_count'] = $this->reports_sme($sme_id,'monthly',TRUE)->count();
        $data['redeemed_vehicles'] = $this->reports_sme($sme_id,'monthly',TRUE);
        return $data;
    }

    public function reports_sme($sme_id,$type,$redeemed=FALSE)
    {
        $customers = Customer::where([['sme_id',$sme_id],['status', 0]])->select('sme_id','reg_no');
                if($type == 'today')
                {
                    $customers = $customers->whereDate('added_date', Carbon::today());
                }
                elseif($type == 'monthly')
                {
                    $customers = $customers->whereMonth('added_date', Carbon::now()->month);
                }

                if($redeemed)
                	$customer = $customers->where('redeem_status',1);

        $customers = $customers->get();
        return $customers;
    }

    public function datas(Request $request)
    {
        if($request->has('model_varients'))
        {
            $vehicle_models = VehicleModel::with(['vehicle_variants'=>function($query) {
                        	$query->orderBy('name');
                        }])->orderBy('name')->get();
            $data['model_varients'] = $vehicle_models;
        }   

        if($request->has('campaigns'))
        {
            $campaigns = Campaign::where([['type',3],['status', 0]])->whereDate('to_date', '>=', date('Y-m-d'))->get();
            $data['campaigns'] = $campaigns;
        }

        if($request->has('campaigns'))
        {
            $campaigns = Campaign::where([['type',3],['status', 0]])->whereDate('to_date', '>=', date('Y-m-d'))->get();
            $data['campaigns'] = $campaigns;
        }


        $data['status'] = 200;
        return $data;
    }
}
