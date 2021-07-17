<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;	
use Auth;
class Invoice extends Model
{
    public function __construct() {
        $this->table = 'invoices';
                
    }
    public function items() {
        return $this->hasMany(InvoiceItem::class, 'invoice_no', 'invoice_no')->where('status', 0);
    }
    public function payments() {
        return $this->hasMany(Payment::class, 'invoice_no', 'invoice_no')->where('status', 0);
    }
    
    
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
