<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\UploadLog;
use App\Models\PaymentType;
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


class IncomeController extends Controller
{
    public function index()

    {
        $incomecategories = IncomeCategory::where('status','0')->orderBy('name')->get();
        $payment_types = PaymentType::where('status',0)->get();
        return view('admin.incomes',compact('incomecategories','payment_types'));
    }

    public function get_incomes()
    {   
            $incomes = Income::where('status',0)->orderBy('created_at','desc')->whereDate('created_at',date('Y-m-d'))->get();
            return  $incomes;
    }
    public function get_incomes_by_incomecategory($name)
    {

       $incomes =  Income::where([['status','0'],['incomecategory',$name]])->orderBy('created_at','desc')->get();
        return $incomes;
    }
    public function delete_income(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $income = Income::find($request->id);
        $income->status = -1;
        $income->save(); 

    }
    public function save(Request $request)
    {

        if($request->id){
            $income = Income::find($request->id);
        }
        else
            $income = new Income;
        if($request->created_at)
            $income->created_at = $request->created_at;
        $income->name = $request->name;
        $income->incomecategory = $request->incomecategory;
        $income->amount = $request->amount;
        $income->payment_type = $request->payment_type;
        $income->save();
        return 'Success';
    }

}
