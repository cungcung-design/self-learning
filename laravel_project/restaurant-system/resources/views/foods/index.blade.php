@php
    /**
     * If this app doesn't have the default Laravel layout, avoid failing tests.
     */
@endphp

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
        .btn { padding: 5px 10px; text-decoration: none; border: 1px solid #333; color: #333; background: #eee; cursor: pointer; display: inline-block; }
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

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h3>Food Menu</h3>
    <a href="{{ route('foods.create') }}" class="btn">Add New Food</a>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($foods as $food)
            <tr>
                <td>{{ $food->name }}</td>
                <td>${{ number_format($food->price, 2) }}</td>
                <td>
                    <a href="{{ route('foods.show', $food->id) }}" class="btn">View</a>
                    <a href="{{ route('foods.edit', $food->id) }}" class="btn">Edit</a>
                    <form action="{{ route('foods.destroy', $food->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach

        @if(is_object($foods) && method_exists($foods, 'isEmpty') && $foods->isEmpty())
            <tr><td colspan="3">No food items found.</td></tr>
        @elseif(is_array($foods) && empty($foods))
            <tr><td colspan="3">No food items found.</td></tr>
        @endif
    </tbody>
</table>

</body>
</html>
