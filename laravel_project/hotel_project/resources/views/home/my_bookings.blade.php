<x-public-layout title="My Bookings">
    <section class="page-section">
        <div class="container">
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="h2 font-weight-bold mb-1">My bookings</h1>
                    <p class="text-muted mb-0">Track upcoming stays and cancel a pending request before check-in.</p>
                </div>
                <a href="{{ route('rooms.index') }}" class="btn btn-hotel mt-3 mt-md-0">Book another room</a>
            </div>

            @forelse ($bookings as $booking)
                <div class="booking-list-card p-4 mb-3">
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
                <div class="empty-state">
                    <h3>No bookings yet</h3>
                    <p>When you request a room, it will appear here until the hotel confirms, rejects, or you cancel it.</p>
                    <a href="{{ route('rooms.index') }}" class="btn btn-hotel">Browse rooms</a>
                </div>
            @endforelse

            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </section>
</x-public-layout>
