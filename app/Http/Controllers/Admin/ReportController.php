<?php

namespace App\Http\Controllers\Admin;
                                
use App\Helper\JARVIS;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\PurchaseCredit;
use App\Models\Company;
use App\Models\PurchaseLog;
use App\Models\Product;
use App\Models\InvoiceItem;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\PaymentType;
use App\Models\IncomeCategory;
use App\Models\Income;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseVendor;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Closing;
use PDF;
use Illuminate\Support\Facades\Input;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use Debugbar;
class ReportController extends Controller
{

    public function campaigns_report()
    {
    	$camp_select = Campaign::select('name','campaign_id')->where([['status',0],['company_id', Auth::user()->company_id]])->get();
    	return view('reports.campaigns',compact('camp_select'));
    }
    public function delivery_report()
    {
        $deliveries = Customer::with('service')->where('status','>=','0')->whereIn('type',[3,4]);
        $deliveries= $deliveries->whereDate('delivered_date',date('Y-m-d'))->get();
        return view('reports.deliveries',compact('deliveries'));
    }

    public function credit_index()
    {

        return view('reports.credits');
    }
    public function credit_report()
    {

        $deliveries = Customer::select('name','mobile')->where([['status','0'],['sale_status',0],['reg_status',2],['type','>=',2]])->orderBy('created_at','desc')->get()->unique('mobile');
        foreach ($deliveries as $delivery) {
            $total_credit=Customer::where([['type',4],['sale_status',0],['mobile',$delivery->mobile],['status','0']])->sum('total_amount');
            $total_payed=Customer::where([['type',5],['sale_status',0],['mobile',$delivery->mobile],['status','0']])->sum('total_amount');
            $credit_left=$total_credit-$total_payed;
            $delivery['credit']= $credit_left;
        }

        return $deliveries;
    }
    public function sale_credit_index()
    {
        $receipts = Sale::with('receipts')->where([['status',0],['credit',1]])->whereColumn('total_net_amount' ,'>','received_amount')->get();
        $total_balance = 0;
        foreach($receipts as $receipt)
        {

            $total = $receipt['total_net_amount'] - $receipt['received_amount'];
            $total_balance = $total_balance +  $total;
        }
        return view('reports.sale_credits',compact('total_balance'));
    }
    public function sale_credit_report(Request $request)
    {
      if($request->search)
                {

                    $receipts = Sale::with('receipts')->where([['status',0],['credit',1],['receipt_no',$request->search]])->whereColumn('total_net_amount' ,'>','received_amount')->get();

                    if(count($receipts)==0)
                    {
                        $receipts = Sale::with('receipts')->where([['status',0],['credit',1],['mobile',$request->search]])->whereColumn('total_net_amount' ,'>','received_amount')->orderBy('id','desc')->get();

                    }

                    return  $receipts;


                }

                else
                {
                    $receipts = Sale::with('receipts')->where([['status',0],['credit',1]])->whereColumn('total_net_amount' ,'>','received_amount')->get();
                    return  $receipts;
                }
        

    }
    public function closing_report()
    {   
        $payment_types = PaymentType::where('status',0)->get();  
        
        return view('reports.closing',compact('payment_types'));

    }
    public function closing_data(Request $request)
    {  


       $sql = Closing::where('closing_balance','!=',NULL)->get();
       if($request->from)
          $sql= Closing::whereDate('created_at','>=',$request->from)->where('closing_balance','!=',NULL);
        else{
            if($request->to)
                $sql= Closing::whereDate('created_at','<=',$request->to)->where('closing_balance','!=',NULL);
            else
                $sql= Closing::whereMonth('date',date('m'))->where('closing_balance','!=',NULL)->orderBy('created_at', 'desc');
        }
        if($request->to)
            $sql= Closing::whereDate('created_at','<=',$request->to)->where('closing_balance','!=',NULL);
        $closing_data = $sql->get();
        if($request->export == true) {
            Excel::create('Delivery Report '.DATE('Y_m_d_H_i_s'), function($excel) use($deliveries) {
                $excel->sheet('sheet1', function($sheet) use($deliveries) {
                    $sheet->loadView('exports.sales_report',compact('closing_data'));
                })->download('xlsx');
            });
        } else {
            return $closing_data;
        }

    }

