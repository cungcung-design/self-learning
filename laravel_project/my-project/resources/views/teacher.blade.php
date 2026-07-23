@extends('layouts.app')

@section('content')

<h2>Teacher List</h2>

<ul>

@foreach($teachers as $teacher)

    <li>{{ $teacher }}</li>

@endforeach

</ul>

@endsection