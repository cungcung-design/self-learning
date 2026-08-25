@if (session('message') || session('error') || $errors->any())
    <div class="container px-3">
        @if (session('message'))
            <div class="alert alert-success site-alert" role="status">{{ session('message') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger site-alert" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger site-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif
