<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class IncomeCategoryController extends Controller
{  
    public function index()
    {
        return view('admin.incomecategories');
    }

    public function get_incomecategories()
    {
        $incomecategories = IncomeCategory::where('status',0)->get();
        return $incomecategories;
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('incomecategories')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where('status',0);
                }),
            ]
        ]);

        if($request->id){
            $incomecategory = IncomeCategory::find($request->id);
        }
        else
            $incomecategory = new IncomeCategory;

        $incomecategory->name = $request->name;
        $incomecategory->save();
        return 'Success';
    }

    public function delete_incomecategory(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $incomecategory = IncomeCategory::find($request->id);
        $incomecategory->status = -1;
        $incomecategory->save();

        return 'Success';
    }
}
