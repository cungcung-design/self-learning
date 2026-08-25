    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="search-panel">
                <div class="search-inner d-flex align-items-center justify-content-center">
                    <div class="close-btn">Close <i class="fa fa-close"></i></div>
                    <form id="searchForm" action="#">
                        <div class="form-group">
                            <input type="search" name="search" placeholder="What are you searching for...">
                            <button type="submit" class="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div class="navbar-header">
                    <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                        <div class="visible brand-text brand-big text-uppercase">
                            <strong class="text-primary">Hotel</strong><strong>Admin</strong>
                        </div>
                        <div class="brand-text brand-sm">
                            <strong class="text-primary">H</strong><strong>A</strong>
                        </div>
                    </a>
                    <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
                </div>
                <div class="right-menu list-inline no-margin-bottom">
                    <div class="list-inline-item">
                        <a href="{{ route('home.public') }}" class="nav-link" target="_blank">
                            View Website
                        </a>
                    </div>
                    <div class="list-inline-item logout">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link"
                                style="border:none; background:none; color:white;">
                                Logout <i class="icon-logout"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
