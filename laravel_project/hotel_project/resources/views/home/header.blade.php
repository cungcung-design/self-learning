<div class="header">
    <div class="container">
        <nav class="navbar navbar-expand-xl navbar-light hotel-navbar navigation">
            <a class="navbar-brand logo mb-0" href="{{ route('home.public') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('hotel.name') }}" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#publicNav" aria-controls="publicNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="publicNav">
                <ul class="navbar-nav ml-auto align-items-xl-center">
                    <li class="nav-item {{ request()->routeIs('home.public') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home.public') }}">Home</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('rooms.index') }}">Rooms</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('gallery') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('gallery') }}">Gallery</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('contact.show') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('contact.show') }}">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item {{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a>
                        </li>
                        @if (Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.show') }}">{{ Auth::user()->name }}</a>
                        </li>
                        <li class="nav-item nav-item-action">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-hotel-outline">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item nav-item-action">
                            <a class="btn btn-hotel-outline" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item nav-item-action">
                            <a class="btn btn-hotel" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</div>
