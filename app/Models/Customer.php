<?php

namespace App\Models;

use App\Models\Image;
use App\Models\User;
use App\Models\CustomerCategory;
use App\Models\CustomerTechnician;
use App\Models\CustomerCall;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Customer extends Model
{
	public function __construct() {
        if(Input::has('company_id'))
        {
            $this->table = 'customers_'.Input::get('company_id');

        }
        else
        {
           $this->table = 'customers_'.Auth::user()->company_id;
        }
		
	}

    public function jobcard_table() {
        if(Input::has('company_id'))
        {
           return "jobcards_".Input::get('company_id');
       }
       else
       {
        return "jobcards_".Auth::user()->company_id;
       }
    }

    public function jobcards() {
        return $this->hasMany(Jobcard::class, 'jobcard_no', 'jobcard_no')->where('status', 0);
    }
    public function receipts() {
        return $this->hasMany(Jobcard::class, 'receipt_no', 'receipt_no')->where('status', 0);
    }
    public function customercategories() {
        return $this->hasMany(CustomerCategory::class, 'jobcard_no', 'jobcard_no')->where('status', 0);
    }
    public function advisor() {
        return $this->belongsTo(Employee::class, 'jobadvisor_id', 'id')->where('status', 0);
    }
    public function images() {
        return $this->hasMany(Image::class, 'jobcard_no', 'jobcard_no');
    }
    public function techniciantimings()
    {
         return  $this->hasMany(CustomerTechnician::class,'jobcard_no','jobcard_no');
     }
    public function followupcalls()
    {
         return  $this->hasMany(CustomerCall::class,'jobcard_no','jobcard_no');
     }

	public function setRegNoAttribute($value)
    {
        $this->attributes['reg_no'] = preg_replace('/[^A-Za-z0-9]/', '', strtoupper($value));
    }

	public function getRegNoAttribute($value)
    {
        return preg_replace('/[^A-Za-z0-9]/', '', strtoupper($value));
    }

    
    public function campaign() {
        return $this->belongsTo(Campaign::class,'campaign_id','campaign_id');
    }
    public function company() {
        return $this->belongsTo(Company::class,'company_id','id')->where('status',0);;
    }
   
    function service() {
         return $this->belongsTo(Service::class,'service_type','id')->where('status',0);
     }
    
    public function service_user()
    {
        return $this->belongsTo(User::class,'service_user_id');
    }
}
