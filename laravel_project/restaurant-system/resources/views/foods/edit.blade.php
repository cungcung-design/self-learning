@extends('layouts.app')

@section('content')
    <h3>Edit: {{ $food->name }}</h3>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('foods.update', $food->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $food->name) }}" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="4">{{ old('description', $food->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $food->price) }}" required>
        </div>

        <button type="submit" class="btn">Update Food Item</button>
        <a href="{{ route('foods.index') }}">Cancel</a>
    </form>
@endsection