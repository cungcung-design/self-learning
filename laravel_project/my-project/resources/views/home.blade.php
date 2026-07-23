<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

    @foreach($students as $student)
       <h3>{{$student}}</h3>
    @endforeach

</body>
</html>