    public function purchases_report()
    {
        
        $vendors = PurchaseVendor::where('status',0)->get();

        return view('reports.purchases',compact('vendors'));
    }
    public function purchase_report_data(Request $request)
    {
        $sql = PurchaseCredit::with('vendor')->where('status',0);
        if($request->from)
            $sql->whereDate('created_at','>=',$request->from);
        else
        { 
            if($request->to)
                $sql->whereDate('created_at','<=',$request->to);
            else
                $sql->whereDate('created_at',date('Y-m-d'))->get();
        }
        if($request->to)
            $sql->whereDate('created_at','<=',$request->to);


        if($request->vendor_id)
            $sql->where('vendor_id',$request->vendor_id);

        $purchases = $sql->get();


        if($request->export == true) {
            Excel::create('Purchase Report '.DATE('Y_m_d_H_i_s'), function($excel) use($purchases) {
                $excel->sheet('sheet1', function($sheet) use($purchases) {
                    $sheet->loadView('exports.purchase_report',compact('purchases'));
                })->download('xlsx');
            });
        } else {
            return $purchases;
        }
    }



    public function today_report()
    {        
        
        return view('reports.today_report');

    } 

       public function get_today_details_report(Request $request)
    {        
       if($request->date){
         $payment_types = PaymentType::where('status',0)->get();
        $open = Closing::where('date',$request->date)->first();
        if(!empty($open)){
         $total_opening = $open->total_opening;
         $openings = $open->opening_balance;
       }
       else{
        $total_opening = 0;
        $openings= [];
        foreach ($payment_types as $key => $value) {
            $openings[$key]['type'] = $value->name;
            $openings[$key]['amount'] = 0;
        }
       }
        
       //  $today_jobcards = Customer::where([['status',0],['sale_status',0]])->whereDate('created_at',$request->date)->get();
       //  $todaydelivered = Customer::where([['status',0],['reg_status',2],['sale_status',0]]) ->whereDate('delivered_date','=',$request->date)->get();
        $today_sales = Invoice::where('status',0)->whereDate('created_at',$request->date)->get();
        $expense_count = Expense::where('status',0)->whereDate('created_at',$request->date)->count();
        $expense_cats = Expense::select('*',DB::raw("SUM(amount) as total_amount"))->where('status',0)->whereDate('created_at',$request->date)->groupBy('expensecategory')->get();
      // $income_count = Income::where('status',0)->whereDate('created_at',$request->date)->count();
      // $income_cats = Income::select('*',DB::raw("SUM(amount) as total_amount"))->where('status',0)->whereDate('created_at',$request->date)->groupBy('incomecategory')->get();
       //  $saled_parts = Jobcard::select('*',DB::raw("SUM(qty) as total_qty"))->where([['status',0],['partno','!=',NULL]])->whereDate('created_at',$request->date)->groupBy('partno')->get();
        $date = $request->date;
        $saled_parts = [];
        $total_qty = 0;
        foreach ($today_sales as $key => $value) {
        
            $items = InvoiceItem::where([['status',0],['invoice_no',$value['invoice_no']]])->get();
           foreach ($items as $key => $value) {
               if($value->product){
                $total_qty +=  $value['qty']; 
               array_push($saled_parts, $value);
              }
           }
        }

        
             $coll_total_amount = 0;
             $balances = [];
             $collections = [];
             $expenses = [];
             foreach ($payment_types as $key => $value) {
               $balances[$key]['type'] = $value->name;
               $collections[$key]['type'] = $value->name;
               $expenses[$key]['type'] = $value->name;
               $coll =Payment::whereDate('created_at',$request->date)
                           ->where([['payment_type',$value->id],['invoice_no','>',0]]) 
                           ->sum('amount');
                $exp =Expense::whereDate('created_at',$request->date)
                           ->where([['status',0],['payment_type',$value->id]]) 
                           ->sum('amount');
                // $inc = Income::whereDate('created_at',$request->date)
                //            ->where([['status',0],['payment_type',$value->id]]) 
                //            ->sum('amount');   
                 $purchase = Payment::whereDate('created_at',Carbon::today())
                       ->where([['purchase_id','>',0],['payment_type',$value->id]]) 
                       ->sum('amount');  

                $collections[$key]['amount'] = $coll;
                $expenses[$key]['amount'] = $exp + $purchase;
                $coll_total_amount+= $coll;
                $balances[$key]['amount'] = $openings[$key]['amount']+ $coll- ($exp +  $purchase);
             }
             // $saled_s = Customer::where('status',0)->whereDate('delivered_date',$request->date)->get();
          
            
            


       }
       else{
        $payment_types = PaymentType::where('status',0)->get();
        $open = Closing::where('date',date('Y-m-d'))->first();
        if(!empty($open)){
         $total_opening = $open->total_opening;
         $openings = $open->opening_balance;
        }
        else{
            return "error";
        }
        // $today_jobcards = Customer::where([['status',0],['sale_status',0]])->whereDate('created_at',date('Y-m-d'))->get();
        $today_sales = Invoice::where('status',0)->whereDate('created_at',date('Y-m-d'))->get();
        // $todaydelivered = Customer::where([['status',0],['reg_status',2],['sale_status',0]]) ->whereDate('delivered_date','=',date('Y-m-d'))->get();
        $expense_count = Expense::where('status',0)->whereDate('created_at',date('Y-m-d'))->count();
        $expense_cats = Expense::select('*',DB::raw("SUM(amount) as total_amount"))->where('status',0)->whereDate('created_at',date('Y-m-d'))->groupBy('expensecategory')->get();
        // $income_count = Income::where('status',0)->whereDate('created_at',date('Y-m-d'))->count();
        // $income_cats = Income::select('*',DB::raw("SUM(amount) as total_amount"))->where('status',0)->whereDate('created_at',date('Y-m-d'))->groupBy('incomecategory')->get();
        // $saled_s = Customer::where('status',0)->whereDate('delivered_date',date('Y-m-d'))->get();
        $date = date('Y-m-d');
        $saled_parts = [];
        $total_qty = 0;
        foreach ($today_sales as $key => $value) {
        
            $items = InvoiceItem::where([['status',0],['invoice_no',$value['invoice_no']]])->get();
           foreach ($items as $key => $value) {
               if($value->product){
                $total_qty +=  $value['qty']; 
               array_push($saled_parts, $value);
              }
           }
        }
          if(!empty($open)){
             $coll_total_amount = 0;
             $balances = [];
             $collections = [];
             $expenses = [];
             foreach ($payment_types as $key => $value) {
               $balances[$key]['type'] = $value->name;
               $collections[$key]['type'] = $value->name;
               $expenses[$key]['type'] = $value->name;
               $coll =Payment::whereDate('created_at',Carbon::today())
                           ->where([['payment_type',$value->id],['invoice_no','>',0]]) 
                           ->sum('amount');
                // $inc = Income::whereDate('created_at',Carbon::today())
                //            ->where([['status',0],['payment_type',$value->id]]) 
                //            ->sum('amount');            
                $exp =Expense::whereDate('created_at',Carbon::today())
                           ->where([['status',0],['payment_type',$value->id]]) 
                           ->sum('amount'); 
                $purchase = Payment::whereDate('created_at',Carbon::today())
                       ->where([['purchase_id','>',0],['payment_type',$value->id]]) 
                       ->sum('amount');                      
                $collections[$key]['amount'] = $coll;
                $expenses[$key]['amount'] = $exp + $purchase;
                $coll_total_amount+= $coll;
                $balances[$key]['amount'] = $openings[$key]['amount']+ $coll - ($exp +  $purchase);
             }


          }


        }
         
        // $pendingcompletion = Customer::where([['status',0],['reg_status',0],['type',3],['sale_status',0]])->get();
        // $pendingdelivery = Customer::where([['status',0],['reg_status',1],['type',3],['sale_status',0]])->get();

        // $today_deliverd = $todaydelivered->count(); 
        // $total_pending_complition = $pendingcompletion->count(); 
        // $total_pending_delivery = $pendingdelivery->count(); 
        // $today_labour =$todaydelivered->sum('labour_amount');
        // $sale_count = 0;
        // $completed = 0;
        // $delivered = $todaydelivered->count();
        // $pending_complition = 1000;
        $total_amount = $today_sales->sum('total_net_amount');
        // $spare_amount = $todaydelivered->sum('spare_amount');
        // $labour_amount = $todaydelivered->sum('labour_amount');
        // $total_discount = $todaydelivered->sum('discount');
        // foreach ($today_sales as $sale) {
        //    $jobcard_count+=1;
        //    if($jobcard['reg_status']==1){
        //       $completed+=1;
        //    }
        
        // }
        
            $sale_count = 0;
            // $sale_spare_amount = 0;
            $sale_total_amount = 0;
            $sale_total_discount = 0;
            foreach ($today_sales as $sale) {
               $sale_count+=1;
               $sale_total_amount+= $sale['total_net_amount'];
               // $sale_spare_amount+= $sale['spare_amount'];
               $sale_total_discount+= $sale['total_discount'];
    
            }

                
        $exp_total_amount = 0; 
        $details=[];      
       foreach($expense_cats as $key => $value) {
         $exp_total_amount+= $value['total_amount'];
         $details[$key]['name'] = $value->expensecategory;
         $details[$key]['amount'] = $value->total_amount;
        }

       //  $inc_total_amount = 0; 
       //  $inc_details=[];      
       // foreach($income_cats as $key => $value) {
       //   $inc_total_amount+= $value['total_amount'];
       //   $inc_details[$key]['name'] = $value->incomecategory;
       //   $inc_details[$key]['amount'] = $value->total_amount;
       //  }
     
        
        $all_parts = [];          
        $item_total_amount = 0;       
        $item_total_qty = 0;
        foreach($saled_parts as $key => $value) {
         $all_parts[$key]['name'] = $value['product'];
         $all_parts[$key]['qty'] = $value['qty'];
         $all_parts[$key]['amount'] = ($value['qty'] * $value['rate']);
         $item_total_amount += ($value['qty'] * $value['rate']);
         $item_total_qty += $value['qty'];
         }

         //filter
         $parts = []; 
         $part_nos = array_column($all_parts, 'name');
         $QTYs  = array_column($all_parts, 'qty');
         $Mrps  = array_column($saled_parts, 'rate');

          $unique_names = array_unique($part_nos);

          foreach ($unique_names as $name){
            $this_keys = array_keys($part_nos, $name);
            $qty = array_sum(array_intersect_key($QTYs, array_combine($this_keys, $this_keys)));
            $amount =$Mrps[$this_keys[0]] * $qty;
            $parts[] = array("name"=>$name,"qty"=>$qty,"amount"=>number_format($amount, 2, '.', ','));
          }


        

        $Today_Details[] = [
                            'opening_balance'  => number_format($total_opening, 2, '.', ','),
                            'openings'  => $openings,

                            'total_coll'  => number_format($coll_total_amount, 2, '.', ','),
                            'collections'  => $collections,

                            'total_exp'  => number_format($exp_total_amount, 2, '.', ','),
                            // 'total_income'  => number_format($inc_total_amount, 2, '.', ','),
                            'expense'  => $expenses,

                            'balance_amount'  => number_format(($total_opening + $total_amount) - $exp_total_amount, 2, '.', ','),
                            'balances'  => $balances,

                            // 'jobcards'  => $jobcard_count,
                            // 'pending_complition'  => $pending_complition,
                            // 'completed'  => $completed,
                            // 'delivered'  => $delivered,
                            // 'today_delivered'  => $today_deliverd,
                            // 'total_pending_complition'  => $total_pending_complition,
                            // 'total_pending_delivery'  => $total_pending_delivery,
                            // 'spare_amount'  => number_format($spare_amount, 2, '.', ','),
                            // 'labour_amount'  => number_format($labour_amount, 2, '.', ','),
                            // 'total_discount'  => number_format($total_discount, 2, '.', ','),
                            // 'total_amount'  => number_format($total_amount, 2, '.', ','),
                            'sales'  => $sale_count,
                            // 'sale_spare_amount'  => number_format($sale_spare_amount, 2, '.', ','),
                            'sale_total_discount'  => number_format($sale_total_discount, 2, '.', ','),
                            'sale_total_amount'  => number_format($sale_total_amount, 2, '.', ','),
                            'expenses'  => $expense_count,
                            // 'incomes'  => $income_count,
                            'cats'  => $details? $details:'',
                            // 'inc_cats'  => $inc_details? $inc_details:'',
                            'exp_total_amount'  => number_format($exp_total_amount, 2, '.', ','),
                            // 'inc_total_amount'  => number_format($inc_total_amount, 2, '.', ','),
                            'parts'  => $parts? $parts:'',
                            'item_total_qty'  => number_format($item_total_qty, 2, '.', ','),
                            'item_total_amount'  => number_format($item_total_amount, 2, '.', ','),
                            'date'  => $date,

                                               
                        ];                
        if($request->export==true){
            $pdf = PDF::loadView('exports.day_report', ['details' => $Today_Details[0]])
                ->setPaper('a4', 'potrait');
         
             $filename = uniqid();
             $filename='DETAIL_'.date('YmdHis').'.pdf';
    
             return $pdf->stream($filename);

        }
        else{
            return $Today_Details[0];
        }    
    }
    public function purchasecredit_index()
    {
        $payment_types = PaymentType::where('status',0)->get();
        return view('reports.purchasecredits',compact('payment_types'));
    }
    public function purchasecredit_report()
    {

         $deliveries = PurchaseCredit::with('vendor')->where([['status',0],['payment',0]])->whereColumn('amount' ,'>','payed_amount')->get()->unique('vendor_id');
        
        
        foreach ($deliveries as $delivery) {
            $total_credit=PurchaseCredit::where([['status',0],['vendor_id',$delivery->vendor_id],['payment',0]])->sum('amount');
            $total_payed=PurchaseCredit::where([['status',0],['vendor_id',$delivery->vendor_id],['payment',0]])->sum('payed_amount');
            $credit_left=$total_credit-$total_payed;
            $delivery['balance_amount']= $credit_left;
        }
 
        return $deliveries;
    }
    public function purchase_details($id)
    {

       $purchases =  PurchaseCredit::with('vendor')->where([['status','0'],['payment',0],['vendor_id',$id]])->orderBy('created_at','desc')->get();
        //return $purchases;
        return view('admin.paybalancepurchase',compact('purchases'));
    }
    public function deliveries_report_data(Request $request)
    {
        $sql = Customer::with(['jobcards','customercategories','customercategories.category','customercategories.catremark','advisor'])->where([
           ['reg_status',2],
           ['status','>=',0],['type','>=',2]
       ]);
        if($request->from)
            $sql->whereDate('delivered_date','>=',$request->from);
        else{
            if($request->to)
                $sql->whereDate('delivered_date','<=',$request->to);
            else
                $sql->whereDate('delivered_date',date('Y-m-d'));
        }
        if($request->to)
            $sql->whereDate('delivered_date','<=',$request->to);
        $deliveries = $sql->get();
        
        if($request->export == true) {
            Excel::create('Delivery Report '.DATE('Y_m_d_H_i_s'), function($excel) use($deliveries) {
                $excel->sheet('sheet1', function($sheet) use($deliveries) {
                    $sheet->loadView('exports.delivery_report',compact('deliveries'));
                })->download('xlsx');
            });
        } else {
            return $deliveries;
        }

    }
    public function return_report()
    {
        $deliveries = Customer::with(['jobcards','customercategories','customercategories.category','customercategories.catremark','advisor'])->where([['status','0'],['return_status',1],['reg_status','<',2]]);
        $deliveries= $deliveries->get();

        return view('reports.return_list',compact('deliveries'));

    }
    public function return_report_data(Request $request)
    {
        $sql = Customer::with(['jobcards','customercategories','customercategories.category','customercategories.catremark','advisor'])->where([
            ['return_status',1],
            ['status',0]
        ])->whereIn( 'type',['4','3']);
       if($request->from && $request->to)
       {
        $sql->whereDate('return_date','>=',$request->from)->whereDate('return_date','<=',$request->to);
        $deliveries = $sql->get();

       }
       else{
        $deliveries = Customer::with(['jobcards','customercategories','customercategories.category','customercategories.catremark','advisor'])->where([['status','0'],['return_status',1],['reg_status','<',2]])->get();
       }

        if($request->export == true) {
            Excel::create('Delivery Report '.DATE('Y_m_d_H_i_s'), function($excel) use($deliveries) {
                $excel->sheet('sheet1', function($sheet) use($deliveries) {
                    $sheet->loadView('exports.return_report',compact('deliveries'));
                })->download('xlsx');
            });
        } else {
            return $deliveries;
        }

    }


