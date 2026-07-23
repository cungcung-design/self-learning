<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="admin/img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
                <h1 class="h5">Mark Stephen</h1>
                <p>Web Designer</p>
            </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
            <li class="active"><a href="index.html"> <i class="icon-home"></i>Home </a></li>

            <li class="dropdown">
                <a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse" class="dropdown-toggle">
                    <i class="icon-windows"></i>Hotel Room
                </a>
                <ul id="exampledropdownDropdown" class="list-unstyled submenu">
                    <li><a href="{{ route('create_room') }}">Add Rooms</a></li>
                    <li><a href="{{ route('view_room') }}">View Rooms</a></li>
                    <li><a href="#">Booked Rooms </a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('view_booking') }}"> <i class="icon-home"></i> Bookings </a>
            </li>
            <li>
                <a href="{{ route('view_gallery') }}"> <i class="icon-home"></i> Gallery </a>
            </li>
<li>
    <a href="{{ route('view_message') }}"> 
        <i class="bi bi-envelope"></i> Messages 
    </a>
</li>

        </ul><span class="heading">Extras</span>

    </nav>
