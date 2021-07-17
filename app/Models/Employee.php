<?php

namespace App\Models;
use App\Models\Designation;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Employee extends Model
{
    public function designation() {
        return $this->belongsTo(Designation::class, 'employee_type', 'id')->where('status', 0);
    }

}
