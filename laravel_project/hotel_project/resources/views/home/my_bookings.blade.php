<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
    <style>
        .bookings-wrap {
            padding: 80px 0;
            background: #f8f9fa;
            min-height: 70vh;
        }

        .booking-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            padding: 24px;
            margin-bottom: 20px;
        }

        .status-pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-cancelled { background: #e2e3e5; color: #383d41; }
    </style>
</head>

<body class="main-layout">
    <header>
        @include('home.header')
    </header>

    <div class="bookings-wrap">
        <div class="container">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h2 style="font-weight: 700;">My Bookings</h2>
                    <p class="text-muted mb-0">Track, review, and cancel upcoming stays.</p>
                </div>
                <a href="{{ url('/#rooms') }}" class="btn btn-dark">Book another room</a>
            </div>

            @include('components.flash-message')

            @forelse ($bookings as $booking)
                <div class="booking-card">
                    <div class="row align-items-center">
                        <div class="col-md-2 mb-3 mb-md-0">
                            <img src="{{ $booking->room?->imageUrl() ?? asset('images/room1.jpg') }}"
                                alt="{{ $booking->room?->room_name }}" class="img-fluid rounded"
                                style="height: 90px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-1">{{ $booking->room?->room_name ?? 'Room unavailable' }}</h4>
                            <p class="mb-1 text-muted">
                                {{ $booking->start_date?->toFormattedDateString() }}
                                &rarr;
                                {{ $booking->end_date?->toFormattedDateString() }}
                                &middot;
                                {{ $booking->nights() }} night{{ $booking->nights() === 1 ? '' : 's' }}
                            </p>
                            <p class="mb-0">
                                Estimated total:
                                <strong>${{ number_format($booking->totalAmount(), 2) }}</strong>
                            </p>
                        </div>
                        <div class="col-md-4 text-md-right">
                            <span class="status-pill status-{{ $booking->status }}">{{ $booking->status }}</span>
                            @can('cancel', $booking)
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="mt-3"
                                    onsubmit="return confirm('Cancel this booking?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Cancel booking</button>
                                </form>
                            @endcan
                            @if ($booking->room)
                                <a href="{{ route('rooms.show', $booking->room) }}" class="d-block mt-2">View room</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="booking-card text-center">
                    <p class="mb-3">You have not booked a room yet.</p>
                    <a href="{{ url('/#rooms') }}" class="btn btn-dark">Browse rooms</a>
                </div>
            @endforelse

            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>

    @include('home.footer')
</body>

</html>
