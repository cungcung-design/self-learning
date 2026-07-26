<?php

namespace App\Http\Controllers;
use App\Models\Food;
use App\Http\Requests\FoodRequest;

class FoodController extends Controller {
   public function index(){
    $foods = Food::latest()->get();
    return view('foods.index', compact('foods'));
  }
  public function create(){
    return view('foods.create');
  }
  public function store(FoodRequest $request){
    $food = Food::create($request->validated());
    return redirect()->route('foods.index')->with('success', 'Food created successfully');
  }
  public function show(Food $food){
    return view('foods.show', compact('food'));
  }
  public function edit(Food $food){
    return view('foods.edit', compact('food'));
  }
  public function update(FoodRequest $request, Food $food){
    $food->update($request->validated());
    return redirect()->route('foods.index')->with('success', 'Food updated successfully');
  }
  public function destroy(Food $food){
    $food->delete();
    return redirect()->route('foods.index')->with('success', 'Food deleted successfully');
  }
}