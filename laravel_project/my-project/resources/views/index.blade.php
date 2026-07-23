@extends('master')

@section('content')

<div class="d-flex justify-content-between">
    <h2>User List</h2>

    <a href="/users/create" class="btn btn-primary">+ Add User</a>
</div>

<br>

<table class="table table-bordered">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

    @foreach($users as $user)

    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>

        <td>
            <a href="/users/{{ $user->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

            <form action="/users/{{ $user->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>

    @endforeach

</table>

@endsection