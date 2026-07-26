<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  @extends('layouts.app')

@section('content')
<div>
  <h1>Student</h1>
</div>
<ul>
@foreach($students as $student)
   <li>{{$student}}</li>

@endforeach
</ul>
@endsection
</body>
</html>