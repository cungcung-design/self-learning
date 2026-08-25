<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Contact</h3>
                    <ul class="conta">
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> {{ config('hotel.address') }}</li>
                        <li><i class="fa fa-mobile" aria-hidden="true"></i> {{ config('hotel.phone') }}</li>
                        <li>
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <a href="mailto:{{ config('hotel.email') }}">{{ config('hotel.email') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Explore</h3>
                    <ul class="link_menu">
                        <li class="{{ request()->routeIs('home.public') ? 'active' : '' }}">
                            <a href="{{ route('home.public') }}">Home</a>
                        </li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('rooms.index') }}">Rooms</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('contact.show') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Stay details</h3>
                    <ul class="conta">
                        <li>Check-in from {{ config('hotel.check_in') }}</li>
                        <li>Check-out by {{ config('hotel.check_out') }}</li>
                        <li>Reservations confirmed by email</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <p>&copy; {{ date('Y') }} {{ config('hotel.name') }}. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
