<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products');
    }

    public function get_products()
    {
    	$products = Product::where('status','0')->get();
    	return $products;
    }

    public function save(Request $request)
    {
		$request->validate([
			'name' => [
		        'required',
		        Rule::unique('products')
		        ->ignore($request->id)
		        ->where(function ($query) {
					return $query->where('status','0');
				}),
		    ]
		]);

		if($request->id){
			$product = Product::find($request->id);
		}
		else
			$product = new Product;

		$product->name = strtoupper($request->name);
		if($request->mrp){
		  $product->mrp = $request->mrp;
		}
        if($request->gst){
          $product->gst = $request->gst;
        }
       
		$product->save();
		return 'Success';
    }
    public function get_rate_by_product(Request $request)
    {   
        $request->validate([
            'product' => 'required',
        ]);
        
        $rate = Product::with('stock')->where([['status','0'],['name',$request->product]])->first();
        
        return $rate;
    }
    public function delete_product(Request $request) {
    	$request->validate([
			'id' => 'required',
		]);

    	$product = Product::find($request->id);
    	$product->status = -1;
    	$product->save();

    	return 'Success';
    }
}
