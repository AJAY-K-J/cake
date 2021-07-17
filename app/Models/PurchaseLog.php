<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseVendor;
use App\Models\PurchaseCredit;
use Auth;

class PurchaseLog extends Model
{
    public function __construct() {

           $this->table = 'purchase_log_details';
       
        
    }
    public function vendor() {
       return $this->belongsTo(PurchaseVendor::class,'vendor_id','id')->where('status',0);;
   }
   public function purchasecredit() {
       return $this->belongsTo(PurchaseCredit::class,'purchase_id','id')->where('status',0);;
   }
}