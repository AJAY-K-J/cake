<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return view('admin.expensecategories');
    }

    public function get_expensecategories()
    {
        $expensecategories = ExpenseCategory::where('status','0')->get();
        return $expensecategories;
    }

    public function save(Request $request)
    {
       
        $request->validate([
            'name' => [
                'required',
                Rule::unique('expensecategories')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where('status','0');
                }),
            ]
        ]);

        if($request->id){
            $expensecategory = ExpenseCategory::find($request->id);
        }
        else
            $expensecategory = new ExpenseCategory;

        $expensecategory->name = $request->name;
        $expensecategory->status=0;
        $expensecategory->save();
        return 'Success';
    }

    public function delete_expensecategory(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $expensecategory = ExpenseCategory::find($request->id);
        $expensecategory->status = -1;
        $expensecategory->save();

        return 'Success';
    }
}
