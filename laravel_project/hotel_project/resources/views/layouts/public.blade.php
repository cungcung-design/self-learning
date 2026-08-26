<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('home.css', ['title' => $title ?? null])
    @stack('styles')
</head>
<body class="main-layout{{ request()->routeIs('home.public') ? ' is-home' : '' }}">
    <header>
        @include('home.header')
    </header>

    @include('components.flash-message')

    {{ $slot }}

    @include('home.footer-section')

    <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    @stack('scripts')
</body>
</html>
