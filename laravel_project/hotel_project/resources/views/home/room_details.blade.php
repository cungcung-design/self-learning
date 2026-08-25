<x-public-layout :title="$room->room_name">
    <section class="page-section">
        <div class="container">
            <nav class="mb-4" aria-label="breadcrumb">
                <a href="{{ route('rooms.index') }}">&larr; All rooms</a>
            </nav>

            <div class="row">
                <div class="col-lg-7">
                    <div class="detail-card">
                        <img src="{{ $room->imageUrl() }}" alt="{{ $room->room_name }}" class="detail-image">
                        <div class="p-4 p-md-5">
                            <div class="mb-3">
                                <span class="chip">{{ $room->typeLabel() }}</span>
                                @if ($room->hasWifi())
                                    <span class="chip chip-success">Free Wi-Fi</span>
                                @endif
                            </div>
                            <h1 class="h2 font-weight-bold mb-2">{{ $room->room_name }}</h1>
                            <div class="mb-4 price-text">
                                ${{ number_format((float) $room->room_price, 2) }}
                                <span style="font-size: 1rem; color: #777; font-weight: 400;">/ night</span>
                            </div>
                            <p class="text-muted mb-0" style="line-height: 1.8;">{{ $room->room_description }}</p>
                            <hr>
                            <ul class="about-points pl-3 mb-0">
                                <li>Check-in from {{ config('hotel.check_in') }}</li>
                                <li>Check-out by {{ config('hotel.check_out') }}</li>
                                <li>Request is pending until the hotel confirms by email</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="booking-card hotel-form">
                        <h4 class="font-weight-bold mb-3">Reserve this room</h4>

                        @if (! empty($unavailable))
                            <div class="alert alert-danger">
                                This room is not available for the selected dates. Please choose different dates.
                            </div>
                        @endif

                        @guest
                            <p class="text-muted">Sign in to send a booking request. We will keep this room page ready after you log in.</p>
                            <a href="{{ route('login') }}" class="btn btn-hotel btn-block mb-2">Log in to book</a>
                            <a href="{{ route('register') }}" class="btn btn-hotel-outline btn-block mb-4">Create an account</a>

                            <form action="{{ route('rooms.show', $room) }}" method="GET">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="guest_start_date">Check-in</label>
                                        <input id="guest_start_date" type="date" name="start_date" class="form-control"
                                            min="{{ date('Y-m-d') }}" value="{{ request('start_date') }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="guest_end_date">Check-out</label>
                                        <input id="guest_end_date" type="date" name="end_date" class="form-control"
                                            min="{{ date('Y-m-d') }}" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-hotel-outline btn-block">Check these dates</button>
                            </form>
                        @else
                            <form action="{{ route('bookings.store', $room) }}" method="POST" id="booking-form">
                                @csrf

                                <div class="mb-3">
                                    <label for="name">Full name</label>
                                    <input id="name" type="text" name="name" autocomplete="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email" autocomplete="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input id="phone" type="tel" name="phone" autocomplete="tel"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', Auth::user()->phone) }}" required>
                                    @error('phone')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="start_date">Check-in</label>
                                        <input id="start_date" type="date" name="start_date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            min="{{ date('Y-m-d') }}"
                                            value="{{ old('start_date', request('start_date')) }}" required>
                                        @error('start_date')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="end_date">Check-out</label>
                                        <input id="end_date" type="date" name="end_date"
                                            class="form-control @error('end_date') is-invalid @enderror"
                                            min="{{ date('Y-m-d') }}"
                                            value="{{ old('end_date', request('end_date')) }}" required>
                                        @error('end_date')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
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

                                <button type="submit" class="btn btn-hotel btn-block py-3"
                                    @disabled(! empty($unavailable))>
                                    Request booking
                                </button>
                                <p class="mt-3 mb-0 text-center text-muted" style="font-size: 0.85rem;">
                                    You will not be charged here. The hotel confirms the stay by email.
                                </p>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    @auth
        @push('scripts')
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
        @endpush
    @endauth
</x-public-layout>
