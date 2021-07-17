<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.services');
    }

    public function get_services()
    {
    	$services = Service::where([['status','0'],['company_id',Auth::user()->company_id]])->get();
    	return $services;
    }

    public function save(Request $request)
    {
		$request->validate([
			'name' => [
		        'required',
		        Rule::unique('services')
		        ->ignore($request->id)
		        ->where(function ($query) {
					return $query->where([['status','0'],['company_id',Auth::user()->company_id]]);
				}),
		    ]
		]);

		if($request->id){
			$service = Service::find($request->id);
		}
		else
			$service = new Service;

		$service->name = $request->name;
		$service->company_id = Auth::user()->company_id;
		$service->save();
		return 'Success';
    }

    public function delete_service(Request $request) {
    	$request->validate([
			'id' => 'required',
		]);

    	$service = Service::find($request->id);
    	$service->status = -1;
    	$service->save();

    	return 'Success';
    }
}
