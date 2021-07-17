<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleModel;
use App\Models\VehicleMake;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class VehicleModelController extends Controller
{
    public function index()
    {
        
        $vehiclemakes = VehicleMake::where('status','0')->whereIn('company_id',[Auth::user()->company_id,0])->orderBy('name')->get();

        return view('admin.models',compact('vehiclemakes'));

        
    }

    public function get_models()
    {
        $makes =  VehicleModel::with(['vehicle_make' => function($query){
            $query->where('status', 0);
        }])
        ->where('status','0')
        ->whereIn('company_id',[Auth::user()->company_id,0])->get();
        return $makes;
    }

    public function get_models_by_make($id)
    {

        
       $makes =  VehicleModel::with(['vehicle_make' => function($query){
                  $query->where('status', 0);
              }])
              ->where('status','0')
              ->where('make_id',$id)
              ->get();
        return $makes;
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('vehicle_models')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where([['status','0'],['company_id',Auth::user()->company_id],['company_id',0]]);
                }),
            ]
        ]);

        if($request->id){
            $make = VehicleModel::find($request->id);
        }
        else
            $make = new VehicleModel;

        $make->name = $request->name;
        $make->make_id = $request->make_id;
        $make->company_id = Auth::user()->company_id;
        $make->save();
        return 'Success';
    }

    public function delete_model(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $make = VehicleModel::find($request->id);
        $make->status = -1;
        $make->save();

        return 'Success';
    }
}
