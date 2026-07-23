<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant System</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .btn { padding: 5px 10px; text-decoration: none; border: 1px solid #333; color: #333; background: #eee; cursor: pointer;}
        .alert { padding: 10px; background: #d4edda; color: #155724; margin-bottom: 1rem; border-radius: 4px;}
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: .5rem; }
        .form-group input, .form-group textarea { width: 100%; padding: .5rem; }
    </style>
</head>
<body>

    <nav>
        <h2>Restaurant System</h2>
        <a href="{{ route('foods.index') }}">Menu</a>
    </nav>
    <hr>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <main>
        @yield('content')
    </main>

</body>
</html>