<?php


namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Response;
use Illuminate\Http\View;
use App\Http\Controllers\RedirectResponse;
use App\Http\Controllers\Controller;


class StudentController extends Controller
{

  public function index() : View
  {
    $students = Student::all();
    return view('student.index', compact('students' , $students));
  }
  public function create()
  {
    return view('student.create');
  }
  public function store(Request $request)
  {
    $student = new Student();
    $student->first_name = $request->first_name;
    $student->last_name = $request->last_name;
    $student->email = $request->email;
    $student->phone = $request->phone;
    $student->date_of_birth = $request->date_of_birth;
    $student->is_enrolled = $request->is_enrolled;
    $student->save();
    return redirect()->route('student.index');
  }

  public function edit($id)
  {
    $student = Student::find($id);
    return view('student.edit', compact('student'));
  }
}