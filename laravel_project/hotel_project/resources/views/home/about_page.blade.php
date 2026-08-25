<x-public-layout title="About">
    @include('home.partials.page-hero', [
        'title' => 'About '.config('hotel.name'),
        'subtitle' => config('hotel.tagline'),
    ])

    <section class="page-section bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="mb-3">A straightforward city stay</h2>
                    <p>{{ config('hotel.description') }}</p>
                    <ul class="about-points pl-3">
                        <li>Check-in from {{ config('hotel.check_in') }} and check-out by {{ config('hotel.check_out') }}</li>
                        <li>Booking requests are reviewed by our team, then confirmed by email</li>
                        <li>You can cancel a pending stay from My Bookings before the arrival date</li>
                        <li>Front desk can help with late arrivals if you message us in advance</li>
                    </ul>
                    <a href="{{ route('rooms.index') }}" class="btn btn-hotel mt-3">Browse rooms</a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/about.png') }}" alt="{{ config('hotel.name') }}" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
