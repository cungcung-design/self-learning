<section class="banner_main">
    <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="first-slide" src="{{ asset('images/banner1.jpg') }}" alt="{{ config('hotel.name') }} lobby">
            </div>
            <div class="carousel-item">
                <img class="second-slide" src="{{ asset('images/banner2.jpg') }}" alt="{{ config('hotel.name') }} room">
            </div>
            <div class="carousel-item">
                <img class="third-slide" src="{{ asset('images/banner3.jpg') }}" alt="{{ config('hotel.name') }} lounge">
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="booking_ocline">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="book_room">
                        <h1>Check room availability</h1>
                        <p class="text-white mb-3">Choose your dates and we will show rooms that are still free.</p>
                        @include('home.partials.availability-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
