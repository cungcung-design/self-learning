<x-public-layout :title="$room->room_name">
    @push('styles')
    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
      }

      body {
        background-color: #eaf1fa;
        padding: 0;
        margin: 0;
        color: #1e293b;
      }

      html {
        scroll-behavior: smooth;
      }

      #room-description,
      #room-features {
        scroll-margin-top: 24px;
      }

      /* Outer App Window */
      .app-card {
        background: #ffffff;
        max-width: 1180px;
        width: 100%;
        margin: 20px auto;
        border-radius: 28px;
        padding: 24px 36px 36px 36px;
        box-shadow: 0 20px 50px rgba(15, 35, 75, 0.08);
        position: relative;
      }

      /* ------------------------------------
         Main Grid Layout
      ------------------------------------ */
      .room-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 36px;
        align-items: start;
      }
/* ------------------------------------
    Outer Shell & Shared Reset
------------------------------------ */
.gallery-grid {
  display: grid;
  grid-template-columns: 2.2fr 1fr;
  grid-template-rows: repeat(3, 105px);
  gap: 8px;
  margin-bottom: 24px;
}

/* Ensure images fill containers without inheriting global radius */
.gallery-grid img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border-radius: 0 !important;
}

/* 1. Main Left Image (Top-Left & Bottom-Left rounded only) */
.gallery-main {
  grid-column: 1 / 2;
  grid-row: 1 / 4;
  border-radius: 22px 0 0 22px;
  overflow: hidden;
}

/* 2. Top-Right Image (Top-Right corner rounded ONLY) */
.gallery-thumb-top-corner {
  border-radius: 0 22px 0 0;
  overflow: hidden;
  height: 100%;
}
/* 3. Middle-Right Image (Completely sharp / rectangular) */
.gallery-thumb-mid {
  border-radius: 0;
  overflow: hidden;
  height: 100%;
}

/* 4. Bottom-Right Image (Bottom-Right corner rounded ONLY) */
.gallery-overlay-wrap {
  position: relative;
  border-radius: 0 0 22px 0;
  overflow: hidden;
  height: 100%;
  cursor: pointer;
}

.gallery-overlay-wrap img {
  filter: blur(14px) brightness(1.08);
  transform: scale(1.15);
}

.gallery-overlay-text {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  font-weight: 700;
  color: #475569;
  background: rgba(255, 255, 255, 0.45);
}

.gallery-lightbox {
  position: fixed;
  inset: 0;
  z-index: 2000;
  display: none;
  align-items: center;
  justify-content: center;
  background: rgba(15, 23, 42, 0.72);
  padding: 24px;
}

.gallery-lightbox.is-open {
  display: flex;
}

.gallery-lightbox__dialog {
  position: relative;
  width: min(920px, 100%);
  background: #ffffff;
  border-radius: 20px;
  padding: 20px 20px 16px;
  box-shadow: 0 24px 60px rgba(15, 23, 42, 0.28);
}

.gallery-lightbox__image {
  width: 100%;
  height: min(62vh, 520px);
  object-fit: cover;
  border-radius: 14px;
  display: block;
}

.gallery-lightbox__caption {
  margin-top: 12px;
  font-size: 13px;
  font-weight: 700;
  color: #0f172a;
}

.gallery-lightbox__close,
.gallery-lightbox__nav {
  position: absolute;
  border: none;
  background: #0f172a;
  color: #ffffff;
  width: 36px;
  height: 36px;
  border-radius: 999px;
  cursor: pointer;
  font-size: 18px;
  line-height: 1;
}

.gallery-lightbox__close {
  top: 12px;
  right: 12px;
}

.gallery-lightbox__nav {
  top: 50%;
  transform: translateY(-50%);
}

.gallery-lightbox__prev { left: 12px; }
.gallery-lightbox__next { right: 12px; }

.date-box input,
.guest-box input {
  width: 100%;
  border: none;
  background: transparent;
  font: inherit;
  font-weight: 600;
  color: inherit;
  outline: none;
}

.btn-book-now {
  display: block;
  text-align: center;
  text-decoration: none;
}

