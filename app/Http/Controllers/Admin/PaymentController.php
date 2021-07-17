<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\PurchaseCredit;
use App\Models\Jobcard;
use App\Models\Payment;
use App\Models\PaymentType;
use Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function index(Invoice $invoice) {

		$payment_types = PaymentType::where('status',0)->get();

		return view('admin.payments', compact('payment_types','invoice'));
	}
	public function purchase_index($purchase_id) {
		//return $purchase_id;
		$payment_types = PaymentType::where('status',0)->get();

        $purchase = PurchaseCredit::with('vendor')->where('id',$purchase_id)->first();
		return view('admin.purchase_payments', compact('payment_types','purchase'));
	}
	public function get_payments(Request $request) {
      
      $payments = Payment::where([['invoice_no', $request->invoice_no],['status',0]])->with('payment_type:id,name')->get(); 

	  return $payments; 
	}
	public function get_purchasepayments(Request $request) {
      
		$payments = Payment::where([['purchase_id', $request->purchase_id],['status',0]])->with('payment_type:id,name')->get();

	  return $payments; 
	}
	public function add_payment(Request $request) {
		
		$this->validate($request, [
			'payment_type' => 'required',
			'amount' => 'required',
		]);
       
        if($request->id){
           $payment = Payment::findOrFail($request->id);
           $pre_amount = $payment->amount;
       }
        else{
           $payment = new Payment;
        }
 
			$payment->invoice_no = $request->invoice_no;
			 $invoice = Invoice::where([['invoice_no',$request->invoice_no],['status',0]])->first();

		$payment->payment_type = $request->payment_type;
		$payment->amount = $request->amount;
		$payment->remarks = $request->remarks;
        
		
		
		if($request->id){
			$paid = $invoice->received_amount - $pre_amount; 
		}
		else{
			$paid = $invoice->received_amount;
		}
		if(($invoice->total_net_amount - $paid) < $request->amount){
			return 'error';
		}
		else{
		 $payment->save();
		 
		 $amount=Payment::where([['invoice_no',$request->invoice_no],['status',0]])->sum('amount');
		 $invoice->received_amount=$amount;	
		 $invoice->save();
		} 
		return "Success";
		
	}
	public function add_purchasepayment(Request $request) {
		//return $request->all(); 
		$this->validate($request, [
			'payment_type' => 'required',
			'amount' => 'required',
		]);
       
        if($request->id){
           $payment = Payment::findOrFail($request->id);
           $pre_amount = $payment->amount;
       }
        else{
           $payment = new Payment;
        }
       
		 $payment->purchase_id = $request->purchase_id;
		 $purchase = PurchaseCredit::where([['id',$request->purchase_id],['status',0]])->first();
		//return 	 $purchase;
        
		
		$payment->payment_type = $request->payment_type;
		$payment->amount = $request->amount;
		$payment->remarks = $request->remarks;
		
		if($request->id){
			$paid = $purchase->payed_amount - $pre_amount; 
		}
		else{
			$paid = $purchase->payed_amount;
		}
		if(($purchase->amount - $paid) < $request->amount){
			return 'error';
		}
		else{
		 $payment->save();
		 	$amount=Payment::where([['purchase_id',$request->purchase_id],['status',0]])->sum('amount');
		 $purchase->payed_amount=$amount;	
		 $purchase->save();
		} 
		return "Success";
		
	}
	public function delete_payment(Request $request) {
		$payment = Payment::findOrFail($request->id);
	
		$invoice = Invoice::where([['invoice_no',$request->invoice_no],['status',0]])->first();
	    $payment->delete();
	    $amount=Payment::where([['invoice_no',$request->invoice_no],['status',0]])->sum('amount');
		$invoice->received_amount=$amount;
		$invoice->save();
		return "Success";	  	
	     
	}
	public function delete_purchasepayment(Request $request) {
		$payment = Payment::findOrFail($request->id);
	    $purchase_id = $payment->purchase_id;
		$purchase = PurchaseCredit::where([['purchase_id',$purchase_id],['status',0]])->first();
	    $payment->delete();
	    $amount=Payment::where([['purchase_id',$purchase_id],['status',0]])->sum('amount');
		$purchase->payed_amount=$amount;
		$purchase->save();
		return "Success";	  	
	    
	}
	public function rec_index(Sale $sale) {

		$payment_types = PaymentType::where('status',0)->get();

		return view('admin.rec_payments', compact('payment_types','sale'));
	}

	public function get_rec_payments(Request $request) {
      
      $payments = Payment::where([['receipt_no', $request->receipt_no],['status',0]])->with('payment_type:id,name')->get(); 

	  return $payments; 
	}

	public function add_rec_payment(Request $request) {
		
		$this->validate($request, [
			'payment_type' => 'required',
			'amount' => 'required',
		]);
       
        if($request->id){
           $payment = Payment::findOrFail($request->id);
           $pre_amount = $payment->amount;
       }
        else{
           $payment = new Payment;
        }
 
			$payment->receipt_no = $request->receipt_no;
			 $sale = Sale::where([['receipt_no',$request->receipt_no],['status',0]])->first();

		$payment->payment_type = $request->payment_type;
		$payment->amount = $request->amount;
		$payment->remarks = $request->remarks;
        
		
		
		if($request->id){
			$paid = $sale->received_amount - $pre_amount; 
		}
		else{
			$paid = $sale->received_amount;
		}
		if(($sale->total_net_amount - $paid) < $request->amount){
			return 'error';
		}
		else{
		 $payment->save();
		 
		 $amount=Payment::where([['receipt_no',$request->receipt_no],['status',0]])->sum('amount');
		 $sale->received_amount=$amount;	
		 $sale->save();
		} 
		return "Success";
		
	}

	public function delete_rec_payment(Request $request) {
		$payment = Payment::findOrFail($request->id);
	
		$sale = Sale::where([['receipt_no',$request->receipt_no],['status',0]])->first();
	    $payment->delete();
	    $amount=Payment::where([['receipt_no',$request->receipt_no],['status',0]])->sum('amount');
		$sale->received_amount=$amount;
		$sale->save();
		return "Success";	  	
	     
	}

}
