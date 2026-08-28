<div class="d-flex align-items-stretch">
    <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar">
                <img src="{{ asset('admin/img/avatar-6.jpg') }}" alt="Admin avatar" class="img-fluid rounded-circle">
            </div>
            <div class="title">
                <h1 class="h5">{{ Auth::user()->name }}</h1>
                <p>Administrator</p>
            </div>
        </div>
        <span class="heading">Main</span>
        <ul class="list-unstyled">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="icon-home"></i> Dashboard
                </a>
            </li>
            <li class="dropdown {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <a href="#roomMenu" aria-expanded="{{ request()->routeIs('admin.rooms.*') ? 'true' : 'false' }}"
                    data-toggle="collapse" class="dropdown-toggle">
                    <i class="icon-windows"></i> Rooms
                </a>
                <ul id="roomMenu" class="list-unstyled submenu collapse {{ request()->routeIs('admin.rooms.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.rooms.create') }}">Add Room</a></li>
                    <li><a href="{{ route('admin.rooms.index') }}">View Rooms</a></li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('admin.hotels.*') ? 'active' : '' }}">
                <a href="#hotelMenu" aria-expanded="{{ request()->routeIs('admin.hotels.*') ? 'true' : 'false' }}"
                    data-toggle="collapse" class="dropdown-toggle">
                    <i class="fa fa-building"></i> Hotels
                </a>
                <ul id="hotelMenu" class="list-unstyled submenu collapse {{ request()->routeIs('admin.hotels.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.hotels.create') }}">Add Hotel</a></li>
                    <li><a href="{{ route('admin.hotels.index') }}">View Hotels</a></li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('admin.featured_categories.*') ? 'active' : '' }}">
                <a href="#featuredCategoryMenu" aria-expanded="{{ request()->routeIs('admin.featured_categories.*') ? 'true' : 'false' }}"
                    data-toggle="collapse" class="dropdown-toggle">
                    <i class="fa fa-star"></i> Featured Categories
                </a>
                <ul id="featuredCategoryMenu" class="list-unstyled submenu collapse {{ request()->routeIs('admin.featured_categories.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.featured_categories.create') }}">Add Category</a></li>
                    <li><a href="{{ route('admin.featured_categories.index') }}">View Categories</a></li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">
                <a href="#amenityMenu" aria-expanded="{{ request()->routeIs('admin.amenities.*') ? 'true' : 'false' }}"
                    data-toggle="collapse" class="dropdown-toggle">
                    <i class="icon-check"></i> Amenities
                </a>
                <ul id="amenityMenu" class="list-unstyled submenu collapse {{ request()->routeIs('admin.amenities.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.amenities.create') }}">Add Amenity</a></li>
                    <li><a href="{{ route('admin.amenities.index') }}">View Amenities</a></li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <a href="{{ route('admin.bookings.index') }}">
                    <i class="icon-padnote"></i> Bookings
                    @if (($pendingBookingCount ?? 0) > 0)
                        <span class="badge badge-warning float-right">{{ $pendingBookingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <a href="{{ route('admin.gallery.index') }}">
                    <i class="icon-picture"></i> Gallery
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <a href="{{ route('admin.messages.index') }}">
                    <i class="icon-mail"></i> Messages
                    @if (($openMessageCount ?? 0) > 0)
                        <span class="badge badge-info float-right">{{ $openMessageCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </nav>