.btn-book-now:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.booking-unavailable {
  font-size: 12px;
  font-weight: 600;
  color: #dc2626;
  text-align: center;
  margin-bottom: 10px;
}


/* Room Header & Badges */
      .badges-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
      }

      .score-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #e8fbf2;
        color: #10b981;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
      }

      .tag-badge {
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10.5px;
        font-weight: 600;
      }

      .tag-blue { background: #eef4ff; color: #3b82f6; }
      .tag-purple { background: #fdf2f8; color: #ec4899; }
      .tag-orange { background: #fff7ed; color: #f97316; }

      .stars {
        display: inline-flex;
        gap: 2px;
        margin-left: 4px;
      }

      .stars svg {
        width: 12px;
        height: 12px;
        fill: #fbbf24;
        stroke: #fbbf24;
      }

      .title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 6px;
      }

      .room-title {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.4px;
      }

      .room-address {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 20px;
      }

      /* Tabs Navigation */
      .tabs-nav {
        display: flex;
        align-items: center;
        gap: 24px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 16px;
      }

      .tab-link {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        padding-bottom: 8px;
        position: relative;
      }

      .tab-link.active {
        color: #1d72fe;
        font-weight: 700;
      }

      .tab-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #1d72fe;
        border-radius: 2px;
      }

      .room-description {
        font-size: 12px;
        line-height: 1.6;
        color: #64748b;
        margin-bottom: 24px;
      }

      /* Hotel Features List */
      .features-heading {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
      }

      .features-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 28px;
      }

      .feature-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
      }

      .feature-item svg,
      .feature-item i {
        width: 16px;
        height: 16px;
        font-size: 14px;
        stroke: #334155;
        color: #334155;
      }

      .stay-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
      }

      .stay-meta-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
      }

      /* ------------------------------------
         Right Column: Booking Card
      ------------------------------------ */
      .booking-card {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
      }

      .price-header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      .price-main {
        display: flex;
        align-items: baseline;
        gap: 4px;
      }

      .price-current {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
      }

      .price-unit {
        font-size: 12px;
        font-weight: 500;
        color: #64748b;
      }

      /* Date Picker Row */
      .dates-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 14px;
      }

      .field-group label {
        display: block;
        font-size: 10.5px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
      }

      .date-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      /* Guest Selector */
      .guest-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        cursor: pointer;
      }

      /* Price Breakdown Box */
      .pricing-summary {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 14px;
      }

      .pricing-summary-title {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 2px;
      }

      .summary-line {
        display: flex;
        justify-content: space-between;
        font-size: 11.5px;
        font-weight: 500;
        color: #475569;
      }

      .summary-line.highlight {
        color: #10b981;
      }

      .summary-line span:last-child {
        font-weight: 700;
        color: #1e293b;
      }

      .summary-line.highlight span:last-child {
        color: #10b981;
      }

      /* Total Payment Line */
      .total-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 16px;
        padding: 0 4px;
      }

      .total-price {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
      }

      /* Book Now CTA */
      .btn-book-now {
        width: 100%;
        background: #1d72fe;
        color: #ffffff;
        border: none;
        outline: none;
        padding: 12px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.1s;
        margin-bottom: 10px;
      }

      .btn-book-now:hover {
        background: #155bd8;
      }

      .disclaimer {
        text-align: center;
        font-size: 11px;
        font-weight: 500;
        color: #94a3b8;
      }

      /* Responsive */
      @media (max-width: 992px) {
        .room-layout {
          grid-template-columns: 1fr;
        }
      }

      @media (max-width: 576px) {
        .app-card {
          margin: 12px auto;
          padding: 20px 18px 24px 18px;
          border-radius: 20px;
        }
        .gallery-grid {
          grid-template-rows: 120px 120px;
          gap: 10px;
        }
        .room-title {
          font-size: 18px;
        }
        .features-row {
          flex-wrap: wrap;
          gap: 16px;
        }
      }
    </style>
    @endpush

    <div class="app-card">

      <!-- Main Content Layout -->
      <div class="room-layout">

        <!-- Left Column: Gallery & Property Overview -->
        <div class="room-details-left">
