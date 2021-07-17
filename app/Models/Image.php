<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Image extends Model
{
    public function __construct() {
        if(Input::has('company_id'))
        {
            $this->table = 'images_'.Input::get('company_id');

        }
        else
        {
           $this->table = 'images_'.Auth::user()->company_id;
        }
       
    }


}