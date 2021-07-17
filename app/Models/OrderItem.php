<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;	
use Auth;
class OrderItem extends Model
{
    public function __construct() {
        $this->table = 'order_items';
                
    }
    
    
}