<!-- Image Gallery Showcase -->
@php
    $galleryImages = $room->roomImages->values();
    $gridImages = $galleryImages->take(4)->values();
    $shownIds = $gridImages->pluck('id');
    $extraImages = $galleryImages
        ->reject(fn ($image) => $shownIds->contains($image->id))
        ->values();
    $gridClasses = ['gallery-main', 'gallery-thumb-top-corner', 'gallery-thumb-mid', 'gallery-overlay-wrap'];
@endphp
<div class="gallery-grid">
  @forelse ($gridImages as $index => $image)
    <div class="{{ $gridClasses[$index] ?? 'gallery-item' }}"
      @if ($index === 3 && $extraImages->isNotEmpty())
        data-open-gallery-more role="button" tabindex="0" aria-label="Open remaining room photos"
      @endif
    >
      <img src="{{ $image->imageUrl() }}" alt="{{ $room->room_name }} — {{ $image->featureLabel() }}">
      @if ($index === 3 && $extraImages->isNotEmpty())
        <div class="gallery-overlay-text">+{{ $extraImages->count() }} Photos</div>
      @endif
    </div>
  @empty
    <div class="gallery-main">
      <img src="{{ $room->imageUrl() }}" alt="{{ $room->room_name }}">
    </div>
  @endforelse
</div>
@if ($extraImages->isNotEmpty())
  <div class="gallery-lightbox" id="gallery-more-lightbox" hidden>
    <div class="gallery-lightbox__dialog" role="dialog" aria-modal="true" aria-label="More room photos">
      <button type="button" class="gallery-lightbox__close" data-gallery-more-close aria-label="Close photos">&times;</button>
      <button type="button" class="gallery-lightbox__nav gallery-lightbox__prev" data-gallery-more-prev aria-label="Previous photo">&#8249;</button>
      <img class="gallery-lightbox__image" id="gallery-more-image" src="{{ $extraImages->first()->imageUrl() }}" alt="{{ $room->room_name }} — {{ $extraImages->first()->featureLabel() }}">
      <button type="button" class="gallery-lightbox__nav gallery-lightbox__next" data-gallery-more-next aria-label="Next photo">&#8250;</button>
      <p class="gallery-lightbox__caption" id="gallery-more-caption">{{ $room->room_name }} — {{ $extraImages->first()->featureLabel() }}</p>
    </div>
  </div>
