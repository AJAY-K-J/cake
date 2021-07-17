<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Model
{
    // public function __construct() {

    //        $this->table = 'products';
       
        
    // }
     public function stock() {
        return $this->belongsTo(Stock::class,'id','product_id')->where('status',0);;
    }

}