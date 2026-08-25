<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')

    <style>
        .room-detail-bg {
            background-color: #f8f9fa;
            padding: 60px 0;
        }

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

        .booking-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #222;
            position: sticky;
            top: 20px;
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
    </style>
</head>

<body class="main-layout">
    <div class="loader_bg">
        <div class="loader"><img src="{{ asset('images/loading.gif') }}" alt="Loading" /></div>
    </div>

    <header>
        @include('home.header')
    </header>

    <div class="room-detail-bg">
        <div class="container">
            <div class="mb-5 row">
                <div class="text-center col-md-12">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #222;">Room Details</h2>
                    <p class="text-muted">Take a closer look and reserve your stay.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7">
                    <div class="detail-card">
                        <img src="{{ $room->imageUrl() }}" alt="{{ $room->room_name }}" class="detail-image">

                        <div class="p-4 p-md-5">
                            <div class="flex-wrap gap-2 mb-3 d-flex">
                                <span class="mr-2 text-white badge bg-dark badge-custom">
                                    {{ ucfirst($room->room_type) }} Room
                                </span>

                                @if ($room->hasWifi())
                                    <span class="text-white badge bg-success badge-custom">
                                        Free Wi-Fi
                                    </span>
                                @endif
                            </div>

                            <h3 style="font-size: 2rem; font-weight: 800; color: #111; margin-bottom: 10px;">
                                {{ $room->room_name }}
                            </h3>

                            <div class="mb-4 price-text">
                                ${{ number_format((float) $room->room_price, 2) }}
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

                <div class="col-lg-5">
                    <div class="booking-card">
                        <h4 style="font-weight: 700; margin-bottom: 20px; color: #111;">Book This Room</h4>

                        @include('components.flash-message')

                        @if (! empty($unavailable))
                            <div class="alert alert-danger">
                                This room is not available for the selected dates. Please choose different dates.
                            </div>
                        @endif

                        @guest
                            <p class="text-muted">Please <a href="{{ route('login') }}">login</a> to complete a booking.</p>
                        @endguest

                        <form action="{{ route('bookings.store', $room) }}" method="POST" id="booking-form">
                            @csrf

                            <div class="mb-3">
                                <label for="name">Full Name</label>
                                <input id="name" type="text" name="name" autocomplete="name" class="form-control"
                                    placeholder="Enter your full name"
                                    value="{{ old('name', Auth::user()->name ?? '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email">Email Address</label>
                                <input id="email" type="email" name="email" autocomplete="email" class="form-control"
                                    placeholder="Enter your email"
                                    value="{{ old('email', Auth::user()->email ?? '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone">Phone Number</label>
                                <input id="phone" type="tel" name="phone" autocomplete="tel" class="form-control"
                                    placeholder="Enter your phone number"
                                    value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="start_date">Check-in Date</label>
                                    <input id="start_date" type="date" name="start_date" class="form-control"
                                        min="{{ date('Y-m-d') }}"
                                        value="{{ old('start_date', request('start_date')) }}" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="end_date">Check-out Date</label>
                                    <input id="end_date" type="date" name="end_date" class="form-control"
                                        min="{{ date('Y-m-d') }}"
                                        value="{{ old('end_date', request('end_date')) }}" required>
                                </div>
                            </div>

                            <div class="mb-4 p-3 rounded" style="background: #f8f9fa;">
                                <div class="d-flex justify-content-between">
                                    <span>Nights</span>
                                    <strong id="stay-nights">0</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Estimated total</span>
                                    <strong id="stay-total">$0.00</strong>
                                </div>
                            </div>

                            <button type="submit" class="py-3 btn btn-dark w-100"
                                style="border-radius: 10px; font-weight: 700; font-size: 1.1rem;"
                                @disabled(! empty($unavailable))>
                                Confirm Booking
                            </button>

                            <p class="mt-3 mb-0 text-center text-muted" style="font-size: 0.85rem;">
                                You won't be charged yet. The hotel will confirm your request.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')
    <script>
        (function() {
            var price = {{ (float) $room->room_price }};
            var startInput = document.getElementById('start_date');
            var endInput = document.getElementById('end_date');
            var nightsEl = document.getElementById('stay-nights');
            var totalEl = document.getElementById('stay-total');

            function updateStay() {
                if (!startInput || !endInput) {
                    return;
                }

                var start = new Date(startInput.value);
                var end = new Date(endInput.value);

                if (!startInput.value || !endInput.value || end <= start) {
                    nightsEl.textContent = '0';
                    totalEl.textContent = '$0.00';
                    return;
                }

                var nights = Math.round((end - start) / (1000 * 60 * 60 * 24));
                nightsEl.textContent = nights;
                totalEl.textContent = '$' + (nights * price).toFixed(2);
            }

            startInput.addEventListener('change', updateStay);
            endInput.addEventListener('change', updateStay);
            updateStay();
        })();
    </script>
</body>

</html>
