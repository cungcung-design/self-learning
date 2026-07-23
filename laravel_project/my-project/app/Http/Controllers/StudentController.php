<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
    $students = [
        "Aung",
        "Kyaw",
        "Hlaing",
        "Myat",
    ];
    return view('student',compact('students'));
    }
}
