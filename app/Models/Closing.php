<?php
namespace App\Models;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Closing extends Model 
{
	public function __construct() {
   
           $this->table = 'closings';
    }
		protected $casts = [
           
           'collection' => 'array',
           'expense' => 'array',
           'opening_balance' => 'array',
    		'total_collection' => 'array',
    		'total_expense' => 'array',
    			'closing_balance' => 'array',
        
        ];

}        