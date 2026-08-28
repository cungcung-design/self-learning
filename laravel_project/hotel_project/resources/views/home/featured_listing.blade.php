<x-public-layout title="Best Seller Hotels - LuxeStay">
    @push('styles')
    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
      }

      body {
        background-color: #f1f5f9;
        padding: 0;
        margin: 0;
        color: #0f172a;
      }

      /* Outer Container */
      .bestsellers-page {
        background: #ffffff;
        max-width: 1140px;
        width: 100%;
        margin: 20px auto;
        border-radius: 24px;
        padding: 28px 36px 40px 36px;
        box-shadow: 0 16px 40px -10px rgba(15, 23, 42, 0.08);
        border: 1px solid #e2e8f0;
      }

      /* ------------------------------------
         Top Bar
      ------------------------------------ */
      .top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      .home-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        text-decoration: none;
        transition: color 0.2s ease;
      }

      .home-link:hover {
        color: #15803d;
      }

      .auth-btn {
        background: #0f172a;
        color: #ffffff;
        border: none;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s ease;
      }

      .auth-btn:hover {
        background: #1e293b;
      }

      /* ------------------------------------
         Header & Collection Tabs
      ------------------------------------ */
      .header-section {
        margin-bottom: 20px;
      }

      .page-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.4px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
      }

      .page-subtitle {
        font-size: 13.5px;
        font-weight: 500;
        color: #64748b;
        margin-bottom: 18px;
      }

      .collection-tabs {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        color: #475569;
        background: #ffffff;
        transition: all 0.2s ease;
      }

      .tab-pill:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
      }

      .tab-pill.active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
      }

      .section-divider {
        height: 1px;
        background-color: #e2e8f0;
        margin: 22px 0 24px 0;
      }

      /* ------------------------------------
         Main Content Layout (Sidebar + List)
      ------------------------------------ */
      .content-layout {
        display: grid;
        grid-template-columns: 290px 1fr;
        gap: 32px;
        align-items: start;
      }

      /* Left Filters Sidebar Card */
      .filters-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.03);
      }

      .filters-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .filters-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
      }

      .clear-btn {
        background: none;
        border: none;
        font-size: 12px;
        font-weight: 700;
        color: #15803d;
        cursor: pointer;
      }

      .clear-btn:hover {
        text-decoration: underline;
      }

      /* Map Box Widget */
      .map-box {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
      }

      .map-preview {
        height: 90px;
        background: linear-gradient(135deg, #dcfce7 0%, #e0f2fe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        font-weight: 700;
        color: #065f46;
        gap: 6px;
        cursor: pointer;
        position: relative;
      }

      .map-preview:hover {
        opacity: 0.95;
      }

      .map-info {
        padding: 10px 12px;
        display: flex;
        flex-direction: column;
        gap: 3px;
        background: #ffffff;
        border-top: 1px solid #edf2f7;
      }

      .map-info-title {
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
      }

      .map-info-sub {
        font-size: 11px;
        font-weight: 500;
        color: #64748b;
      }

      /* Slider Group */
      .filter-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
      }

      .filter-label-row {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
      }

      .filter-range {
        width: 100%;
        accent-color: #0f172a;
        cursor: pointer;
      }

      .range-limits {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
      }

      /* Checkboxes */
      .checkbox-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
      }

      .checkbox-label {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        user-select: none;
      }

      .custom-box {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        flex-shrink: 0;
      }

      .checkbox-label input {
        display: none;
      }

      .checkbox-label input:checked + .custom-box {
        background: #0f172a;
        border-color: #0f172a;
      }

      .checkbox-label input:checked + .custom-box::after {
        content: '';
        width: 4px;
        height: 8px;
        border: solid #ffffff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        margin-top: -2px;
      }

      .apply-filter-btn {
        width: 100%;
        background: #0f172a;
        color: #ffffff;
        border: none;
        padding: 10px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease;
        margin-top: 4px;
      }

      .apply-filter-btn:hover {
        background: #15803d;
      }

      /* Right Hotel List Area */
      .hotels-section {
        display: flex;
        flex-direction: column;
      }

      .hotels-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
      }

      .hotels-count {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
      }

      .sort-btn {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
      }

      .hotels-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
      }

