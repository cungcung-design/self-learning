         <div class="header">
             <div class="container">
                 <div class="row">
                     <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                         <div class="full">
                             <div class="center-desk">
                                 <div class="logo">
                                     <a href="{{ route('home.public') }}">
                                         <img src="{{ asset('images/logo.png') }}" alt="Hotel logo" />
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                         <nav class="navigation navbar navbar-expand-md navbar-dark ">
                             <button class="navbar-toggler" type="button" data-toggle="collapse"
                                 data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false"
                                 aria-label="Toggle navigation">
                                 <span class="navbar-toggler-icon"></span>
                             </button>
                             <div class="collapse navbar-collapse" id="navbarsExample04">
                                 <ul class="mr-auto navbar-nav">
                                     <li class="nav-item {{ request()->routeIs('home.public') ? 'active' : '' }}">
                                         <a class="nav-link" href="{{ route('home.public') }}">Home</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('/#about') }}">About</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('/#rooms') }}">Our room</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('/#gallery') }}">Gallery</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ url('/#contact') }}">Contact Us</a>
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
                                                  <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                                              </form>
                                          </li>
                                      @else
                                          <li class="nav-item" style="margin-right: 15px;">
                                              <a class="btn btn-success" href="{{ route('login') }}">Login</a>
                                          </li>
                                          <li class="nav-item">
                                              <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                                          </li>
                                      @endauth
                                 </ul>
                             </div>
                         </nav>
                     </div>
                 </div>
             </div>
         </div>
