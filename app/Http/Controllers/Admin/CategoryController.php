<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories');
    }

    public function get_categories()
    {
        $categories = Category::where([['status','0'],['company_id',Auth::user()->company_id]])->get();
        return $categories;
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('categories')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where([['status','0'],['company_id',Auth::user()->company_id]]);
                }),
            ]
        ]);

        if($request->id){
            $category = Category::find($request->id);
        }
        else
            $category = new Category;

        $category->name = $request->name;
        $category->company_id = Auth::user()->company_id;
        $category->save();
        return 'Success';
    }

    public function delete_category(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $category = Category::find($request->id);
        $category->status = -1;
        $category->save();

        return 'Success';
    }
}
