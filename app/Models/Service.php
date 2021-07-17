<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Service extends Model
{
   	public function campaigns() {
   		return $this->hasMany(Campaign::class,'service_type','id')->where('status',0);
   	}

   	public function customers() {
   		return $this->hasManyThrough(Customer::class,Campaign::class,'service_type','campaign_id','id')
   		->where([
   			['customers_'.Auth::user()->company_id.'.status',0],
   			['campaigns.status',0],
   		]);
   	}
   
   	public function redeemed_customers() {
   		return $this->hasManyThrough(Customer::class,Campaign::class,'service_type','campaign_id','id')
   		->where([
   			['customers_'.Auth::user()->company_id.'.status',0],
   			['campaigns.status',0],
   			['customers.redeem_status',1],
   		]);
   	}

}
