<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('home.css', ['title' => $title ?? null])
    @stack('styles')
</head>
<body class="main-layout{{ request()->routeIs('home.public') ? ' is-home' : '' }}">
    <div class="loader_bg">
        <div class="loader"><img src="{{ asset('images/loading.gif') }}" alt="Loading" /></div>
    </div>

    <header>
        @include('home.header')
    </header>

    @include('components.flash-message')

    {{ $slot }}

    @include('home.footer')
    @stack('scripts')
</body>
</html>
