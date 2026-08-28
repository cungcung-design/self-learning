<section class="featured-section">
  <div class="container">
    <!-- Header -->
    <div class="section-header">
      <div class="title-wrapper">
        <h2>Featured Stays</h2>
      </div>
      <a href="{{ route('rooms.index') }}" class="view-all">
        View all
        <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/></svg>
      </a>
    </div>

    <!-- Cards Container -->
    <div class="cards-grid">
      
      <!-- Card 1 -->
      <a href="{{ route('featured.index') }}" class="stay-card">
        <div class="image-container">
          <img src="https://i.pinimg.com/1200x/81/fd/06/81fd06dc0013600ec59ce2ed25d4a402.jpg" alt="Sunset Paradise Resort">
          <span class="badge">Bestseller</span>
          <button class="wishlist-btn" type="button" aria-label="Add to wishlist" onclick="event.stopPropagation();">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
          </button>
        </div>
        <div class="card-body">
          <div class="title-row">
            <h3 class="stay-title">Sunset Paradise Resort</h3>
            <div class="rating">
              <span>4.8</span>
              <svg class="rating-star" viewBox="0 0 24 24" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
          </div>
          <div class="location-row">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 10c0 4.99-5.54 10.19-7.4 11.8a1 1 0 0 1-1.2 0C9.54 20.19 4 14.99 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3" fill="none" stroke="currentColor" stroke-width="2"/></svg>
            <span>Bali, Indonesia</span>
          </div>
          <div class="price-row">
            <span class="price">$320</span>
            <span class="unit">/ night</span>
          </div>
        </div>
      </a>

      <!-- Card 2 -->
      <a href="{{ route('featured.index') }}" class="stay-card">
        <div class="image-container">
          <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80" alt="Lagoon Water Villa">
          <span class="badge">Popular</span>
          <button class="wishlist-btn" type="button" aria-label="Add to wishlist" onclick="event.stopPropagation();">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
          </button>
        </div>
        <div class="card-body">
          <div class="title-row">
            <h3 class="stay-title">Lagoon Water Villa</h3>
            <div class="rating">
              <span>4.9</span>
              <svg class="rating-star" viewBox="0 0 24 24" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
          </div>
          <div class="location-row">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 10c0 4.99-5.54 10.19-7.4 11.8a1 1 0 0 1-1.2 0C9.54 20.19 4 14.99 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3" fill="none" stroke="currentColor" stroke-width="2"/></svg>
            <span>Maldives</span>
          </div>
          <div class="price-row">
            <span class="price">$450</span>
            <span class="unit">/ night</span>
          </div>
        </div>
      </a>

      <!-- Card 3 -->
      <a href="{{ route('featured.index') }}" class="stay-card">
        <div class="image-container">
          <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=800&q=80" alt="Aegean Cliff Suites">
          <span class="badge">Luxury</span>
          <button class="wishlist-btn" type="button" aria-label="Add to wishlist" onclick="event.stopPropagation();">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
          </button>
        </div>
        <div class="card-body">
          <div class="title-row">
            <h3 class="stay-title">Aegean Cliff Suites</h3>
            <div class="rating">
              <span>4.7</span>
              <svg class="rating-star" viewBox="0 0 24 24" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
          </div>
          <div class="location-row">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 10c0 4.99-5.54 10.19-7.4 11.8a1 1 0 0 1-1.2 0C9.54 20.19 4 14.99 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3" fill="none" stroke="currentColor" stroke-width="2"/></svg>
            <span>Santorini, Greece</span>
          </div>
          <div class="price-row">
            <span class="price">$380</span>
            <span class="unit">/ night</span>
          </div>
        </div>
      </a>

    </div>
  </div>
</section>
