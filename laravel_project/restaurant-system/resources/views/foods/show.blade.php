@extends('layouts.app')

@section('content')
    <h3>Food Details</h3>

    <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px;">
        <h2>{{ $food->name }}</h2>
        <p><strong>Price:</strong> ${{ number_format($food->price, 2) }}</p>
        <p><strong>Description:</strong></p>
        <p>{{ $food->description ?: 'No description provided.' }}</p>
    </div>
    
    <br>
    <a href="{{ route('foods.index') }}" class="btn">Back to Menu</a>
    <a href="{{ route('foods.edit', $food->id) }}" class="btn">Edit Item</a>
@endsection