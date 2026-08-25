<div class="our_room" id="rooms">
    <div class="container">
        <div class="section-heading">
            <h2>Our rooms</h2>
            @if (! empty($searching))
                <p>
                    Showing rooms
                    @if (! empty($filters['start_date']) && ! empty($filters['end_date']))
                        available from {{ \Illuminate\Support\Carbon::parse($filters['start_date'])->toFormattedDateString() }}
                        to {{ \Illuminate\Support\Carbon::parse($filters['end_date'])->toFormattedDateString() }}
                    @endif
                    @if (! empty($filters['room_type']))
                        in the {{ $filters['room_type'] }} category
                    @endif
                    .
                    <a href="{{ route('rooms.index') }}">View all rooms</a>
                </p>
            @else
                <p>Quiet, well-kept rooms with straightforward rates and free cancellation on pending requests.</p>
            @endif
        </div>

        <div class="row">
            @forelse ($rooms as $room)
                @include('home.partials.room-card', ['room' => $room, 'filters' => $filters ?? []])
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <h3>No rooms match those dates</h3>
                        <p>Try different dates, another room type, or browse the full list.</p>
                        <a href="{{ route('rooms.index') }}" class="btn btn-hotel">Browse rooms</a>
                    </div>
                </div>
            @endforelse
        </div>

        @if (empty($searching) && $rooms->isNotEmpty())
            <div class="mt-4 text-center">
                <a href="{{ route('rooms.index') }}" class="btn btn-hotel">View all rooms</a>
            </div>
        @endif
    </div>
</div>
