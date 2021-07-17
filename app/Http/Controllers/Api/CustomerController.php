<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'mobile'  => 'required',
            'reg_no'  => 'required',
            'model'   => 'required',
            'varient' => 'required',
            'booking_date' => 'required',
        ]);
        if ($validator->fails()) {            
            $data['status'] = 422;
            $data['errors'] = $validator->errors();
            return $data;
        }
        else
        {
        	$regno = preg_replace('/[^A-Za-z0-9]/', '', strtoupper($request->reg_no));

            $customer_id = Customer::orderBy('customer_id', 'desc')->take(1)->get();
            if (count($customer_id) > 0) {
                $id = $customer_id[0]->customer_id;
                $id = $id + 1;
            } else {
                $id = 1;
            }

            $inserter = 0;
            
            $check = Customer::where([['reg_no',$regno],['status', 0]])->whereHas('campaigns',function($query){ $query->whereDate('to_date', '>=', date('Y-m-d')); }); 
            if($request->campaign_confirm == 0)
            {
                if(count($check->get()) > 0)
                {
                    $data['status']           = 0;
                    $data['messages']         = 'This registration number is already used.';
                    $data['campaign_details'] = DB::table('campaigns')->where([['campaign_id', $check->value('campaign_id')],['status',0]])->first();
                    return $data;
                }
                else
                {
                    $inserter = 1;
                }                
            }
            else
            {
                $inserter = 1;
            }

            if($inserter == 1)
            {
                $customer = new Customer;
                $customer->customer_id = $id;
                $customer->sme_id      = $request->sme_id;
                $customer->name        = $request->name;
                $customer->mobile      = $request->mobile;
                $customer->reg_no      = $regno;
                $customer->model_id    = $request->model;
                $customer->variant_id  = $request->varient;
                $customer->campaign_id = $request->campaign_id;      
                $customer->cc_status   = 0;      
                $customer->created_at  = DATE("Y-m-d H:i:s");      
                $customer->added_date  = DATE('Y-m-d H:i:s');
                $customer->booking_date  = $request->booking_date;

                $employee = Employee::where([['employee_id',$request->sme_id],['status',0]])->whereHas('service_center')->first();
            	if($employee)
            		{
            			$customer->service_center = $employee->service_center->name;
            			$customer->crm_no = $employee->service_center->crm_no;
            		}
                $customer->save();
            }

            //SEND SMS HERE
            $data['status']   = 200;
            $data['messages'] = 'Customer details added successfully';
            return $data;
        }
    }

    
}
