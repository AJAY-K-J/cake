<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;	
use Auth;
class SaleDetail extends Model
{
    public function __construct() {
        $this->table = 'sale_details';
                
    }
    
    
}
