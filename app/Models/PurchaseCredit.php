<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Auth;

class PurchaseCredit extends Model
{
    public function __construct() {

        
           $this->table = 'purchasecredits';
    
        
    }
   public function vendor() {
       return $this->belongsTo(PurchaseVendor::class,'vendor_id','id')->where('status',0);
   }
   public function items() {
       return $this->hasMany(PurchaseLog::class,'purchase_id','id')->where('status',0);
   }

}