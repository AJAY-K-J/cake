<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;	
use App\Models\Invoice;
use Auth;
class InvoiceItem extends Model
{
    public function __construct() {
        $this->table = 'invoice_items';
                
    }
    public function customer() {
       return $this->belongsTo(Invoice::class,'invoice_no','invoice_no')->where('status',0);

   }
    
}
