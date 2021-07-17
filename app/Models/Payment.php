<?php

namespace App\Models;

use App\Models\PaymentType;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Payment extends Model
{
	public function __construct() {
		$this->table = 'payments';
		
	}
	public function payment_type() {
		return $this->belongsTo(PaymentType::class,'payment_type','id');
	}
}
