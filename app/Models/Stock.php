<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Auth;
class Stock extends Model
{
    public function __construct() {
        $this->table = 'stocks';
    }
    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }
  
   
}
