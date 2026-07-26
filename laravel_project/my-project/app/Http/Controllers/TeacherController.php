<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = [
        "Mr Smith",
        "Ms Brown",
        "Mr Jones",
        
        ];
        return view('teacher', compact('teachers'));
    }
}
