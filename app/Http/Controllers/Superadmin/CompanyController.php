<?php

namespace App\Http\Controllers\Superadmin;

use App\Helper\CustomerTable;
use App\Helper\LoyalCustomerTable;
use App\Helper\ExpenseTable;
use App\Helper\IncomeTable;
use App\Helper\JobcardTable;
use App\Helper\ImageTable;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SmsSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
	public function index() {
		return view('superadmin.companies');
	}

	public function get_companies() {
		$companies = Company::where('status',0)->with([
			'admin:id,company_id,name,email,mobile,username',
			'sms:company_id,sender_id,username,password,api',
		])->orderBy('updated_at','desc')->get();
		return $companies;
	}

	public function save(Request $request) {

		$v = Validator::make($request->all(), [
			'company_name' => "required|unique:companies,name,{$request->id},id,deleted_at,NULL",
			'logo' => 'sometimes|image',
			"admin_name" => 'required',
			"mobile" => 'nullable|digits:10',
			"email" => 'nullable|email',
			'username' => [
				'required',
				"unique:users,username,{$request->user_id},id,deleted_at,NULL"
			]
		],[
			'company_name.unique' => 'Company name already exist',
			'company_name.required' => 'Enter company name',
			'admin_name.required' => 'Enter admin name',
			'username.required' => 'Entre employee username',
			'username.unique' => 'Username already exist',
			'mobile.digits' => 'Mobile no must be exactly 10 digits',
			'email.email' => 'Enter a valid email',
			'password.required' => 'Enter a password',
			'sender_id.required' => 'Sender ID is required',
			'sender_id.required' => 'Sender ID must be exactly 6 characters',
		]);

		$v->sometimes('password', 'required', function ($request) {
			return !$request->id;
		});

		$v->sometimes('sms_sender_id', "required", function ($request) {
			return !$request->default_sms_settings;
		});


		$v->sometimes('logo', 'required', function ($request) {
			return !$request->id;
		});

		$v->validate();

		try {
			DB::beginTransaction();

			if($request->id) {
				$company = Company::find($request->id);
			} else {
				$company = new Company;
			}

			$old_logo = '';
			if($request->hasFile('logo')) {
				$old_logo = $company->logo;
				$path = Storage::disk('public')->putFileAs('company/logos', $request->file('logo'), Str::uuid().'-'.$request->file('logo')->getClientOriginalName());
				$company->logo = $path;
			}
			else
				$path = '';

			$company->name = $request->company_name;
			// $company->sender_id = $request->sender_id;
			
			$company->save();

			$admin = $company->admin;
			if(!$admin)
				$admin = new User;

			$admin->company_id = $company->id;
			$admin->name = $request->admin_name;
			$admin->email = $request->email;
			$admin->mobile = $request->mobile;
			$admin->role_id = 1;
			$admin->username = $request->username;
			if($request->password)
				$admin->password = bcrypt($request->password);
			$admin->save();

			if($request->default_sms_settings == false) {
				$sms = SmsSetting::where('company_id',$company->id)->first();
				if(!$sms)
					$sms = new SmsSetting;

				$sms->company_id = $company->id;
				$sms->sender_id = $request->sms_sender_id;
				$sms->username = $request->sms_username;
				$sms->password = $request->sms_password;
                $sms->api = $request->sms_api;
				$sms->save();
			}
			else {
				SmsSetting::where('company_id',$company->id)->delete();
			}
			

			if($request->id == '') {
				CustomerTable::create($company);
                ExpenseTable::create($company);
                IncomeTable::create($company);
                ImageTable::create($company);
                JobcardTable::create($company);
                LoyalCustomerTable::create($company);
			}

			DB::commit();

			if($old_logo)
				Storage::disk('public')->delete($old_logo);

			return ['status'=>1];
		} catch(\Throwable $e) {
			DB::rollBack();
			return ['status'=>0, 'message'=>$e->getMessage()];
		}
	}

	public function delete_company(Request $request) {
		$request->validate([
			'id' => 'required',
		]);

		try {
			$company = Company::find($request->id);
			$company->users()->delete();
			$company->delete();
			return ['status' => 1];
		} catch(\Throwable $e) {
			return ['status' => 0, 'message'=>$e->getMessage()];
		}
	}
}
