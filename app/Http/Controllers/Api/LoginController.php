<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\SMS;

class LoginController extends Controller
{
    use ApiHelper;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendResponse(false, $validator->errors(),'Validation Error',200);
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 0
        ];
        if(Auth::attempt($credentials)) { 
            $user = Auth::user();
            $token =  $user->createToken('Service Premium')->accessToken;
            
            $api=$user->company->sms->api;
            $balance = SMS::getBalance($api);
          
           /* if($user->station->expiry_date >= DATE('Y-m-d 00:00:00'))
                $expiry = 0;
            else
                $expiry = 1;*/
                if($balance >0)
                    $expiry = 0;
                else
                    $expiry = 1;
            $data = [
                'token' => $token,
                'user_id' => $user->id,
                'user_type' => $user->role_id,
                'expiry' => $expiry,
                //'expiry_date' => DATE('d-m-Y', strtotime($user->station->expiry_date)),
                'station_id' => $user->company_id,
                'cc_mobno' => $user->company->cc_mobile,
                'mobno' => $user->company->mobile,
                'name' => $user->company->name,
                'balance'=>$balance

            ];

            return $this->sendResponse(true,  $data, 'User login successfully'); 
        } 
        else { 
            return $this->sendResponse(false,[],'Email or Password do not match',200);
        } 
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse(true,[],'Successfully logged out'); 
    }

    public function change_password(Request $request)
    {
        $this->validate($request,[
            'current_password' => 'required',
            'new_password' => 'required',
        ]);
        if(Hash::check($request->current_password,Auth::user()->password))
        {
            Auth::user()->password = bcrypt($request->new_password);
            Auth::user()->save();
            return $this->sendResponse(true,[],'Password changed successfully'); 
        }
        else
            return $this->sendResponse(false,[],'Invalid Password',422); 
    }
}
