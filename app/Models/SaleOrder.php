<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;	
use Auth;
class SaleOrder extends Model
{
    public function __construct() {
        $this->table = 'sale_orders';
                
    }
    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id')->where('status', 0);
    }
}
