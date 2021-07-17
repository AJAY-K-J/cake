<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;	
use App\Models\SaleDetail;
use Auth;
class Sale extends Model
{
    public function __construct() {
        $this->table = 'sales';
                
    }
    public function receipts() {
        return $this->hasMany(SaleDetail::class, 'receipt_no', 'receipt_no')->where('status', 0);
    }
    
}
