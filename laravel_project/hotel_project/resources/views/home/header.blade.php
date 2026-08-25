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
                        <a class="studio-login" href="{{ route('profile.show') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm0 2c-3.3 0-8 1.7-8 5v1h16v-1c0-3.3-4.7-5-8-5z"/></svg>
                            {{ Auth::user()->name }}
                        </a>
                    @else
                        <a class="studio-login" href="{{ route('login') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm0 2c-3.3 0-8 1.7-8 5v1h16v-1c0-3.3-4.7-5-8-5z"/></svg>
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</div>
