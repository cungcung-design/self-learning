@php
    $filters = $filters ?? [];
    $action = $action ?? route('rooms.index');
@endphp

<form class="book_now" action="{{ $action }}" method="get">
    <div class="row">
        <div class="col-md-12">
            <span>Arrival</span>
            <img class="date_cua" src="{{ asset('images/date.png') }}" alt="">
            <input class="online_book" type="date" name="start_date" min="{{ date('Y-m-d') }}"
                value="{{ $filters['start_date'] ?? '' }}">
        </div>
        <div class="col-md-12">
            <span>Departure</span>
            <img class="date_cua" src="{{ asset('images/date.png') }}" alt="">
            <input class="online_book" type="date" name="end_date" min="{{ date('Y-m-d') }}"
                value="{{ $filters['end_date'] ?? '' }}">
        </div>
        <div class="col-md-12">
            <span>Room type</span>
            <select class="online_book" name="room_type" style="height: 50px;">
                <option value="">Any type</option>
                @foreach (\App\Models\Room::TYPES as $type)
                    <option value="{{ $type }}" @selected(($filters['room_type'] ?? '') === $type)>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <button class="book_btn" type="submit">Check Availability</button>
        </div>
    </div>
</form>
