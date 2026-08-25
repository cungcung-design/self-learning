@php
    $query = array_filter([
        'start_date' => $filters['start_date'] ?? null,
        'end_date' => $filters['end_date'] ?? null,
        'room' => $room,
    ]);
@endphp

<div class="mb-4 col-lg-4 col-md-6 col-sm-12">
    <article class="room-card">
        <div class="room-card__image">
            <img src="{{ $room->imageUrl() }}" alt="{{ $room->room_name }}">
        </div>
        <div class="room-card__body">
            <div class="room-card__meta">
                <span class="chip">{{ $room->typeLabel() }}</span>
                @if ($room->hasWifi())
                    <span class="chip chip-success">Wi-Fi</span>
                @endif
            </div>
            <h3>{{ $room->room_name }}</h3>
            <div class="room-card__price">
                ${{ number_format((float) $room->room_price, 2) }}
                <span>/ night</span>
            </div>
            <p>{{ \Illuminate\Support\Str::limit($room->room_description, 110) }}</p>
            <div class="room-card__actions">
                <a href="{{ route('rooms.show', $query) }}" class="room-card__details">Details</a>
                <a class="btn btn-hotel" href="{{ route('rooms.show', $query) }}">Book now</a>
            </div>
        </div>
    </article>
</div>
