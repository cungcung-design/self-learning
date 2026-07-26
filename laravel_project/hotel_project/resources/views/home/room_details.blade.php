<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    @include ('home.css')

    <style>
        .room-detail-bg {
            background-color: #f8f9fa;
            padding: 60px 0;
        }

        /* Left Side: Room Info Card */
        .detail-card {
            border-radius: 20px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .detail-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .price-text {
            color: #d8363a;
            font-weight: 700;
            font-size: 2.2rem;
        }

        .badge-custom {
            font-size: 0.85rem;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Right Side: Booking Form Card */
        .booking-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #222;
            /* Sleek dark top border */
            position: sticky;
            top: 20px;
            /* Keeps the form on screen when scrolling */
        }

        .booking-card label {
            font-weight: 600;
            color: #444;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #d8363a;
            box-shadow: 0 0 0 0.2rem rgba(216, 54, 58, 0.25);
        }
    </style>
</head>

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#" /></div>
    </div>

    <!-- header -->
    <header>
        @include ('home.header')
    </header>

    <div class="room-detail-bg">
        <div class="container">
            <!-- Title Section -->
            <div class="mb-5 row">
                <div class="text-center col-md-12">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #222;">Room Details</h2>
                    <p class="text-muted">Take a closer look and reserve your stay.</p>
                </div>
            </div>

            <div class="row">
                <!-- LEFT COLUMN: Room Image & Information (Takes up 7 columns) -->
                <div class="col-lg-7">
                    <div class="detail-card">
                        <img src="{{ asset(ltrim($room->room_image, '/')) }}" alt="{{ $room->room_name }}"
                            class="detail-image">

                        <div class="p-4 p-md-5">
                            <div class="flex-wrap gap-2 mb-3 d-flex">
                                <span class="mr-2 text-white badge bg-dark badge-custom">
                                    {{ $room->room_type }} Room
                                </span>

                                @if (strtolower($room->room_wifi) == 'yes')
                                    <span class="text-white badge bg-success badge-custom">
                                        <i class="fas fa-wifi"></i> Free Wi-Fi
                                    </span>
                                @endif
                            </div>

                            <h3 style="font-size: 2rem; font-weight: 800; color: #111; margin-bottom: 10px;">
                                {{ $room->room_name }}
                            </h3>

                            <div class="mb-4 price-text">
                                ${{ number_format($room->room_price, 2) }}
                                <span style="font-size: 1rem; color: #777; font-weight: 400;">/ night</span>
                            </div>

                            <hr style="border-top: 2px solid #eee;">

                            <h5 style="font-weight: 700; color: #333; margin-top: 20px;">Overview</h5>
                            <p style="color: #666; line-height: 1.8; margin-bottom: 0;">
                                {{ $room->room_description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Booking Form (Takes up 5 columns) -->
                <div class="col-lg-5">

                    <div class="booking-card">
                        <h4 style="font-weight: 700; margin-bottom: 20px; color: #111;">Book This Room</h4>

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Form submits to an 'add_booking' route (you will need to create this) -->
                        <form action="{{ route('add_booking', $room->id) }}" method="POST">
                            @csrf

                            @if (Auth::check())
                                {{-- Debug: show logged-in user id on submit target page load --}}
                                @php($__bb_auth_id = Auth::id())
                                <input type="hidden" name="_bb_auth_id" value="{{ $__bb_auth_id }}">
                            @endif


                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" name="name" autocomplete="name" class="form-control"
                                    placeholder="Enter your full name"
                                    value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" autocomplete="email" class="form-control"
                                    placeholder="Enter your email"
                                    value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone Number</label>
                                <!-- Make sure your users table actually has a 'phone' column. If it is named differently, change it here -->
                                <input type="tel" name="phone" autocomplete="tel" class="form-control"
                                    placeholder="Enter your phone number"
                                    value="{{ old('phone', Auth::check() ? Auth::user()->phone : '') }}" required>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>Check-in Date</label>
                                    <!-- Added min to prevent past dates -->
                                    <input type="date" name="start_date" autocomplete="off" class="form-control"
                                        min="{{ date('Y-m-d') }}" value="{{ old('start_date') }}" required>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label>Check-out Date</label>
                                    <input type="date" name="end_date" autocomplete="off" class="form-control"
                                        min="{{ date('Y-m-d') }}" value="{{ old('end_date') }}" required>
                                </div>
                            </div>

                            <button type="submit" class="py-3 btn btn-dark w-100"
                                style="border-radius: 10px; font-weight: 700; font-size: 1.1rem;">
                                Confirm Booking
                            </button>

                            <p class="mt-3 mb-0 text-center text-muted" style="font-size: 0.85rem;">
                                You won't be charged yet
                            </p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- footer -->
    @include('home.footer')

</body>

</html>
