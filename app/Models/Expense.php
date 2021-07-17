<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;	
use Auth;
class Expense extends Model
{
    public function __construct() {
        $this->table = 'expenses';
                
    }
    public function company() {
        return $this->belongsTo(Company::class,'company_id','id')->where('status',0);;
    }
    
}
