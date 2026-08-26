<section class="featured-section">
  <div class="container">
    <!-- Header -->
    <div class="section-header">
      <div class="title-wrapper">
        <h2>Featured Stays</h2>
      </div>
      <a href="#" class="view-all">
        View all <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
      </a>
    </div>

    <!-- Cards Container -->
    <div class="cards-grid">
      
      <!-- Card 1 -->
      <div class="stay-card">
        <div class="image-container">
          <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80" alt="Sunset Paradise Resort">
          <span class="badge">Bestseller</span>
          <button class="wishlist-btn" aria-label="Add to wishlist">
            <i data-lucide="heart"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="title-row">
            <h3 class="stay-title">Sunset Paradise Resort</h3>
            <div class="rating">
              <span>4.8</span>
              <i data-lucide="star" class="rating-star"></i>
            </div>
          </div>
          <div class="location-row">
            <i data-lucide="map-pin"></i>
            <span>Bali, Indonesia</span>
          </div>
          <div class="price-row">
            <span class="price">$320</span>
            <span class="unit">/ night</span>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="stay-card">
        <div class="image-container">
          <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80" alt="Lagoon Water Villa">
          <span class="badge">Popular</span>
          <button class="wishlist-btn" aria-label="Add to wishlist">
            <i data-lucide="heart"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="title-row">
            <h3 class="stay-title">Lagoon Water Villa</h3>
            <div class="rating">
              <span>4.9</span>
              <i data-lucide="star" class="rating-star"></i>
            </div>
          </div>
          <div class="location-row">
            <i data-lucide="map-pin"></i>
            <span>Maldives</span>
          </div>
          <div class="price-row">
            <span class="price">$450</span>
            <span class="unit">/ night</span>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="stay-card">
        <div class="image-container">
          <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=800&q=80" alt="Aegean Cliff Suites">
          <span class="badge">Luxury</span>
          <button class="wishlist-btn" aria-label="Add to wishlist">
            <i data-lucide="heart"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="title-row">
            <h3 class="stay-title">Aegean Cliff Suites</h3>
            <div class="rating">
              <span>4.7</span>
              <i data-lucide="star" class="rating-star"></i>
            </div>
          </div>
          <div class="location-row">
            <i data-lucide="map-pin"></i>
            <span>Santorini, Greece</span>
          </div>
          <div class="price-row">
            <span class="price">$380</span>
            <span class="unit">/ night</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@push('scripts')
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
  </script>
@endpush