@endif

          @php
            $hasWifiAmenity = $room->roomAmenities->contains(
                fn ($amenity) => str_contains(strtolower($amenity->name), 'wi-fi')
                    || str_contains(strtolower($amenity->name), 'wifi')
            );
            $hasFeatures = $room->max_guests
                || $room->beds
                || $room->bed_type
                || $room->room_size
                || $room->hasWifi()
                || $room->roomAmenities->isNotEmpty();
          @endphp

          <div class="badges-row">
            @if ($room->hotel?->rating)
              <span class="score-badge">{{ number_format((float) $room->hotel->rating, 1) }}</span>
            @endif
            @if ($room->hotel?->name)
              <span class="tag-badge tag-blue">{{ $room->hotel->name }}</span>
            @endif
            @if ($room->room_type)
              <span class="tag-badge tag-purple">{{ $room->typeLabel() }}</span>
            @endif
            @if ($room->is_available)
              <span class="tag-badge tag-orange">Available</span>
            @endif
            @if ($room->hotel?->rating)
              <div class="stars">
                @for ($i = 0; $i < (int) min(5, max(0, round((float) $room->hotel->rating))); $i++)
                  <i data-lucide="star"></i>
                @endfor
              </div>
            @endif
          </div>

          <div class="title-row">
            <h1 class="room-title">{{ $room->room_name }}</h1>
          </div>

          @if ($room->hotel?->location)
            <p class="room-address">{{ $room->hotel->location }}</p>
          @endif

          @if ($room->room_description || $hasFeatures)
            <div class="tabs-nav">
              @if ($room->room_description)
                <a href="#room-description" class="tab-link active">Description</a>
              @endif
              @if ($hasFeatures)
                <a href="#room-features" class="tab-link {{ $room->room_description ? '' : 'active' }}">Features</a>
              @endif
            </div>
          @endif

          @if ($room->room_description)
            <p class="room-description" id="room-description">{{ $room->room_description }}</p>
          @endif

          @if ($hasFeatures)
          <h3 class="features-heading" id="room-features">Room features</h3>
          <div class="features-row">
            @if ($room->max_guests)
              <div class="feature-item">
                <i data-lucide="users"></i>
                <span>{{ $room->max_guests }} {{ \Illuminate\Support\Str::plural('guest', (int) $room->max_guests) }}</span>
              </div>
            @endif
            @if ($room->beds)
              <div class="feature-item">
                <i data-lucide="bed"></i>
                <span>{{ $room->beds }} {{ \Illuminate\Support\Str::plural('bed', (int) $room->beds) }}</span>
              </div>
            @endif
            @if ($room->bed_type)
              <div class="feature-item">
                <i data-lucide="bed-double"></i>
                <span>{{ $room->bed_type }}</span>
              </div>
            @endif
            @if ($room->room_size)
              <div class="feature-item">
                <i data-lucide="maximize-2"></i>
                <span>{{ $room->room_size }}</span>
              </div>
            @endif
            @if ($room->hasWifi() && ! $hasWifiAmenity)
              <div class="feature-item">
                <i data-lucide="wifi"></i>
                <span>Wi-Fi</span>
              </div>
            @endif
            @foreach ($room->roomAmenities as $amenity)
              <div class="feature-item">
                <i class="{{ $amenity->icon ?: 'fa fa-check' }}"></i>
                <span>{{ $amenity->name }}</span>
              </div>
            @endforeach
          </div>
          @endif

        </div>

        <!-- Right Column: Booking Card -->
        <aside class="booking-card">
          @php
            $nightlyRate = (float) $room->room_price;
            $stayNights = max(1, (int) ($nights ?? 1));
            $stayTotal = $nightlyRate * $stayNights;
          @endphp
          <form action="{{ route('bookings.store', $room) }}" method="POST">
            @csrf
            <div class="price-header">
              <div class="price-main">
                <span class="price-current">${{ number_format($nightlyRate, 0) }}</span>
                <span class="price-unit">/night</span>
              </div>
            </div>

            <div class="dates-grid">
              <div class="field-group">
                <label for="start_date">Check-In</label>
                <div class="date-box">
                  <input id="start_date" type="date" name="start_date" min="{{ date('Y-m-d') }}"
                    value="{{ old('start_date', $filters['start_date'] ?? '') }}" @required(auth()->check())>
                </div>
              </div>
              <div class="field-group">
                <label for="end_date">Check-Out</label>
                <div class="date-box">
                  <input id="end_date" type="date" name="end_date" min="{{ date('Y-m-d') }}"
                    value="{{ old('end_date', $filters['end_date'] ?? '') }}" @required(auth()->check())>
                </div>
              </div>
            </div>

            @if ($room->max_guests)
              <div class="field-group">
                <label>Guests</label>
                <div class="guest-box">
                  <span>Up to {{ $room->max_guests }} {{ \Illuminate\Support\Str::plural('guest', (int) $room->max_guests) }}</span>
                </div>
              </div>
            @endif

            @if ($room->hotel?->check_in_time || $room->hotel?->check_out_time)
              <div class="stay-meta">
                @if ($room->hotel?->check_in_time)
                  <div class="stay-meta-row">
                    <span>Check-in</span>
                    <span>{{ $room->hotel->check_in_time }}</span>
                  </div>
                @endif
                @if ($room->hotel?->check_out_time)
                  <div class="stay-meta-row">
                    <span>Check-out</span>
                    <span>{{ $room->hotel->check_out_time }}</span>
                  </div>
                @endif
              </div>
            @endif

            <div class="pricing-summary">
              <span class="pricing-summary-title">Price</span>
              <div class="summary-line">
                <span>{{ $stayNights }} {{ \Illuminate\Support\Str::plural('Night', $stayNights) }}</span>
                <span>${{ number_format($stayTotal, 0) }}</span>
              </div>
            </div>

            <div class="total-line">
              <span>Total Payment</span>
              <span class="total-price">${{ number_format($stayTotal, 0) }}</span>
            </div>

            @auth
              <input type="hidden" name="name" value="{{ auth()->user()->name }}">
              <input type="hidden" name="email" value="{{ auth()->user()->email }}">
              <input type="hidden" name="phone" value="{{ auth()->user()->phone ?? '0000000000' }}">
              @if ($unavailable)
                <p class="booking-unavailable">This room is already booked for these dates.</p>
              @endif
              <button type="submit" class="btn-book-now" @disabled($unavailable)>Request booking</button>
            @else
              <a href="{{ route('login') }}" class="btn-book-now">Log in to book</a>
            @endauth
            <p class="disclaimer">You will not get charged yet</p>
          </form>
        </aside>

      </div>

    </div>

    @push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      if (window.lucide) {
        lucide.createIcons();
      }

      document.querySelectorAll('.tabs-nav .tab-link').forEach((link) => {
        link.addEventListener('click', (event) => {
          const target = link.getAttribute('href');
          if (! target || target.charAt(0) !== '#') {
            return;
          }
          event.preventDefault();
          document.querySelectorAll('.tabs-nav .tab-link').forEach((item) => item.classList.remove('active'));
          link.classList.add('active');
          const section = document.querySelector(target);
          if (section) {
            const top = section.getBoundingClientRect().top + window.scrollY - 24;
            window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
          }
        });
      });

      document.addEventListener('DOMContentLoaded', function () {
        const extraImages = @json($extraImages->map(fn ($image) => [
            'src' => $image->imageUrl(),
            'alt' => $room->room_name.' — '.$image->featureLabel(),
        ])->values());
        const lightbox = document.getElementById('gallery-more-lightbox');
        const lightboxImage = document.getElementById('gallery-more-image');
        const lightboxCaption = document.getElementById('gallery-more-caption');
        if (! lightbox || ! lightboxImage || extraImages.length === 0) {
          return;
        }

        let currentIndex = 0;

        function showImage(index) {
          currentIndex = (index + extraImages.length) % extraImages.length;
          const photo = extraImages[currentIndex];
          lightboxImage.src = photo.src;
          lightboxImage.alt = photo.alt;
          if (lightboxCaption) {
            lightboxCaption.textContent = photo.alt;
          }
        }

        function openGallery(index) {
          showImage(index || 0);
          lightbox.hidden = false;
          lightbox.classList.add('is-open');
          document.body.style.overflow = 'hidden';
        }

        function closeGallery() {
          lightbox.hidden = true;
          lightbox.classList.remove('is-open');
          document.body.style.overflow = '';
        }

        document.querySelectorAll('[data-open-gallery-more]').forEach((trigger) => {
          trigger.addEventListener('click', () => {
            openGallery(0);
          });
          trigger.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
              event.preventDefault();
              openGallery(0);
            }
          });
        });

        lightbox.addEventListener('click', (event) => {
          if (event.target === lightbox) {
            closeGallery();
          }
        });

        lightbox.querySelector('[data-gallery-more-close]')?.addEventListener('click', closeGallery);
        lightbox.querySelector('[data-gallery-more-prev]')?.addEventListener('click', () => showImage(currentIndex - 1));
        lightbox.querySelector('[data-gallery-more-next]')?.addEventListener('click', () => showImage(currentIndex + 1));

        document.addEventListener('keydown', (event) => {
          if (! lightbox.classList.contains('is-open')) {
            return;
          }
          if (event.key === 'Escape') {
            closeGallery();
          }
          if (event.key === 'ArrowLeft') {
            showImage(currentIndex - 1);
          }
          if (event.key === 'ArrowRight') {
            showImage(currentIndex + 1);
          }
        });
      });
    </script>
    @endpush
</x-public-layout>