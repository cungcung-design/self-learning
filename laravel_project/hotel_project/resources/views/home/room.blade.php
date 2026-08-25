<style>
    .room {
        background: #ffffff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .room_img figure {
        margin: 0;
        height: 250px;
        overflow: hidden;
    }

    .room_img figure img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .room:hover .room_img figure img {
        transform: scale(1.08);
    }

    .bed_room {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .bed_room h3 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 12px;
        color: #111;
    }

    .bed_room p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }
</style>

<div class="mt-5 mb-5 our_room" id="rooms">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-5 text-center titlepage">
                    <h2 style="font-weight: 700; color: #222;">Our Rooms</h2>
                    @if (! empty($searching))
                        <p class="text-muted">
                            Showing rooms
                            @if (! empty($filters['start_date']) && ! empty($filters['end_date']))
                                available from {{ \Illuminate\Support\Carbon::parse($filters['start_date'])->toFormattedDateString() }}
                                to {{ \Illuminate\Support\Carbon::parse($filters['end_date'])->toFormattedDateString() }}
                            @endif
                            @if (! empty($filters['room_type']))
                                in the {{ $filters['room_type'] }} category
                            @endif
                            .
                            <a href="{{ route('home.public') }}#rooms">Clear search</a>
                        </p>
                    @else
                        <p class="text-muted">Explore our elegant spaces designed for your ultimate comfort.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($rooms as $room)
                <div class="mb-4 col-lg-4 col-md-6 col-sm-12">
                    <div id="serv_hover" class="room">
                        <div class="room_img">
                            <figure>
                                <img src="{{ $room->imageUrl() }}" alt="{{ $room->room_name }}" />
                            </figure>
                        </div>
                        <div class="bed_room">
                            <h3>{{ $room->room_name }}</h3>
                            <p class="mb-1"><strong>${{ number_format((float) $room->room_price, 2) }}</strong> / night</p>
                            <p>{{ \Illuminate\Support\Str::limit($room->room_description, 90) }}</p>
                            <div class="mt-auto d-flex align-items-center justify-content-between">
                                <a href="{{ route('rooms.show', array_filter(['room' => $room, 'start_date' => $filters['start_date'] ?? null, 'end_date' => $filters['end_date'] ?? null])) }}"
                                    class="text-dark fw-bold text-decoration-none" style="font-size: 0.95rem;">
                                    Read More
                                </a>
                                <a class="btn btn-dark"
                                    style="border-radius: 50px; padding: 8px 25px; font-weight: 600;"
                                    href="{{ route('rooms.show', array_filter(['room' => $room, 'start_date' => $filters['start_date'] ?? null, 'end_date' => $filters['end_date'] ?? null])) }}">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No rooms match those dates. Try different dates or clear the search.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
