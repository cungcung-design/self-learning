<div class="about" id="about">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="titlepage">
                    <h2>About {{ config('hotel.name') }}</h2>
                    <p>{{ config('hotel.description') }}</p>
                    <a class="read_more" href="{{ route('about') }}">Learn more</a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="about_img">
                    <figure><img src="{{ asset('images/about.png') }}" alt="Inside {{ config('hotel.name') }}" /></figure>
                </div>
            </div>
        </div>
    </div>
</div>
