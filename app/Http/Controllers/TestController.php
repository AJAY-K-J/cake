<?php

namespace App\Http\Controllers;
use App\Models\Service;
class TestController extends Controller
{
    public function index()
    {
    	return Service::withCount('campaigns')->with('customers')->get();
        // return "sd";
    }
    public function homeindex()
    {
        return view('test');
        // return "dsf";
    }
}
