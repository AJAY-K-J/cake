<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Closing; 
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Income;
use App\Models\PurchaseCredit;
use App\Models\PaymentType;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Auth;

  
class Closingcontroller extends Controller
{
    public function index()
	{   
	   $payment_types = PaymentType::where('status',0)->get(); 
      $collections = [];
      foreach($payment_types as $key => $value) {
         $collections[$key]['type'] = $value->name;
          $coll =Payment::whereDate('created_at',Carbon::today())
                       ->where('payment_type',$value->id) 
                       ->sum('amount'); 
          $income = Income::whereDate('created_at',Carbon::today())
                       ->where('payment_type',$value->id) 
                       ->sum('amount');                                                   
          $collections[$key]['amount'] = $coll+$income;
        }

      $expenses = [];
      foreach($payment_types as $key => $value) {
         $expenses[$key]['type'] = $value->name;
          $exp =Expense::whereDate('created_at',Carbon::today())
                       ->where('payment_type',$value->id) 
                       ->sum('amount');
          $purchase =  PurchaseCredit::whereDate('created_at',Carbon::today())
                       ->where([['payment','!=',0],['payment_type',$value->id]]) 
                       ->sum('amount');           

          $expenses[$key]['amount'] = $exp + $purchase;
        }
      
       

     
       // $cdate = date("Y-m-d");
       // $openings = Closing::select('opening_balance')->where('date', $cdate)->first();
       // $balances = $openings->opening_balance;
       // $balance = json_decode($balances,true);
      
       
       return view('admin.closing',compact('payment_types','collections','expenses'));
    }
    public function addOpening(Request $request)
	{

    	$closing = $request->all();
      $payment_types = PaymentType::where('status',0)->get();
      
      $total_opening = 0; 
      $openings=[];
      foreach($payment_types as $key => $value) {
          $openings[$key]['type'] = $value->name;
          $ss = $value->name;
          $openings[$key]['amount'] =  $closing[$ss];
          $total_opening+= $closing[$ss]; 
       }
    	// $open_balance = json_encode($openings);
      $new = new Closing;
      $new->opening_balance=$openings;
    	$new->total_opening=$total_opening;
    	$new->date=date("Y-m-d");
    	$new->save();
    	return 'success';
    }

   public function closeAcc(Request $request)
   {
      
      $payment_types = PaymentType::where('status',0)->get();
      //coll
      // $total_collection = 0; 
      // $collections = $request->collection;
      //  foreach($payment_types as $key => $value) {
      //   $total_collection += $collections[$key]['amount'];  
      //  }
     $collections = [];
     $total_collection = 0;
      foreach($payment_types as $key => $value) {
       $collections[$key]['type'] = $value->name;
        $coll =Payment::whereDate('created_at',Carbon::today())
                     ->where('payment_type',$value->id) 
                     ->sum('amount');
        $income = Income::whereDate('created_at',Carbon::today())
                       ->where('payment_type',$value->id) 
                       ->sum('amount');             

        $collections[$key]['amount'] = $coll+$income;
        $total_collection += $coll; 
      }
      //exp
      // $total_expense = 0; 
      // $expenses = $request->expense;
      //  foreach($payment_types as $key => $value) {
      //   $total_expense += $expenses[$key]['amount'];  
      //  } 

      $expenses = [];
      $total_expense = 0;
      foreach($payment_types as $key => $value) {
       $expenses[$key]['type'] = $value->name;
        $coll =Expense::whereDate('created_at',Carbon::today())
                     ->where('payment_type',$value->id) 
                     ->sum('amount');

        $purchase =  PurchaseCredit::whereDate('created_at',Carbon::today())
                       ->where([['payment','!=',0],['payment_type',$value->id]]) 
                       ->sum('amount'); 
        $expenses[$key]['amount'] = $coll+$purchase;
        $total_expense = $coll;
      } 
      //opening
       $total_opening = 0; 
      $opening = $request->opening;
       foreach($payment_types as $key => $value) {
        $total_opening += $opening[$key]['amount'];  
       }  
      $closing_balance = $total_collection + $total_opening - $total_expense;
      
      $closing = Closing::where('date',date('Y-m-d'))->first();
      $closing->total_opening = $total_opening;
      $closing->collection = $collections;
      $closing->expense = $expenses;
      $closing->total_collection = $total_collection;
      $closing->total_expense = $total_expense;
      $closing->closing_balance = $closing_balance;
      $closing->closing_time = Carbon::now()->toDateTimeString();
      //return $closing;
      $closing->save();
      
      $todays = [
           'opening_balance' =>$total_opening,
           'closing_balance' =>$closing_balance,
           'total_collection'=> $total_collection,
           'total_expense' => $total_expense
      ]; 

      return   $todays;
      

   } 
   public function getOpening()
   {
      $today_openings = Closing::where('date',date('Y-m-d'))->first();
      if($today_openings)
      {  
        if($today_openings->closing_balance)
        {
          return 'CLOSE';
        }
        else
        {
          $openings = $today_openings->opening_balance;
        return $openings;
        }  
      }
      else
      {
        return 'BLANK';
      }  

   }
   public function find_closing($id)
   {
       $closing = Closing::where([['id',$id],['closing_balance','!=',NULL]])->first();
       
       return $closing;
   } 
}    