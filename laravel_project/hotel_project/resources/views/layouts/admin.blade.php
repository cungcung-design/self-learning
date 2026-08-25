<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.css')
    @yield('styles')
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        @include('components.flash-message')
        @yield('content')
    </div>

    @include('admin.footer')
    @yield('scripts')
</body>
</html>
