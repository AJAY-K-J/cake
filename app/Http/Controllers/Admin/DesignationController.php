<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class DesignationController extends Controller
{
    
    public function get_designations()
    {
        $designations = Designation::where('status','0')->get();
        return $designations;
    }

}
