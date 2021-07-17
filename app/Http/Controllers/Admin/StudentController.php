<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.students');
    }

    public function get_students()
    {
        $students = Student::where('status','0')->get();
        return $students;
    }

    public function save(Request $request)
    {

        if($request->id){
            $student = Student::find($request->id);
        }
        else
            $student = new Student;

        $student->name = $request->name;
        $student->college = $request->college;
        $student->status=0;
        $student->save();
        return 'Success';
    }

    public function delete_student(Request $request) {
        $request->validate([
            'id' => 'required',
        ]);

        $student = Student::find($request->id);
        $student->status = -1;
        $student->save();
        return 'Success';
    }
}
