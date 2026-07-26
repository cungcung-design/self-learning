@extends('layouts.app')

@section('content')
    <h3>Add New Food Item</h3>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('foods.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
        </div>

        <button type="submit" class="btn">Save Food Item</button>
        <a href="{{ route('foods.index') }}">Cancel</a>
    </form>
@endsection