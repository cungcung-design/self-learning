<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
</head>

<body class="main-layout">
    <div class="loader_bg">
        <div class="loader"><img src="{{ asset('images/loading.gif') }}" alt="Loading" /></div>
    </div>

    <header>
        @include('home.header')
    </header>

    @include('components.flash-message')

    @include('home.slider')

    @include('home.about')

    @include('home.room')

    @include('home.gallery')

    @include('home.contact')

    @include('home.footer')

    <script>
        $(document).ready(function() {
            @if (! empty($searching))
                sessionStorage.removeItem('scrollTop');
                if ($('#rooms').length) {
                    $('html, body').animate({
                        scrollTop: $('#rooms').offset().top - 20
                    }, 400);
                }
            @else
                if (sessionStorage.getItem('scrollTop') !== null) {
                    $(window).scrollTop(sessionStorage.getItem('scrollTop'));
                }
            @endif
        });

        $(window).scroll(function() {
            sessionStorage.setItem('scrollTop', $(this).scrollTop());
        });
    </script>
</body>

</html>
