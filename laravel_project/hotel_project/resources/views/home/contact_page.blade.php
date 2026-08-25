<x-public-layout title="Contact">
    @include('home.partials.page-hero', [
        'title' => 'Contact us',
        'subtitle' => 'Tell us about your dates, room preference, or any arrival details we should know.',
    ])

    <section class="page-section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-5 mb-4 mb-lg-0">
                    <h3 class="mb-3">{{ config('hotel.name') }}</h3>
                    <p class="text-muted">{{ config('hotel.address') }}</p>
                    <p class="mb-1"><strong>Phone:</strong> {{ config('hotel.phone') }}</p>
                    <p class="mb-1"><strong>Email:</strong> <a href="mailto:{{ config('hotel.email') }}">{{ config('hotel.email') }}</a></p>
                    <p class="mb-4"><strong>Hours:</strong> Check-in {{ config('hotel.check_in') }} · Check-out {{ config('hotel.check_out') }}</p>
                    <div class="map-responsive">
                        <iframe src="{{ config('hotel.map_embed') }}" width="600" height="280"
                            style="border:0; width: 100%;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="booking-list-card p-3 p-sm-4">
                        <h4 class="mb-3">Send a message</h4>
                        @include('home.partials.contact-form')
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
