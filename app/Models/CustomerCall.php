<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Auth;

class CustomerCall extends Model
{
    public function __construct() {

        if(Input::has('company_id'))
        {
            $this->table = 'calls_'.Input::get('company_id');

        }
        else
        {
           $this->table = 'calls_'.Auth::user()->company_id;
        }
        
    }
    
   

}