    public function campaigns_report_data(Request $request)
    {
        $sql = Campaign::where([
        	['company_id',Auth::user()->company_id],
        	['status',0]
        ])
        ->select('campaign_id','company_id','name','code','from_date','to_date','amount')
        ->with([
        	'customers' =>function($query) use($request) {
        		$query->select('customer_id','campaign_id','redeem_amount','redeem_status');
        		if($request->from)
        			$query->whereDate('added_date','>=',$request->from);
        		if($request->to)
        			$query->whereDate('added_date','<=',$request->to);
        	}
        ]);

        if($request->campaign_id)
        	$sql->where('campaign_id',$request->campaign_id);

        $campaigns = $sql->get();
        $campaigns->each(function ($campaign, $key) {
            $campaign->total_redeemed = $campaign->customers->where('redeem_status',1)->sum('redeem_amount');
            $campaign->total_bookings = $campaign->customers->count();
            $campaign->unsetRelation('customers');

            $campaign->period = DATE('d-m-Y', strtotime($campaign->from_date)).' to '.DATE('d-m-Y', strtotime($campaign->to_date));
        });

        if($request->export == true) {
        	Excel::create('Campaign Report '.DATE('Y_m_d_H_i_s'), function($excel) use($campaigns) {
        		$excel->sheet('sheet1', function($sheet) use($campaigns) {
        			$sheet->loadView('exports.campaign_report',compact('campaigns'));
        		})->download('xlsx');
        	});
        } else {
        	return $campaigns;
        }
    }



    // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444 
     // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
       // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
         // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
           // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
             // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444

    public function expenses_report()
    {
        $expensecategories = ExpenseCategory::select('id','name')->where('status',0)->get();

        return view('reports.expenses',compact('expensecategories'));
    }


    
    public function expenses_report_data(Request $request)
    {
        $sql = Expense::where('status',0);
        if($request->from)
            $sql->whereDate('created_at','>=',$request->from);
        else
        { 
            if($request->to)
                $sql->whereDate('created_at','<=',$request->to);
            else
                $sql->whereDate('created_at',date('Y-m-d'))->get();
        }
        if($request->to)
            $sql->whereDate('created_at','<=',$request->to);


        if($request->expensecategory)
            $sql->where('expensecategory',$request->expensecategory);

        $expenses = $sql->get();


        if($request->export == true) {
            Excel::create('Expense Report '.DATE('Y_m_d_H_i_s'), function($excel) use($expenses) {
                $excel->sheet('sheet1', function($sheet) use($expenses) {
                    $sheet->loadView('exports.expense_report',compact('expenses'));
                })->download('xlsx');
            });
        } else {
            return $expenses;
        }
    }




    // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444 
     // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
       // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
         // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
           // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444
             // 4444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444444






   public function return_page()
    {
       

        return view('reports.returns');
    }
    public function return_item(Request $request)
    {

        $invoice = InvoiceItem::where([['status',0],['invoice_no',$request->invoice_no]])->first();
        return $invoice;
    }



