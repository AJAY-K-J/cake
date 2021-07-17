<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PaymentType;
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


class ExpenseController extends Controller
{
    public function index()

    {
        $expensecategories = ExpenseCategory::where('status','0')->orderBy('name')->get();
        $payment_types = PaymentType::where('status',0)->get();
        return view('admin.expenses',compact('expensecategories','payment_types'));
    }

    public function get_expenses()
    {

        
            $expenses = Expense::where('status',0)->orderBy('created_at','desc')->whereDate('created_at',date('Y-m-d'))->get();
            return  $expenses;
    
        

    }
    public function get_expenses_by_expensecategory($name)
    {

       $expenses =  Expense::where([['status','0'],['expensecategory',$name]])->orderBy('created_at','desc')->get();
        return $expenses;
    }
    public function delete_expense(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $expense = Expense::find($request->id);
        $expense->status = -1;
        $expense->save();

    }
     public function find_expense($id)
    {
        $expense = Expense::where('id',$id)->first();
        return  $expense;
    }
    public function save(Request $request)
    {

        if($request->id){
            $expense = Expense::find($request->id);
        }
        else
            $expense = new Expense;
        if($request->created_at)
            $expense->created_at = $request->created_at;
        $expense->name = $request->name;
        $expense->expensecategory = $request->expensecategory;
        $expense->amount = $request->amount;
        $expense->payment_type = $request->payment_type;
        $expense->save();
        return 'Success';
    }

}
