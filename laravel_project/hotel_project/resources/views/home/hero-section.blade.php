<section class="hero-studio">
    <div class="hero-studio__shell">
        <div class="hero-studio__card">
            <div class="hero-studio__copy">
                <h1>Discover Your<br>Perfect Getaway</h1>
                <p>Relax, unwind and create unforgettable memories at the world's most beautiful destinations.</p>
                <span class="hero-studio__badge">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/>
                    </svg>
                    Oceanview Villas &amp; Resorts
                </span>
            </div>
            <div class="hero-studio__visual">
                <img src="{{ asset('images/hero-villa.jpg') }}" alt="Luxury oceanview villa at sunset">
            </div>
        </div>

<form class="hero-form" action="{{ route('rooms.index') }}" method="get">
    <!-- 1. Amenities Section -->
    <div class="hero-form__col hero-form__amenities">
        <h2 class="hero-form__title">Amenities</h2>
        <ul>
            <li>
                <span class="hero-icon hero-icon--pool">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 18V9m0 0c-3 0-5.5-2-5.5-5 3.5 0 5.5 2 5.5 5zm0 0c3 0 5.5-2 5.5-5-3.5 0-5.5 2-5.5 5zM4 20c2-1 4-1 6 0s4 1 6 0 3-.5 4 0"/></svg>
                </span>
                <span>Pool</span>
            </li>
            <li>
                <span class="hero-icon hero-icon--wifi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>
                </span>
                <span>Free Wi-Fi</span>
            </li>
            <li>
                <span class="hero-icon hero-icon--ac">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" d="M12 2a3 3 0 0 0-3 3v1a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3zM12 18a3 3 0 0 0-3 3v1a3 3 0 0 0 6 0v-1a3 3 0 0 0-3-3zM2 12a3 3 0 0 0 3 3h1a3 3 0 0 0 0-6H5a3 3 0 0 0-3 3zM18 12a3 3 0 0 0 3 3h1a3 3 0 0 0 0-6h-1a3 3 0 0 0-3 3z"/></svg>
                </span>
                <span>AC</span>
            </li>
            <li>
                <span class="hero-icon hero-icon--breakfast">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 18h16M7 14h10l-1-4H8l-1 4zM10 6c0-1.5 2-2 2-2s2 .5 2 2"/></svg>
                </span>
                <span>Breakfast</span>
            </li>
        </ul>
    </div>

    <!-- 2. Find Your Stay Section -->
    <div class="hero-form__col hero-form__stay">
        <h2 class="hero-form__title">Find Your Stay</h2>
        <span class="hero-form__subtitle">Check-in &ndash; Check-out</span>

        <div class="hero-field hero-field--pill">
            <svg class="hero-field__icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/></svg>
            <div class="hero-field__dates">
                <input type="date" name="start_date" min="{{ date('Y-m-d') }}" value="{{ $filters['start_date'] ?? '' }}" aria-label="Check-in date">
                <span class="hero-field__dash">&ndash;</span>
                <input type="date" name="end_date" min="{{ date('Y-m-d') }}" value="{{ $filters['end_date'] ?? '' }}" aria-label="Check-out date">
            </div>
        </div>

        <label class="hero-field hero-field--plain">
            <svg class="hero-field__icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4" fill="none" stroke="currentColor" stroke-width="2"/></svg>
            <select name="room_type" aria-label="Guests and rooms">
                <option value="">2 Guests, 1 Room</option>
                @foreach (\App\Models\Room::TYPES as $type)
                    <option value="{{ $type }}" @selected(($filters['room_type'] ?? '') === $type)>
                        {{ ucfirst($type) }} room
                    </option>
                @endforeach
            </select>
        </label>
    </div>

    <!-- 3. Top Destinations Section + Search Submit -->
    <div class="hero-form__col hero-form__destinations">
        <div class="hero-destinations__header">
            <h2 class="hero-form__title">Top Destinations</h2>
            <button class="hero-form__submit" type="submit" aria-label="Search rooms">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2.5"/><path stroke="currentColor" stroke-width="2.5" stroke-linecap="round" d="M20 20l-3.5-3.5"/></svg>
            </button>
        </div>
        <div class="hero-form__thumbs">
            <img src="{{ asset('images/gallery1.jpg') }}" alt="Destination 1">
            <img src="{{ asset('images/gallery2.jpg') }}" alt="Destination 2">
            <img src="{{ asset('images/gallery3.jpg') }}" alt="Destination 3">
            <img src="{{ asset('images/gallery4.jpg') }}" alt="Destination 4">
        </div>
    </div>
</form>    
</div>
</section>
