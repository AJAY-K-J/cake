<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class AccessoryController extends Controller
{
    public function index()
    {
        return view('admin.accessories');
    }

    public function get_accessories()
    {
        $accessories = Accessory::where([['status','0'],['company_id',Auth::user()->company_id]])->get();
        return $accessories;
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('accessories')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where([['status','0'],['company_id',Auth::user()->company_id]]);
                }),
            ]
        ]);

        if($request->id){
            $accessory = Accessory::find($request->id);
        }
        else
            $accessory = new Accessory;

        $accessory->name = $request->name;
        $accessory->company_id = Auth::user()->company_id;
        $accessory->save();
        return 'Success';
    }

    public function delete_accessory(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $accessory = Accessory::find($request->id);
        $accessory->status = -1;
        $accessory->save();

        return 'Success';
    }
}
