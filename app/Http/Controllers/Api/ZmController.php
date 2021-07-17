<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SMS;

class ZmController extends Controller {
	
	protected $zm;
	protected $service_centers;


	public function __construct(Request $request) {
		$this->middleware('Zm');
		$this->zm = Employee::where([
			['employee_id',$request->employee_id],
			['role_id',5],
			['status',0]
		])->first();
		$this->service_centers = explode(',',$this->zm->service_center_id);
	}

	public function datas() {
		try {
			$sme_ids = Employee::whereIn('service_center_id',$this->service_centers)
			->where('status',0)
			->where('role_id',2)
			->get()->pluck('employee_id');
			$bookings = Customer::whereIn('sme_id',$sme_ids)
			->where('status',0)
			->whereMonth('added_date',DATE('m'))
			->get();

			$bookings_count = $bookings->count();
			$redeemed_count = $bookings->where('redeem_status',1)->count();

			return [
				'status' => 1,
				'bookings_count' => $bookings_count,
				'redeemed_count' => $redeemed_count,
			];
		} catch(\Throwable $e) {
			return [
				'status' => 0,
				'response' => 'Error. Try Again'
			];
		}
	}

	public function bookings() {
		try {
			$smes = Employee::whereIn('service_center_id',$this->service_centers)
			->where('status',0)
			->where('role_id',2)
			->select('employee_id','name')
			->withCount([
				'customers AS booking_count' => function($query){
					$query->whereMonth('added_date',DATE('m'));
					$query->where('status',0);
				}
			])
			->get();

			return [
				'status' => 1,
				'smes' => $smes
			];
		} catch(\Throwable $e) {
			return [
				'status' => 0,
				'response' => 'Error. Try Again'
			];
		}
	}

	public function redeemed() {
		try {
			$smes = Employee::whereIn('service_center_id',$this->service_centers)
			->where('status',0)
			->where('role_id',2)
			->select('employee_id','name')
			->withCount([
				'customers AS redeemed_count' => function($query){
					$query->whereMonth('added_date',DATE('m'));
					$query->where('redeem_status',1);
					$query->where('status',0);
				}
			])
			->with(['redeemed_vehicles' => function($query) {
				$query->whereMonth('added_date',DATE('m'));
				$query->select('sme_id','reg_no');
			}])
			->get();

			// foreach ($smes as $sme) {
			// 	$sme->redeemed_vehicles = Customer::where([
			// 		['redeem_status',1],
			// 		['sme_id',$sme->employee_id],
			// 		['status',0]
			// 	])
			// 	->whereMonth('added_date',DATE('m'))->pluck('reg_no');
			// }

			return [
				'status' => 1,
				'smes' => $smes
			];
		} catch(\Throwable $e) {
			return [
				'status' => 0,
				'response' => 'Error. Try Again',
				'message' => $e->getMessage()
			];
		}
	}
}