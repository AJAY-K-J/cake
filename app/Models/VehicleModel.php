<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class VehicleModel extends Model
{
    public function vehicle_make()
    {
        return $this->belongsTo(VehicleMake::class,'make_id','id');
    }
}
