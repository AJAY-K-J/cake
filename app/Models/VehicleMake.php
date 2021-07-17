<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class VehicleMake extends Model
{
    public function models()
        {
            return $this->hasMany(VehicleModel::class,'make_id','id');
        }
}
