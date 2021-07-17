<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class LoginController extends Controller
{
	public function index()
	{
		if(Auth::check()) {
			return $this->redirecter();
		}
		else {
			return view('login');
		}
	}

	public function login(Request $request)
	{
		$credentials = $request->only('username', 'password');
		$credentials['status']=0;
		if (Auth::attempt($credentials)) {
			return ['status'=>1,'response'=>'Success'];
		}
		else {
			return ['status'=>0,'response'=>'Invalid Username or Password'];
		}
	}

	public function logout()
	{
		Auth::logout();
		Session::flush();
		return redirect('login');
	}

	public function redirecter() {
		switch (Auth::user()->role->name) {
			case 'ADMIN': return redirect('/invoices'); break;
			case 'BILLING': return redirect('/invoices'); break;
			default: return $this->logout(); break;
		}
	}

	public function change_password(Request $request)
	{
		$this->validate($request,[
			'current_password' => 'required',
			'new_password' => 'required',
		]);

		if(Hash::check($request->current_password,Auth::user()->password)) {
			Auth::user()->password = bcrypt($request->new_password);
			Auth::user()->save();
			return ['status'=>1,'response'=>'Password changed successfully'];
		}
		else
			return ['status'=>0,'response'=>'Invalid Password'];
	}
}
