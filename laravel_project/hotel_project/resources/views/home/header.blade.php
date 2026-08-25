<div class="header studio-header">
    <div class="hero-studio__shell">
        <nav class="navbar navbar-expand-xl navbar-light studio-nav">
            <a class="navbar-brand studio-logo" href="{{ route('home.public') }}">{{ config('hotel.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#publicNav" aria-controls="publicNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="publicNav">
                <ul class="navbar-nav studio-nav__links">
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
                    @endauth
                </ul>
                <div class="studio-nav__cta">
                    @auth
                        <a class="studio-user-menu" href="{{ route('profile.show') }}">
                            <span class="studio-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            <span class="studio-user-name">{{ Auth::user()->name }}</span>
                        </a>
                    @else
                        <a class="studio-btn-login" href="{{ route('login') }}">Log In</a>
                        <a class="studio-btn-register" href="{{ route('register') }}">Sign Up</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</div>
