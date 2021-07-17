<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Auth;

class LoyalCustomer extends Model
{
	public function __construct() {
		$this->table = 'loyalcustomers_'.Auth::user()->company_id;
	}
}