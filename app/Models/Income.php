<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Income extends Model
{
    public function __construct() {
        $this->table = 'incomes';
    }
    public function company() {
        return $this->belongsTo(Company::class,'company_id','id')->where('status',0);;
    }
    
}
