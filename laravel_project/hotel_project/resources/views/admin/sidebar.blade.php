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
                    <i class="icon-windows"></i> Hotel Rooms
                </a>
                <ul id="roomMenu" class="list-unstyled submenu collapse {{ request()->routeIs('admin.rooms.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.rooms.create') }}">Add Room</a></li>
                    <li><a href="{{ route('admin.rooms.index') }}">View Rooms</a></li>
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
