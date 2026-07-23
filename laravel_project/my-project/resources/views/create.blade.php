@extends('master')

@section('content')

<h2>Add User</h2>

<form action="/users" method="POST">

    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button class="btn btn-success">Save</button>

</form>

@endsection
