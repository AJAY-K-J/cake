<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
// use App\Models\stockUploadDetail;
use App\Models\PurchaseVendor;
// use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use Excel;


class StockController extends Controller
{
    public function index()
    {
        // $vendors = Vendor::where('created_by', Auth::id())
        //                     ->where('status', 0)
        //                     ->get();

        // $stockLogs = StockUploadLog::select('stockupload_logs.*', 'vendors.name')
        //                     ->where('stockupload_logs.created_by', Auth::id())
        //                     ->leftJoin('vendors', 'stockupload_logs.vendor_id', '=', 'vendors.id')
        //                     ->orderBy('stockupload_logs.id', 'DESC')
        //                     ->get();

        // return view('admin.stocks.index',  compact('vendors', 'stockLogs'));
    }

    public function stockreport() 
    {
         $vendors = PurchaseVendor::where('status','0')->orderBy('name')->get();

        return view('reports.stockreport',compact('vendors'));
    }

    public function get_stocks(Request $request)
    {
       $stocks = Stock::with('product')->where('status','0')->get();
       
            return $stocks;
        
    }

    public function find_stock($id)
    {
        $stock = Stock::with('product')->where('id',$id)->first();
        return  $stock;
    }

  public function edit_stock(Request $request)
  {
       
       $request->validate([
        
              'product_id' => 'required',
              'qty' => 'required',
             
          ]);

       if($request->id){
           $stock = Stock::find($request->id);
       }
       $stock->product_id = $request->product_id;
       $stock->qty = $request->qty;
      
       $stock->save();

       return 'Success';
   }
   
  

    public function delete_stock(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $stock = Stock::find($request->id);
        $stock->status = -1;
        $stock->save();

        return 'Success';
    }

    // public function viewStockDetails($logId)
    // {
    //     $stockDetails = stockUploadDetail::where('upload_id', $logId)->get();

    //     return view('admin.stocks.view-details',  compact('stockDetails'));
    // }

    public function get_rate_by_partno(Request $request)
    {   
        $request->validate([
            'partno' => 'required',
        ]);
        
        $rate = Stock::where([['status','0'],['partno_full',$request->partno]])->first();

        return $rate;
    }
    public function get_rate_by_desc(Request $request)
    {   
        $request->validate([
            'description' => 'required',
        ]);
        
        $rate = Stock::where([['status','0'],['description',$request->description]])->first();

        return $rate;
    }
}
