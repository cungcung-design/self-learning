<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(){
        $courses = [
            "PHP",
            "Laravel",
            "Python",
            "Java",
            ];
        return view('course',compact('courses'));
    }
}
