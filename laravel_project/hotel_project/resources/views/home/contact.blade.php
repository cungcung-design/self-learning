<div class="contact" id="contact">
    <div class="container">
        <div class="section-heading">
            <h2>Contact us</h2>
            <p>Questions about dates, rooms, or arriving late? Send a message and we will reply by email.</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('home.partials.contact-form')
            </div>
            <div class="col-md-6">
                <div class="map_main">
                    <div class="map-responsive">
                        <iframe src="{{ config('hotel.map_embed') }}" width="600" height="400"
                            style="border:0; width: 100%;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
