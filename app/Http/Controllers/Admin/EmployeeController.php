<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $designations = Designation::where('status',0)->orderBy('name')->get();
        return view('admin.employees',compact('designations'));
    }

    public function get_employees()
    {
        $employees = Employee::with('designation')->where([['status','0'],['company_id',Auth::user()->company_id]])->get();
        return $employees;
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('employees')
                ->ignore($request->id)
                ->where(function ($query) {
                    return $query->where([['status','0'],['company_id',Auth::user()->company_id]]);
                }),
            ]
        ]);

        if($request->id){
            $employee = Employee::find($request->id);
        }
        else
            $employee = new Employee;

        $employee->name = $request->name;
        $employee->employee_type=$request->employee_type;
        $employee->company_id = Auth::user()->company_id;
        $employee->save();
        return 'Success';
    }

    public function delete_employee(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $employee = Employee::find($request->id);
        $employee->status = -1;
        $employee->save();

        return 'Success';
    }
}
