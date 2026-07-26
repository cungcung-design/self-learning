@extends('master')

@section('content')

<h2>Edit User</h2>

<form action="/users/{{ $user->id }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
    </div>

    <button class="btn btn-primary">Update</button>

</form>

@endsection