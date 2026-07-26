<style>
    /* Upgrades for your existing template classes */
    .room {
        background: #ffffff;

        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        /* Soft premium shadow */
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
        /* Makes all cards the same height */
        display: flex;
        flex-direction: column;
    }

    .room:hover {}

    .room_img figure {
        margin: 0;
        height: 250px;
        /* Forces all images to be the exact same size */
        overflow: hidden;
    }

    .room_img figure img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Prevents images from stretching or squishing */
        transition: transform 0.5s ease;
    }

    .room:hover .room_img figure img {
        transform: scale(1.08);
        /* Beautiful slow zoom on the image when hovered */
    }

    .bed_room {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        /* Pushes the text up and the buttons to the bottom */
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
        /* Ensures all buttons align perfectly at the bottom even if text length varies */
    }
</style>

<div class="mt-5 mb-5 our_room">
    <div class="container">

        <!-- Title Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-5 text-center titlepage">
                    <h2 style="font-weight: 700; color: #222;">Our Rooms</h2>
                    <p class="text-muted">Explore our elegant spaces designed for your ultimate comfort.</p>
                </div>
            </div>
        </div>

        <!-- Rooms Grid -->
        <div class="row">
            @foreach ($rooms as $room)
                <!-- Added mb-4 so cards have space between them on mobile phones -->
                <div class="mb-4 col-lg-4 col-md-6 col-sm-12">
                    <div id="serv_hover" class="room">

                        <!-- Image -->
                        <div class="room_img">
                            <figure>
                                <img src="{{ asset($room->room_image) }}" alt="{{ $room->room_name }}" />
                            </figure>
                        </div>

                        <!-- Details -->
                        <div class="bed_room">
                            <h3>{{ $room->room_name }}</h3>
                            <p>{{ Str::limit($room->room_description, 90) }}</p>

                            <!-- Action Buttons aligned perfectly at the bottom -->
                            <div class="mt-auto d-flex align-items-center justify-content-between">
                                <a href="{{ route('room_details', $room->id) }}"
                                    class="text-dark fw-bold text-decoration-none" style="font-size: 0.95rem;">
                                    Read More
                                </a>

                                <a class="btn btn-dark"
                                    style="border-radius: 50px; padding: 8px 25px; font-weight: 600;"
                                    href="{{ route('room_details', $room->id) }}">
                                    Room Detail
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
