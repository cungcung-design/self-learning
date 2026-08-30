<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('home.css', ['title' => $title ?? null])
    <style>
      .public-page {
        transition: opacity 0.28s ease;
      }
      .public-page.is-changing {
        opacity: 0;
        pointer-events: none;
      }
      @media (prefers-reduced-motion: reduce) {
        .public-page {
          transition: none;
        }
      }
    </style>
    <style id="public-page-styles-start"></style>
    @stack('styles')
    <style id="public-page-styles-end"></style>
</head>
<body class="main-layout{{ request()->routeIs('home.public') ? ' is-home' : '' }}">
    <header>
        @include('home.header')
    </header>

    @include('components.flash-message')

    <div id="public-page" class="public-page" data-public-page>
        {{ $slot }}
    </div>

    @include('home.footer-section')

    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <div id="public-page-scripts">
        @stack('scripts')
    </div>
    <script src="{{ asset('js/public-nav.js') }}"></script>
</body>
</html>
