<x-public-layout title="Rooms">
    @include('home.partials.page-hero', [
        'title' => 'Our rooms',
        'subtitle' => 'Compare room types, nightly rates, and availability before you send a booking request.',
    ])

    <section class="page-section">
        <div class="container">
            <div class="filter-card hotel-form mb-5">
                <form action="{{ route('rooms.index') }}" method="get">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label for="start_date">Check-in</label>
                            <input id="start_date" class="form-control" type="date" name="start_date"
                                min="{{ date('Y-m-d') }}" value="{{ $filters['start_date'] ?? '' }}">
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label for="end_date">Check-out</label>
                            <input id="end_date" class="form-control" type="date" name="end_date"
                                min="{{ date('Y-m-d') }}" value="{{ $filters['end_date'] ?? '' }}">
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label for="room_type">Room type</label>
                            <select id="room_type" class="form-control" name="room_type">
                                <option value="">Any type</option>
                                @foreach (\App\Models\Room::TYPES as $type)
                                    <option value="{{ $type }}" @selected(($filters['room_type'] ?? '') === $type)>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-hotel btn-block" type="submit">Search rooms</button>
                            @if (! empty($searching))
                                <a href="{{ route('rooms.index') }}" class="d-block mt-2 text-center">Clear filters</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            @if (! empty($searching))
                <p class="text-muted mb-4">
                    Showing rooms
                    @if (! empty($filters['start_date']) && ! empty($filters['end_date']))
                        from {{ \Illuminate\Support\Carbon::parse($filters['start_date'])->toFormattedDateString() }}
                        to {{ \Illuminate\Support\Carbon::parse($filters['end_date'])->toFormattedDateString() }}
                    @endif
                    @if (! empty($filters['room_type']))
                        in the {{ $filters['room_type'] }} category
                    @endif
                    .
                </p>
            @endif

            <div class="row">
                @forelse ($rooms as $room)
                    @include('home.partials.room-card', ['room' => $room, 'filters' => $filters])
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <h3>No rooms available for those dates</h3>
                            <p>Try another date range or room type. Pending and confirmed stays are held until they are cancelled or completed.</p>
                            <a href="{{ route('rooms.index') }}" class="btn btn-hotel">Reset search</a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $rooms->links() }}
            </div>
        </div>
    </section>
</x-public-layout>
