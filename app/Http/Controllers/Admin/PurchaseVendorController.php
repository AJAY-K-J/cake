<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseVendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class PurchaseVendorController extends Controller
{
    public function index()
    {
        return view('admin.vendors');
    }

    public function get_vendors()
    {
        $vendors = PurchaseVendor::where('status',0)->get();
        return $vendors;
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('purchasevendors')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where('status',0);
                }),
            ]
        ]);

        if($request->id){
            $vendor = PurchaseVendor::find($request->id);
        }
        else
            $vendor = new PurchaseVendor;

        $vendor->name = $request->name;
        $vendor->address = $request->address1;
        $vendor->mobile_no = $request->mobile_no;
        $vendor->opening_credit = $request->opening_credit;
        $vendor->save();
        return 'Success';
    }

    public function delete_vendor(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $vendor = PurchaseVendor::find($request->id);
        $vendor->status = -1;
        $vendor->save();

        return 'Success';
    }
}
