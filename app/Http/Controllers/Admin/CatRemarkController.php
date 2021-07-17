<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CatRemark;
use App\Models\Category;
use App\Models\UploadLog;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use PDF;
use App\Http\Controllers\SMS;
use App\Models\SmsSetting;
use Auth;


class CatRemarkController extends Controller
{
    public function index()

    {
        $categories = Category::where('status','0')->whereIn('company_id',[Auth::user()->company_id,0])->orderBy('name')->get();

        return view('admin.catremarks',compact('categories'));
    }

    public function get_catremarks()
    {

        
            $catremarks = CatRemark::with('category')->where([['status','0'],['company_id',Auth::user()->company_id]])->orderBy('created_at','desc')->whereDate('created_at',date('Y-m-d'))->get();
            return  $catremarks;
    
        

    }
    public function get_catremarks_by_category($id)
    {

       $catremarks =  CatRemark::where([['status','0'],['category_id',$id],['company_id',Auth::user()->company_id]])->orderBy('created_at','desc')->get();
        return $catremarks;
    }
    public function delete_catremark(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $catremark = CatRemark::find($request->id);
        $catremark->status = -1;
        $catremark->save();

    }
    public function save(Request $request)
    {

       

        if($request->id){
            $catremark = CatRemark::find($request->id);
        }
        else
            $catremark = new CatRemark;

        $catremark->name = $request->name;
        $catremark->category_id = $request->category_id;
        $catremark->company_id = Auth::user()->company_id;
        $catremark->save();
        return 'Success';
    }

}
