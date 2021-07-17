<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public function customers() {
        return $this->hasMany(Customer::class,'campaign_id','campaign_id')->where('status',0);
    }

   	function service() {
        return $this->belongsTo(Service::class,'service_type','id')->where('status',0);
    }

    public function redeemed_customers() {
        return $this->hasMany(Customer::class,'campaign_id','campaign_id')->where('status',0)->where('redeem_status',1);
    }

    public function company() {
        return $this->belongsTo(Company::class,'company_id','id')->where('status',0);
    }
}