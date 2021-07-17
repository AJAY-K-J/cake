<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Auth;

class CustomerTechnician extends Model
{
    public function __construct() {

        if(Input::has('company_id'))
        {
            $this->table = 'customertechnicians_'.Input::get('company_id');

        }
        else
        {
           $this->table = 'customertechnicians_'.Auth::user()->company_id;
        }
        
    }
    public function technician() {
        return $this->belongsTo(Employee::class, 'technician_id', 'id')->where('status', 0);
    }
   

}