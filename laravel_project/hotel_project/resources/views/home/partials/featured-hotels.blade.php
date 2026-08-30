<div class="hotels-header">
  <span class="hotels-count">HOTELS ({{ $hotels->count() }} {{ \Illuminate\Support\Str::plural('Stay', $hotels->count()) }} Found)</span>
  <div class="hotels-header-actions">
    <button class="sort-btn" type="button">
      <span>Sort By</span>
      <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
    </button>
    @if ($hotels->count() > 4)
      <div class="hotels-carousel-arrows">
        <button type="button" class="carousel-arrow" data-carousel-prev aria-label="Previous hotels" disabled>
          <i data-lucide="chevron-left" style="width: 18px; height: 18px;"></i>
        </button>
        <button type="button" class="carousel-arrow" data-carousel-next aria-label="Next hotels">
          <i data-lucide="chevron-right" style="width: 18px; height: 18px;"></i>
        </button>
      </div>
    @endif
  </div>
</div>

@if ($hotels->isEmpty())
  <p class="page-subtitle" style="margin-bottom: 0;">No hotels are available in this collection yet.</p>
@else
  <div class="hotels-carousel" data-hotel-carousel data-page-size="4" data-hotel-count="{{ $hotels->count() }}">
    <div class="hotels-carousel-shell">
      <button type="button" class="carousel-arrow" data-carousel-prev aria-label="Previous hotels" disabled>
        <i data-lucide="chevron-left" style="width: 18px; height: 18px;"></i>
      </button>
      <div class="hotels-carousel-viewport" data-carousel-viewport tabindex="0" aria-label="Hotel listings">
        <div class="hotels-carousel-track" data-carousel-track>
          @foreach ($hotels->chunk(4) as $pageHotels)
            <div class="hotels-carousel-page" data-carousel-page>
              @foreach ($pageHotels as $hotel)
                @php
                  $detailRoom = $hotel->rooms->first();
                @endphp
                <article class="hotel-card">
                  <div class="hotel-img-wrap">
                    <img src="{{ $hotel->imageUrl() }}" alt="{{ $hotel->name }}">
                  </div>
                  <div class="hotel-details">
                    <div>
                      <div class="hotel-top-row">
                        <h3 class="hotel-name">{{ $hotel->name }}</h3>
                        <div class="hotel-rating">
                          <span class="star">★</span>
                          <span>{{ $hotel->rating ? number_format((float) $hotel->rating, 1) : 'New' }}</span>
                        </div>
                      </div>
                      <div class="hotel-location">
                        <span>📍 {{ $hotel->location ?: 'Location coming soon' }}</span>
                      </div>
                    </div>
                    <div class="hotel-bottom-row">
                      <div class="hotel-price">
                        <span class="price-val">${{ number_format((float) $hotel->price, 0) }}</span>
                        <span class="price-unit">/ night</span>
                      </div>
                      @if ($detailRoom)
                        <a href="{{ route('rooms.show', $detailRoom) }}" class="btn-view-details">
                          <span>View Details</span>
                          <i data-lucide="arrow-right" style="width: 13px; height: 13px;"></i>
                        </a>
                      @else
                        <a href="{{ route('rooms.index') }}" class="btn-view-details">
                          <span>View Rooms</span>
                          <i data-lucide="arrow-right" style="width: 13px; height: 13px;"></i>
                        </a>
                      @endif
                    </div>
                  </div>
                </article>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
      <button type="button" class="carousel-arrow" data-carousel-next aria-label="Next hotels" @disabled($hotels->count() <= 4)>
        <i data-lucide="chevron-right" style="width: 18px; height: 18px;"></i>
      </button>
    </div>
    <p class="hotels-page-meta" data-carousel-meta>Showing 1–{{ min(4, $hotels->count()) }} of {{ $hotels->count() }} stays</p>
  </div>
@endif