    public function invoices_report()
    {
    	$companies = Company::where('status',0)->orderBy('name')->get();
    	return view('reports.invoices',compact('companies'));
    }

    public function invoices_report_data(Request $request)
    {
         $sql = Invoice::with('company')->where('status',0);
        if($request->from)
            $sql->whereDate('created_at','>=',$request->from);
        else
        { 
            if($request->to)
                $sql->whereDate('created_at','<=',$request->to);
            else
                $sql->whereDate('created_at',date('Y-m-d'))->get();
        }
        if($request->to)
            $sql->whereDate('created_at','<=',$request->to);


        if($request->agency)
            $sql->where('company_id',$request->company_id);

        $expenses = $sql->get();


        if($request->export == true) {
            Excel::create('Invoice Report '.DATE('Y_m_d_H_i_s'), function($excel) use($expenses) {
                $excel->sheet('sheet1', function($sheet) use($expenses) {
                    $sheet->loadView('exports.invoice_report',compact('expenses'));
                })->download('xlsx');
            });
        } else {
            return $expenses;
        }

        
    }

    public function download()
    {

        Excel::create('Excel Format', function($excel){
            $excel->sheet('sheet1', function($sheet) {
                $sheet->loadView('exports.download_format');
            })->download('xlsx');
        });
        
    }
    public function customer_report()
    {

        $sql = Customer::where('status',0)
        ->select('name','reg_no','mobile','type')
        ->get();

        $deliveries = $sql->unique('mobile');
        
        Excel::create('Unique Customer Report '.DATE('Y_m_d_H_i_s'), function($excel) use($deliveries) {
            $excel->sheet('sheet1', function($sheet) use($deliveries) {
                $sheet->loadView('exports.customer_report',compact('deliveries'));
            })->download('xlsx');
        });
        
        
    }


