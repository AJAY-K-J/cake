<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Auth;

class PurchaseVendor extends Model
{
    public function __construct() {

           $this->table = 'purchasevendors';
       
        
    }

}