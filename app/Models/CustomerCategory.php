<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Auth;

class CustomerCategory extends Model
{
    public function __construct() {

        if(Input::has('company_id'))
        {
            $this->table = 'customercategories_'.Input::get('company_id');

        }
        else
        {
           $this->table = 'customercategories_'.Auth::user()->company_id;
        }
        
    }
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function catremark() {
        return $this->belongsTo(CatRemark::class, 'catremark_id', 'id');
    }
   

}