/* Keep the card container completely static on hover */
.hotel-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 14px;
  display: flex;
  gap: 18px;
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
  /* Card transition removed so the card does not move */
}

/* Base image styling */
.hotel-img-wrap {
  width: 150px;
  height: 120px;
  border-radius: 12px;
  overflow: hidden;
  flex-shrink: 0;
}

.hotel-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.35s ease;
}

/* Trigger zoom ONLY when the mouse is directly over the image */
.hotel-img-wrap:hover img {
  transform: scale(1.08);
}
      .hotel-details {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
      }

      .hotel-top-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 4px;
      }

      .hotel-name {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
      }

      .hotel-rating {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
      }

      .hotel-rating .star {
        color: #f59e0b;
      }

      .hotel-location {
        font-size: 12.5px;
        font-weight: 500;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 10px;
      }

      .hotel-bottom-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
      }

      .hotel-price {
        display: flex;
        align-items: baseline;
        gap: 3px;
      }

      .price-val {
        font-size: 17px;
        font-weight: 800;
        color: #15803d;
      }

      .price-unit {
        font-size: 11.5px;
        font-weight: 500;
        color: #64748b;
      }

      .btn-view-details {
        background: #0f172a;
        color: #ffffff;
        text-decoration: none;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: background 0.2s ease, gap 0.2s ease;
      }

      .btn-view-details:hover {
        background: #15803d;
        gap: 7px;
      }

      /* Responsive */
      @media (max-width: 860px) {
        .content-layout {
          grid-template-columns: 1fr;
        }
        .bestsellers-page {
          margin: 12px auto;
          padding: 24px 20px 32px 20px;
        }
      }

      @media (max-width: 520px) {
        .hotel-card {
          flex-direction: column;
        }
        .hotel-img-wrap {
          width: 100%;
          height: 150px;
        }
        .bestsellers-page {
          margin: 8px auto;
          padding: 20px 16px 28px 16px;
          border-radius: 20px;
        }
      }
    </style>
    @endpush

    <div class="bestsellers-page">

      <!-- Top Navigation Bar -->
      <div class="top-bar">
        <a href="#" class="home-link">
          <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
          <span>Home</span>
        </a>
        <a href="#" class="auth-btn">Sign In</a>
      </div>

      <!-- Header & Category Tabs -->
      <div class="header-section">
        <h1 class="page-title">
          <span></span>
          <span>Best Seller Hotels</span>
        </h1>
        <p class="page-subtitle">Most booked stays loved by our guests</p>

        <div class="collection-tabs">
          <a href="#" class="tab-pill active">
            <span></span>
            <span>Best Seller</span>
          </a>
          <a href="#" class="tab-pill">
            <span></span>
            <span>Popular</span>
          </a>
          <a href="#" class="tab-pill">
            <span></span>
            <span>Luxury</span>
          </a>
        </div>
      </div>

      <div class="section-divider"></div>

      <!-- Main Content Layout -->
      <div class="content-layout">

        <!-- Left Filters Sidebar -->
        <aside class="filters-card">
          <div class="filters-header">
            <span class="filters-title">Filters</span>
            <button class="clear-btn">Clear</button>
          </div>

          <!-- Interactive Map Widget -->
          <div class="map-box">
            <div class="map-preview">
              <span>🗺️</span>
              <span>Interactive Map</span>
            </div>
            <div class="map-info">
              <span class="map-info-title">📍 Selected: Downtown</span>
              <span class="map-info-sub">• 24 hotels in radius</span>
            </div>
          </div>

          <!-- Distance Slider -->
          <div class="filter-item">
            <div class="filter-label-row">
              <span>Distance to Center</span>
              <span>2.5 km</span>
            </div>
            <input type="range" class="filter-range" min="0" max="10" value="2.5" step="0.5">
            <div class="range-limits">
              <span>0 km</span>
              <span>10 km</span>
            </div>
          </div>

          <!-- Price Range Slider -->
          <div class="filter-item">
            <div class="filter-label-row">
              <span>Price Range</span>
              <span>$50 – $350</span>
            </div>
            <input type="range" class="filter-range" min="50" max="500" value="350" step="10">
            <div class="range-limits">
              <span>$50</span>
              <span>$500+</span>
            </div>
          </div>

          <!-- Must-Have Perks -->
          <div class="filter-item">
            <div class="filter-label-row">
              <span>Must-Have Perks</span>
            </div>
            <div class="checkbox-list">
              <label class="checkbox-label">
                <input type="checkbox" checked>
                <span class="custom-box"></span>
                <span>Free Breakfast</span>
              </label>
              <label class="checkbox-label">
                <input type="checkbox" checked>
                <span class="custom-box"></span>
                <span>Free Cancellation</span>
              </label>
              <label class="checkbox-label">
                <input type="checkbox">
                <span class="custom-box"></span>
                <span>Swimming Pool</span>
              </label>
            </div>
          </div>

          <button class="apply-filter-btn">Apply Filters (24)</button>
        </aside>

        <!-- Right Hotels List -->
        <main class="hotels-section">
          <div class="hotels-header">
            <span class="hotels-count">HOTELS (24 Stays Found)</span>
            <button class="sort-btn">
              <span>Sort By</span>
              <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
            </button>
          </div>

          <div class="hotels-list">

            <!-- Hotel Card 1 -->
            <div class="hotel-card">
              <div class="hotel-img-wrap">
                <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=500&q=80" alt="Grand Metro City Hotel">
              </div>
              <div class="hotel-details">
                <div>
                  <div class="hotel-top-row">
                    <h3 class="hotel-name">Grand Metro City Hotel</h3>
                    <div class="hotel-rating">
                      <span class="star">★</span>
                      <span>4.9</span>
                    </div>
                  </div>
                  <div class="hotel-location">
                    <span>📍 Downtown Center • 200m to Metro</span>
                  </div>
                </div>
                <div class="hotel-bottom-row">
                  <div class="hotel-price">
                    <span class="price-val">$120</span>
                    <span class="price-unit">/ night</span>
                  </div>
                  <a href="{{ route('rooms.show', 3) }}" class="btn-view-details">
                    <span>View Details</span>
                    <i data-lucide="arrow-right" style="width: 13px; height: 13px;"></i>
                  </a>
                </div>
              </div>
            </div>

            <!-- Hotel Card 2 -->
            <div class="hotel-card">
              <div class="hotel-img-wrap">
                <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=500&q=80" alt="Ocean Breeze Resort">
              </div>
              <div class="hotel-details">
                <div>
                  <div class="hotel-top-row">
                    <h3 class="hotel-name">Ocean Breeze Resort</h3>
                    <div class="hotel-rating">
                      <span class="star">★</span>
                      <span>4.8</span>
                    </div>
                  </div>
                  <div class="hotel-location">
                    <span>📍 Beachfront Blvd • Infinity Pool</span>
                  </div>
                </div>
                <div class="hotel-bottom-row">
                  <div class="hotel-price">
                    <span class="price-val">$150</span>
                    <span class="price-unit">/ night</span>
                  </div>
                  <a href="{{ route('rooms.show', 4) }}" class="btn-view-details">
                    <span>View Details</span>
                    <i data-lucide="arrow-right" style="width: 13px; height: 13px;"></i>
                  </a>
                </div>
              </div>
            </div>

            <!-- Hotel Card 3 -->
            <div class="hotel-card">
              <div class="hotel-img-wrap">
                <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=500&q=80" alt="Aegean Cliff Suites">
              </div>
              <div class="hotel-details">
                <div>
                  <div class="hotel-top-row">
                    <h3 class="hotel-name">Aegean Cliff Suites</h3>
                    <div class="hotel-rating">
                      <span class="star">★</span>
                      <span>4.9</span>
                    </div>
                  </div>
                  <div class="hotel-location">
                    <span>📍 Cliffside Drive • Sunset View</span>
                  </div>
                </div>
                <div class="hotel-bottom-row">
                  <div class="hotel-price">
                    <span class="price-val">$130</span>
                    <span class="price-unit">/ night</span>
                  </div>
                  <a href="{{ route('rooms.show', 5) }}" class="btn-view-details">
                    <span>View Details</span>
                    <i data-lucide="arrow-right" style="width: 13px; height: 13px;"></i>
                  </a>
                </div>
              </div>
            </div>

          </div>
        </main>

      </div>

    </div>

    @push('scripts')
    <script>
      lucide.createIcons();
    </script>
    @endpush
</x-public-layout>