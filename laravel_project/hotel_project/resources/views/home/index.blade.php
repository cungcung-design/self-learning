<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    @include('home.css')
</head>

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#" /></div>
    </div>
    <!-- end loader -->

    <!-- header -->
    <header>
        @include('home.header')
    </header>
    <!-- end header -->

    <!-- banner -->
    @include('home.slider')
    <!-- end banner -->

    <!-- about -->
    @include('home.about')
    <!-- end about -->

    <!-- our_room -->
    @if (isset($rooms) || isset($room))
        @include('home.room')
    @endif
    <!-- end our_room -->

    <!-- gallery -->
    @include('home.gallery')
    <!-- end gallery -->

    <!-- contact -->
    @include('home.contact')
    <!-- end contact -->

    <!-- footer -->
    @include('home.footer')
    <!-- end footer -->

    <script>
        $(window).scroll(function() {
            sessionStorage.setItem('scrollTop', $(this).scrollTop());
        });

        $(document).ready(function() {
            if (sessionStorage.getItem('scrollTop') !== null) {
                $(window).scrollTop(sessionStorage.getItem('scrollTop'));
            }
        });
    </script>
</body>

</html>
