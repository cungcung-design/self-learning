@if (session('message'))
    <div class="alert alert-success mx-3 mt-3">
        {{ session('message') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mx-3 mt-3">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mx-3 mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
