<?php
namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Service;
use App\Models\Technician;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Jobcard extends Model
{
    public function __construct() {

            $this->table = 'jobcards';

        
    }
    public function images()
        {
            return $this->hasMany(Image::class,'jobcard_no','jobcard_no');
        }
        public function service()
            {
                return $this->belongsTo(Service::class,'service_id','id');
            }
            public function technician()
                {
                    return $this->belongsTo(Employee::class,'technician_id','id');
                }
        


}