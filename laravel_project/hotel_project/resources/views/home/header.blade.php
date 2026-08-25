<div class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <a href="{{ route('home.public') }}">
                                <img src="{{ asset('images/logo.png') }}" alt="{{ config('hotel.name') }}" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8">
                <nav class="navigation navbar navbar-expand-lg navbar-dark hotel-navbar">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#publicNav" aria-controls="publicNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="publicNav">
                        <ul class="ml-auto navbar-nav align-items-lg-center">
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
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-hotel-outline btn-sm">Logout</button>
                                    </form>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="btn btn-hotel-outline btn-sm mr-2" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-hotel btn-sm" href="{{ route('register') }}">Register</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
