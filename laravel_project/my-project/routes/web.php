<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use  App\Http\Controllers\CourseController;

Route::get("/student",[StudentController::class,'index']);
Route::get("/teacher",[TeacherController::class,'index']);
Route::get("/course",[CourseController::class,'index']);

Route::get('/users', [UserController::class, 'index']);


Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);

Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::put('/users/{id}', [UserController::class, 'update']);

Route::delete('/users/{id}', [UserController::class, 'destroy']);



Route::get('/about', function () {

    return "About Page";
});


Route::get('/contact', function () {
    return "Contact Page";
});

Route::get('/welcome', function () {

    return "
        <h1>Welcome Laravel</h1>
        <p>This is my first Laravel project.</p>
    ";

});

Route::get("/user/{id}", function ($id){
 return "User ID: " . $id;
});

Route::get('/dashboard', function () {

    return "Dashboard";

})->name('dashboard');

