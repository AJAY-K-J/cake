<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class VehicleMakeController extends Controller
{
    public function index()
    {
        return view('admin.makes');
    }

    public function get_makes()
    {
        $makes =  VehicleMake::where('status','0')->whereIn('company_id',[Auth::user()->company_id,0])->get();
        return $makes;
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('vehicle_makes')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where([['status','0'],['company_id',Auth::user()->company_id],['company_id',0]]);
                }),
            ]
        ]);

        if($request->id){
            $make = VehicleMake::find($request->id);
        }
        else
            $make = new VehicleMake;

        $make->name = $request->name;
        $make->company_id = Auth::user()->company_id;
        $make->save();
        return 'Success';
    }

    public function delete_make(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $make = VehicleMake::find($request->id);
        $modelexists=VehicleModel::where([['make_id',$request->id],['status',0]])->first();
        if($modelexists)
            return 'Error - Model Exists, First Delete Model to Delete Make';
        else
        {
            $make->status = -1;
            $make->save();
            return 'Success';
        }
        
    }
}