    public function balance_sheet()
    {

        return view('reports.balancesheet');
    }
    public function balance_sheet_data(Request $request)
    {


     if(Input::has('company_id'))
         {
             $company_id = Input::get('company_id');
             $company=Company::find($company_id);

         }
         else
         {
           $company= Auth::user()->company;
       }
       if($request->from && $request->to) {
         $from = $request->from;
         $to = $request->to;
     } else {
         $from = $to = DATE('Y-m-d');
     }

     if($request->print == true)
     {
        $amountfrombooking = Customer::select('id','jobcard_no','total_amount','jobcard_prefix','delivered_date','payment_type','sale_status','receipt_no','created_at','return_status')->where([['status','>=',0],['reg_status',2],['type',3],['renter_status',0]])->whereDate('delivered_date','>=',$from)->whereDate('delivered_date','<=',$to)->get();
        $amountfromcredit=Customer::select('id','name','total_amount','created_at','payment_type')->where([['status',0],['type',5]])->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
        $incomecollected = Income::select('id','incomecategory','name','amount','created_at','payment_type')->where([['status',0]])->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
        $amountdebited = Expense::select('id','expensecategory','amount','name','created_at','payment_type')->where([['status',0]])->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
        $purchaseexpenses = PurchaseCredit::with('vendor')->select('id','vendor_id','amount','remarks','created_at','payment_type')->where([['status',0],['payment',1]])->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
    }
    else{

        $bal=Auth::user()->company->opening_balance?Auth::user()->company->opening_balance:0;

        $amountcollectedfrombooking = Customer::select('id','jobcard_no as description','total_amount as credit','delivered_date as transaction_date','payment_type')->orderBy('delivered_date')->where([['status','>=',0],['reg_status',2],['type',3],['renter_status',0]]);
        $amountcollectedfromcredit=Customer::select('id','jobcard_no as description','total_amount as credit','created_at as transaction_date','payment_type')->orderBy('created_at')->where([['status',0],['type',5]]);
        $incomecollected = Income::select('id','incomecategory as description','amount as credit','created_at as transaction_date','payment_type')->where('status',0)->orderBy('created_at');
        $amountdebited = Expense::select('id','expensecategory as description','amount as debit','created_at as transaction_date','payment_type')->where('status',0)->orderBy('created_at');
        $c=clone $amountcollectedfrombooking;
        $cc=clone  $amountcollectedfromcredit;
        $i=clone  $incomecollected;
        $d = clone $amountdebited;
        if($request->from)
        {
            $amountcollectedfrombooking=  $amountcollectedfrombooking->whereDate('delivered_date','>=',$request->from);
            $amountcollectedfromcredit= $amountcollectedfromcredit->whereDate('created_at','>=',$request->from);
            $incomecollected= $incomecollected->whereDate('created_at','>=',$request->from);

            $amountdebited= $amountdebited->whereDate('created_at','>=',$request->from);
            
            $credit= $c->whereDate('delivered_date','<=',$request->from);
            $creditpay=$cc->whereDate('created_at','>=',$request->from);
            $income=$i->whereDate('created_at','>=',$request->from);
            $debit= $d->whereDate('created_at','<=',$request->from);

            $bal = $bal + $credit->sum('total_amount')+ $income->sum('amount')+$creditpay->sum('total_amount');
            $bal = $bal - $debit->sum('amount');


        }
        else
        { 
            if($request->to)
            {
                $amountcollectedfrombooking= $amountcollectedfrombooking->whereDate('delivered_date','<=',$request->to);
                $amountcollectedfromcredit= $amountcollectedfromcredit->whereDate('created_at','<=',$request->to);
                $incomecollected=$incomecollected->whereDate('created_at','<=',$request->to);
                $amountdebited= $amountdebited->whereDate('created_at','<=',$request->to);

            }
            else
            {
                $amountcollectedfrombooking= $amountcollectedfrombooking->whereDate('delivered_date',date('Y-m-d'));
                $amountcollectedfromcredit=$amountcollectedfromcredit->whereDate('created_at',date('Y-m-d'));
                $incomecollected=$incomecollected->whereDate('created_at',date('Y-m-d'));
                $amountdebited= $amountdebited->whereDate('created_at',date('Y-m-d'));

                $credit= $c->whereDate('delivered_date','<=',date('Y-m-d'));
                $creditpay=$cc->whereDate('created_at','<=',date('Y-m-d'));
                $income=$i->whereDate('created_at','<=',date('Y-m-d'));
                $debit= $d->whereDate('created_at','<=',date('Y-m-d'));

                $bal = $bal + $credit->sum('total_amount') +  $income->sum('amount') +$creditpay->sum('total_amount');
                $bal = $bal - $debit->sum('amount');
            }
        }
        if($request->to)
        {
            $amountcollectedfrombooking= $amountcollectedfrombooking->whereDate('delivered_date','<=',$request->to);
            $amountcollectedfromcredit=$amountcollectedfromcredit->whereDate('created_at','<=',$request->to);
            $incomecollected=$incomecollected->whereDate('created_at','<=',$request->to);
            $amountdebited= $amountdebited->whereDate('created_at','<=',$request->to);
        }

        
        $amountcollectedfrombooking= $amountcollectedfrombooking->get();
        $amountcollectedfromcredit=$amountcollectedfromcredit->get();
        $incomecollected=$incomecollected->get();
        $amountdebited= $amountdebited->get();

        $transactions= $amountcollectedfrombooking->merge($amountcollectedfromcredit);
        $transactions=$transactions->merge($amountdebited);
        $transactions= $transactions->merge($incomecollected);
        
        $transactions= $transactions->sortBy('transaction_date')->values()->all();
    }






    if($request->export == true) {
        Excel::create('Balance Sheet Report '.$request->from.'_'.$request->to, function($excel) use($transactions,$bal) {
            $excel->sheet('sheet1', function($sheet) use($transactions, $bal) {
                $sheet->loadView('exports.balance_sheet_report',compact('transactions','bal'));
            })->download('xlsx');
        });
    } else if($request->print == true)
    {
        $pdf = PDF::loadView('exports.daily_report', ['company'=>$company,'amountfrombooking'=>$amountfrombooking,'amountfromcredit'=>$amountfromcredit,'incomecollected'=>$incomecollected,'amountdebited'=>$amountdebited,'purchaseexpenses'=>$purchaseexpenses])->setPaper('a5', 'potrait');
        $filename = uniqid();
        $filename='DAYREPORT'.date('YmdHis').'.pdf';
        return $pdf->stream($filename);
    }

    else {
        return $transactions;
    }

}

public function paycredit_report()
{

    $deliveries = Customer::where([['status','0'],['type',5]])->whereDate('created_at',date('Y-m-d'))->get();
    return view('reports.paycredits',compact('deliveries'));
}
public function paycredit_report_data(Request $request)
{
    $sql = Customer::where([
     ['status',0],['type',5]
 ]);
    if($request->from)
        $sql->whereDate('created_at','>=',$request->from);
    else{
        if($request->to)
            $sql->whereDate('created_at','<=',$request->to);
        else
            $sql->whereDate('created_at',date('Y-m-d'));
    }
    if($request->to)
        $sql->whereDate('created_at','<=',$request->to);
    $deliveries = $sql->get();
    if($request->export == true) {
        Excel::create('PayCredit Report '.DATE('Y_m_d_H_i_s'), function($excel) use($deliveries) {
            $excel->sheet('sheet1', function($sheet) use($deliveries) {
                $sheet->loadView('exports.paycredit_report',compact('deliveries'));
            })->download('xlsx');
        });
    } else {
        return $deliveries;
    }

}

public function payvendorcredit_report()
{

    $deliveries = PurchaseCredit::with('vendor')->where([['status','0'],['payment',1]])->whereDate('created_at',date('Y-m-d'))->get();
    return view('reports.payvendorcredits',compact('deliveries'));
}
public function payvendorcredit_report_data(Request $request)
{
    $sql = PurchaseCredit::with('vendor')->where([['status','0'],['payment',1]]);
    if($request->from)
        $sql->whereDate('created_at','>=',$request->from);
    else{
        if($request->to)
            $sql->whereDate('created_at','<=',$request->to);
        else
            $sql->whereDate('created_at',date('Y-m-d'));
    }
    if($request->to)
        $sql->whereDate('created_at','<=',$request->to);
    $deliveries = $sql->get();
    if($request->export == true) {
        Excel::create('PayVendorCredit Report '.DATE('Y_m_d_H_i_s'), function($excel) use($deliveries) {
            $excel->sheet('sheet1', function($sheet) use($deliveries) {
                $sheet->loadView('exports.payvendorcredit_report',compact('deliveries'));
            })->download('xlsx');
        });
    } else {
        return $deliveries;
    }

   }
   public function items_report()
    {
       $products = Product::where('status',0)->orderBy('name')->get();


        return view('reports.item_report',compact('products'));
    }
    public function items_report_data(Request $request)
    {

        $sql = PurchaseLog::with('vendor')->where([
            ['status',0]
        ]);
        $sql2 = InvoiceItem::with('customer')->where([
            ['status',0]
        ]);
        if($request->from){
            $sql->whereDate('created_at','>=',$request->from);
            $sql2->whereDate('created_at','>=',$request->from);
        }    
        else
        { 
            if($request->to){
                $sql->whereDate('created_at','<=',$request->to);
                $sql2->whereDate('created_at','<=',$request->to);
            }    
            else{
                $sql->whereDate('created_at',date('Y-m-d'))->get();
                $sql2->whereDate('created_at',date('Y-m-d'))->get();
            }    
        }
        if($request->to){
            $sql->whereDate('created_at','<=',$request->to);
            $sql2->whereDate('created_at','<=',$request->to);
        }    
        
        if($request->product=='' && $request->from=='' && $request->from==''){ 
            $sql->take(10);
            $sql2->take(10);
          } 

        if($request->product){
            $sql->where('product',$request->product);
            $sql2->where('product',$request->product);
        }    

        $purchases = $sql->get();
        $deliveries = $sql2->get();
         

        $datas = [];
        foreach ($purchases as $key => $value) {
          $datas[$key]['product'] = $value->product;
          $datas[$key]['qty'] = $value->qty;
          $datas[$key]['created_at'] = date($value->created_at);
          if($value->log_status == 0){
            $datas[$key]['status'] = 'UPLOADED';
          }  
          else{
            $datas[$key]['status'] = 'RETURNED';
          }  
          $datas[$key]['invoice'] = $value->purchase_id;;
          $datas[$key]['customer'] ='-';
          $datas[$key]['customer'] =$value->vendor['name'];
        }
        $data2 = [];
        foreach ($deliveries as $key => $value) {
          $data2['product'] = $value->product;
          $data2['qty'] = $value->qty;
          $data2['created_at'] = date($value->created_at);
         if($value->invoice_no){
              $data2['invoice'] = $value->invoice_no;
               $data2['status'] = 'INVOICE';
           }   
          else{  
              
              $data2['invoice'] = '-';
               $data2['status'] = '-';

           } 
           $data2['customer'] = $value->customer->name;
            

          array_push($datas,$data2);
        }

        
          $sorted = collect($datas);
          $updations = $sorted->SortByDesc("created_at")->values();



        if($request->export == true) {
            Excel::create('Items Report '.DATE('Y_m_d_H_i_s'), function($excel) use($updations) {
                $excel->sheet('sheet1', function($sheet) use($updations) {
                    $sheet->loadView('exports.item_report',compact('updations'));
                })->download('xlsx');
            });
        } else {
            return $updations;
        }
    }
}
