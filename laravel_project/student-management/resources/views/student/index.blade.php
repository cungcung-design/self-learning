@extends('layout')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Student List</h1>
        
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-4">ID</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr class="border-b">
                    <td class="p-4">{{ $student->id }}</td>
                    <td class="p-4">{{ $student->name }}</td>
                    <td class="p-4">{{ $student->email }}</td>
                    <td class="p-4">
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>