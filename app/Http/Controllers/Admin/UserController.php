<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
    	// return Auth::user()->employee->service_center->name;
    	$roles = Role::get();
        return view('admin.users',compact('roles'));
    }

    public function get_users()
    {
    	$users = User::where([
    		['company_id', Auth::user()->company->id]
    	])->with(['role:id,name'])->orderBy('created_at')->get();
    	return $users;
    }

    public function save(Request $request)
    {

    	$v = Validator::make($request->all(), [
			'name' => 'required',
			'role' => 'required',
			'status' => 'required',
			"mobile" => 'nullable|digits:10',
			"email" => 'nullable|email',
			'username' => [
				'required',
				"unique:users,username,{$request->id},id,deleted_at,NULL"
			]
    	],[
    		'name.required' => 'Enter employee name',
    		'email.required' => 'Enter employee email',
    		'role.required' => 'Select a role',
    		'status.required' => 'Select a login status',
    		'mobile.required' => 'Enter employee mobile number',
    		'mobile.digits' => 'Mobile no must be exactly 10 digits',
    		'username.required' => 'Entre employee username',
    		'username.unique' => 'Username already exist',
    		'password.required' => 'Enter a password',
    	]);

    	$v->sometimes('password', 'required', function ($request) {
    	    return !$request->id;
    	});

    	$v->validate();

    	try {
    		if($request->id)
    			$user = User::find($request->id);
    		else
    			$user = new User;

    		$user->company_id = Auth::user()->company->id;
			$user->name = $request->name;
			$user->email = $request->email;
			$user->mobile = $request->mobile;
			$user->role_id = $request->role;
			$user->username = $request->username;
			$user->status = $request->status ? 0 : 1;
			if($request->password)
				$user->password = bcrypt($request->password);
			$user->save();
    			
    		return 'Success';
    	} catch(Exception $e) {
    		return 'Failed';
    	}
    }

    public function delete_user(Request $request) {
    	$request->validate([
			'id' => 'required',
		]);

    	try {
    		$user = User::find($request->id)->delete();
    		return 'Success';
    	} catch(Exception $e) {
    		return 'Failed';
    	}
    }
}
