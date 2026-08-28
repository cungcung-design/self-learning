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
         Left Column: Media & Details
      ------------------------------------ */
      .gallery-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        grid-template-rows: 155px 155px;
        gap: 14px;
        margin-bottom: 24px;
        border-radius: 20px;
        overflow: hidden;
      }

      .gallery-main {
        grid-row: span 2;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 18px;
      }

      .gallery-thumb-top {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        height: 100%;
      }

      .gallery-thumb-top img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 14px;
      }

      .gallery-overlay-wrap {
        position: relative;
        height: 100%;
        border-radius: 14px;
        overflow: hidden;
      }

      .gallery-overlay-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: blur(4px) brightness(0.9);
      }

      .gallery-overlay-text {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        background: rgba(255, 255, 255, 0.4);
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

      .action-btns {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #94a3b8;
      }

      .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
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

      .feature-item svg {
        width: 16px;
        height: 16px;
        stroke: #334155;
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

      .price-old {
        font-size: 12px;
        font-weight: 500;
        color: #cbd5e1;
        text-decoration: line-through;
        margin-left: 4px;
      }

      .badge-discount {
        background: #ff2e79;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 7px;
        border-radius: 12px;
        letter-spacing: 0.2px;
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

      /* Extra Features Collapsible */
      .extras-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 10px;
      }

      .extras-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 18px;
      }

      .extra-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11.5px;
        font-weight: 500;
        color: #334155;
      }

      .extra-item-left {
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .custom-check {
        width: 14px;
        height: 14px;
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
      }

      .custom-check.checked {
        background: #1d72fe;
        border-color: #1d72fe;
      }

      .custom-check.checked svg {
        width: 10px;
        height: 10px;
        stroke: #fff;
        stroke-width: 3;
      }

      .extra-price {
        font-weight: 700;
        color: #1e293b;
      }

      .extra-price.muted {
        color: #94a3b8;
        font-weight: 500;
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
          <div class="gallery-grid">
            <img class="gallery-main" src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" alt="Main Suite View">
            <div class="gallery-thumb-top">
              <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=400&q=80" alt="Resort Pool">
              <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=400&q=80" alt="Room Bed View">
            </div>
            <div class="gallery-overlay-wrap">
              <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=400&q=80" alt="More Photos">
              <div class="gallery-overlay-text">+12 Photos</div>
            </div>
          </div>

          <!-- Badges, Title & Rating -->
          <div class="badges-row">
            <span class="score-badge">5.0 Perfect</span>
            <span class="tag-badge tag-blue">Hotels</span>
            <span class="tag-badge tag-purple">New Building</span>
            <span class="tag-badge tag-orange">Top Value</span>
            <div class="stars">
              <i data-lucide="star"></i>
              <i data-lucide="star"></i>
              <i data-lucide="star"></i>
              <i data-lucide="star"></i>
            </div>
          </div>

          <div class="title-row">
            <h1 class="room-title">Maxone Ascent Hotel Luxury Kota Malang</h1>
            <div class="action-btns">
              <button class="action-btn" aria-label="Save"><i data-lucide="bookmark" style="width: 18px; height: 18px;"></i></button>
              <button class="action-btn" aria-label="Share"><i data-lucide="share-2" style="width: 18px; height: 18px;"></i></button>
            </div>
          </div>

          <p class="room-address">Jln. Diponegoro V No. 12, Kec. Lowokwaru, Kota Malang</p>

          <!-- Tabs Navigation -->
          <div class="tabs-nav">
            <a href="#" class="tab-link active">Description</a>
            <a href="#" class="tab-link">Features</a>
            <a href="#" class="tab-link">Virtual</a>
            <a href="#" class="tab-link">Price & Task history</a>
          </div>

          <!-- Room Description -->
          <p class="room-description">
            A studio apartment in strategic location in Malang. Located nearby Univ Muhammadiyah Malang, Univ Negeri Malang and Univ Brawijaya, this is perfect for students and academics. This is in the main road to Batu, the main tourist attractions in East Java. So, it is well suited for tourists. This has a stunning Arjuno Mountain view with misty ambience in morning. It has kitchen, and cozy sofa and bunk bed & it caters up 3 guests. It has two pools, gyms, futsal field, minimarket and coffee shop.
          </p>

          <!-- Hotel Features Icons -->
          <h3 class="features-heading">Hotels features</h3>
          <div class="features-row">
            <div class="feature-item">
              <i data-lucide="wifi"></i>
              <span>Wi-Fi</span>
            </div>
            <div class="feature-item">
              <i data-lucide="bed"></i>
              <span>Kings Bed</span>
            </div>
            <div class="feature-item">
              <i data-lucide="bath"></i>
              <span>Bathup</span>
            </div>
            <div class="feature-item">
              <i data-lucide="utensils"></i>
              <span>Breakfast</span>
            </div>
            <div class="feature-item">
              <i data-lucide="maximize-2"></i>
              <span>4m x 6m</span>
            </div>
          </div>

        </div>

        <!-- Right Column: Booking Card -->
        <aside class="booking-card">
          <div class="price-header">
            <div class="price-main">
              <span class="price-current">$301</span>
              <span class="price-unit">/night</span>
              <span class="price-old">$501</span>
            </div>
            <span class="badge-discount">20% OFF</span>
          </div>

          <!-- Check-in / Check-out Fields -->
          <div class="dates-grid">
            <div class="field-group">
              <label>Check-In</label>
              <div class="date-box">Oct 7, 2021</div>
            </div>
            <div class="field-group">
              <label>Check-Out</label>
              <div class="date-box">Oct 8, 2021</div>
            </div>
          </div>

          <!-- Guest Selector -->
          <div class="field-group">
            <label>Guest</label>
            <div class="guest-box">
              <span>2 Adults, 1 Children</span>
              <i data-lucide="chevron-down" style="width: 14px; height: 14px; color: #64748b;"></i>
            </div>
          </div>

          <!-- Extra Features Checkboxes -->
          <div class="extras-header">
            <span>Extra Features</span>
            <i data-lucide="minus" style="width: 14px; height: 14px; color: #64748b; cursor: pointer;"></i>
          </div>

          <div class="extras-list">
            <div class="extra-item">
              <div class="extra-item-left">
                <span class="custom-check"></span>
                <span>Allow to bring pet</span>
              </div>
              <span class="extra-price muted">$13</span>
            </div>
            <div class="extra-item">
              <div class="extra-item-left">
                <span class="custom-check checked"><i data-lucide="check"></i></span>
                <span>Breakfast a day per person</span>
              </div>
              <span class="extra-price">$10</span>
            </div>
            <div class="extra-item">
              <div class="extra-item-left">
                <span class="custom-check"></span>
                <span>Parking a day</span>
              </div>
              <span class="extra-price muted">$6</span>
            </div>
            <div class="extra-item">
              <div class="extra-item-left">
                <span class="custom-check"></span>
                <span>Extra pillow</span>
              </div>
              <span class="extra-price muted">Free</span>
            </div>
          </div>

          <!-- Pricing Breakdown -->
          <div class="pricing-summary">
            <span class="pricing-summary-title">Price</span>
            <div class="summary-line">
              <span>1 Nights</span>
              <span>$501</span>
            </div>
            <div class="summary-line highlight">
              <span>Discount 20%</span>
              <span>-$200</span>
            </div>
            <div class="summary-line">
              <span>Breakfast a day per person</span>
              <span>$10</span>
            </div>
            <div class="summary-line">
              <span>Service fee</span>
              <span>$5</span>
            </div>
          </div>

          <!-- Total Price -->
          <div class="total-line">
            <span>Total Payment</span>
            <span class="total-price">$316</span>
          </div>

          <!-- Booking CTA -->
          <button class="btn-book-now">Book Now</button>
          <p class="disclaimer">You will not get charged yet</p>
        </aside>

      </div>

    </div>

    @push('scripts')
    <script>
      lucide.createIcons();
    </script>
    @endpush
</x-public-layout>