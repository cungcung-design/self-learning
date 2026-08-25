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

        <form class="hero-search" action="{{ route('rooms.index') }}" method="get">
            <div class="hero-search__amenities">
                <h2>Amenities</h2>
                <ul>
                    <li>
                        <span class="hero-icon hero-icon--pool">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3 16.5c1.1.6 2.4.6 3.5 0 .5-.27 1-.4 1.5-.4s1 .13 1.5.4c1.1.6 2.4.6 3.5 0 .5-.27 1-.4 1.5-.4s1 .13 1.5.4c1.1.6 2.4.6 3.5 0V19c-1.1.6-2.4.6-3.5 0-.5-.27-1-.4-1.5-.4s-1 .13-1.5.4c-1.1.6-2.4.6-3.5 0-.5-.27-1-.4-1.5-.4s-1 .13-1.5.4c-1.1.6-2.4.6-3.5 0v-2.5zm0-3c1.1.6 2.4.6 3.5 0 .5-.27 1-.4 1.5-.4s1 .13 1.5.4c1.1.6 2.4.6 3.5 0 .5-.27 1-.4 1.5-.4s1 .13 1.5.4c1.1.6 2.4.6 3.5 0V16c-1.1.6-2.4.6-3.5 0-.5-.27-1-.4-1.5-.4s-1 .13-1.5.4c-1.1.6-2.4.6-3.5 0-.5-.27-1-.4-1.5-.4s-1 .13-1.5.4c-1.1.6-2.4.6-3.5 0v-2.5zM7.2 11.2c.7-2.3 2.3-4.1 4.3-5.2.4 1.4 1.6 2.5 3.1 2.7-.6 1.1-1.5 2-2.6 2.5H7.2z"/></svg>
                        </span>
                        Pool
                    </li>
                    <li>
                        <span class="hero-icon hero-icon--wifi">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 18.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-4.2-3.1 1.5 1.5A5 5 0 0 1 12 16a5 5 0 0 1 2.7.9l1.5-1.5A7.1 7.1 0 0 0 12 14a7.1 7.1 0 0 0-4.2 1.4zm-3-3 1.4 1.5A9.4 9.4 0 0 1 12 12a9.4 9.4 0 0 1 5.8 2l1.4-1.5A11.4 11.4 0 0 0 12 10a11.4 11.4 0 0 0-7.2 2.4z"/></svg>
                        </span>
                        Free Wi-Fi
                    </li>
                    <li>
                        <span class="hero-icon hero-icon--ac">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2v3.2l2.2-1.3 1 1.8-2.2 1.2A5 5 0 0 1 17 11h3v2h-3a5 5 0 0 1-3.9 4.1l2.1 1.2-1 1.8-2.2-1.3V22h-2v-3.2l-2.2 1.3-1-1.8 2.2-1.2A5 5 0 0 1 7 13H4v-2h3a5 5 0 0 1 3.9-4.1L8.8 5.7l1-1.8L12 5.2V2zm0 7a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg>
                        </span>
                        AC
                    </li>
                    <li>
                        <span class="hero-icon hero-icon--breakfast">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M4 18h16v2H4v-2zm8-15c3.9 0 7 2.5 7 6.2V14H5V9.2C5 5.5 8.1 3 12 3zm0 2C9.4 5 7 6.6 7 9.2V12h10V9.2C17 6.6 14.6 5 12 5z"/></svg>
                        </span>
                        Breakfast
                    </li>
                </ul>
            </div>

            <div class="hero-search__stay">
                <h2>Find Your Stay</h2>
                <p>Check-in - Check-out</p>
                <div class="hero-field hero-field--range">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M7 2h2v2h6V2h2v2h3v16H4V4h3V2zm11 8H6v8h12v-8z"/></svg>
                    <input type="date" name="start_date" min="{{ date('Y-m-d') }}"
                        value="{{ $filters['start_date'] ?? '' }}" aria-label="Check-in date">
                    <span class="hero-field__dash">&ndash;</span>
                    <input type="date" name="end_date" min="{{ date('Y-m-d') }}"
                        value="{{ $filters['end_date'] ?? '' }}" aria-label="Check-out date">
                </div>
                <label class="hero-field">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm0 2c-3.3 0-8 1.7-8 5v1h16v-1c0-3.3-4.7-5-8-5z"/></svg>
                    <select name="room_type" aria-label="Room type">
                        <option value="">Any room type</option>
                        @foreach (\App\Models\Room::TYPES as $type)
                            <option value="{{ $type }}" @selected(($filters['room_type'] ?? '') === $type)>
                                {{ ucfirst($type) }} room
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="hero-search__destinations">
                <h2>Top Destinations</h2>
                <div class="hero-search__thumbs">
                    <img src="{{ asset('images/gallery1.jpg') }}" alt="">
                    <img src="{{ asset('images/gallery2.jpg') }}" alt="">
                    <img src="{{ asset('images/gallery3.jpg') }}" alt="">
                    <img src="{{ asset('images/gallery4.jpg') }}" alt="">
                </div>
            </div>

            <button class="hero-search__submit" type="submit" aria-label="Search rooms">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M15.5 14h-.8l-.3-.3A6.5 6.5 0 1 0 14 15.5l.3.3v.8l5 5 1.5-1.5-5-5zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14z"/></svg>
            </button>
        </form>
    </div>
</section>
