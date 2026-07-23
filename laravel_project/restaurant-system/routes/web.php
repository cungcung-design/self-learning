<?php

use Illuminate\Support\Facades\Route;

// Keep '/' a successful page for automated tests.
// Avoid DB access here because tests run on an in-memory DB without migrations.
Route::get('/', function () {
    return view('foods.index', ['foods' => collect()]);
});


Route::resource('foods', App\Http\Controllers\FoodController::class);
