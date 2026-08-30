<x-public-layout :title="$pageTitle">
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
        flex-wrap: nowrap;
        gap: 10px;
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-x: contain;
        scrollbar-width: none;
      }

      .collection-tabs::-webkit-scrollbar {
        display: none;
      }

      .collection-tabs .tab-pill {
        flex-shrink: 0;
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
      html {
        scroll-behavior: smooth;
      }

      .hotels-section {
        display: flex;
        flex-direction: column;
        scroll-margin-top: 96px;
        position: relative;
        transition: opacity 0.28s ease;
      }

      .hotels-section.is-loading {
        opacity: 0.45;
        pointer-events: none;
      }

      .hotels-section.is-swapping {
        opacity: 0;
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

      .hotels-header-actions {
        display: inline-flex;
        align-items: center;
        gap: 10px;
      }

      .hotels-carousel-arrows {
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }

      .hotels-carousel {
        display: flex;
        flex-direction: column;
        gap: 16px;
      }

      .hotels-carousel-shell {
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr) 44px;
        gap: 12px;
        align-items: center;
      }

      .hotels-carousel-viewport {
        overflow: hidden;
        width: 100%;
        touch-action: pan-y;
      }

      .hotels-carousel-track {
        display: flex;
        will-change: transform;
        transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
      }

      .hotels-carousel-page {
        flex: 0 0 100%;
        min-width: 100%;
        display: flex;
        flex-direction: column;
        gap: 16px;
      }

      .carousel-arrow {
        width: 44px;
        height: 44px;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        background: #ffffff;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.2s ease, opacity 0.2s ease;
      }

      .carousel-arrow:hover:not(:disabled) {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        transform: translateY(-1px);
      }

      .carousel-arrow:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        box-shadow: none;
      }

      .hotels-page-meta {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        text-align: center;
      }

      @media (prefers-reduced-motion: reduce) {
        .hotels-carousel-track {
          transition: none;
        }

        .collection-tabs {
          scroll-behavior: auto;
        }

        .hotels-section {
          transition: none;
        }
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
        .hotels-header {
          flex-wrap: wrap;
          gap: 10px;
        }
        .hotels-carousel-shell {
          grid-template-columns: 40px minmax(0, 1fr) 40px;
          gap: 8px;
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
        .hotels-carousel-shell {
          grid-template-columns: 1fr 1fr;
          justify-items: center;
        }
        .hotels-carousel-viewport {
          grid-column: 1 / -1;
        }
      }
    </style>
    @endpush

    <div class="bestsellers-page">

      <!-- Top Navigation Bar -->
      <div class="top-bar">
        <a href="{{ route('home.public') }}" class="home-link">
          <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
          <span>Home</span>
        </a>
        @auth
          <a href="{{ route('bookings.index') }}" class="auth-btn">My Bookings</a>
        @else
          <a href="{{ route('login') }}" class="auth-btn">Sign In</a>
        @endauth
      </div>

      <!-- Header & Category Tabs -->
      <div class="header-section">
        <h1 class="page-title">
          <span></span>
          <span data-featured-page-title>{{ $pageTitle }}</span>
        </h1>
        <p class="page-subtitle">Most booked stays loved by our guests</p>

        <div class="collection-tabs">
          <a href="{{ route('featured.index') }}" class="tab-pill {{ $activeCategory ? '' : 'active' }}">
            <span>All</span>
          </a>
          @foreach ($categories as $category)
            <a href="{{ route('featured.index', ['category' => $category->slug]) }}"
              class="tab-pill {{ $activeCategory?->is($category) ? 'active' : '' }}">
              <span>{{ $category->name }}</span>
            </a>
          @endforeach
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
              <span class="map-info-sub" data-featured-map-count>• {{ $hotels->count() }} {{ \Illuminate\Support\Str::plural('hotel', $hotels->count()) }} in this collection</span>
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

          <button class="apply-filter-btn" type="button" data-featured-apply-count>{{ $hotels->count() }} {{ \Illuminate\Support\Str::plural('stay', $hotels->count()) }} found</button>
        </aside>

        <!-- Right Hotels List -->
        <main class="hotels-section" id="featured-hotels" aria-live="polite">
          @include('home.partials.featured-hotels', ['hotels' => $hotels])
        </main>

      </div>

    </div>

    @push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      if (window.lucide) {
        lucide.createIcons();
      }

      const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const collectionTabs = document.querySelector('.collection-tabs');
      const hotelsSection = document.getElementById('featured-hotels');
      const pageTitleEl = document.querySelector('[data-featured-page-title]');
      const mapCountEl = document.querySelector('[data-featured-map-count]');
      const applyCountEl = document.querySelector('[data-featured-apply-count]');
      let listingsRequest = null;

      const sameLocation = (left, right) => {
        const a = new URL(left, window.location.origin);
        const b = new URL(right, window.location.origin);
        return a.pathname === b.pathname && a.search === b.search;
      };

      const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

      const revealTab = (tab) => {
        if (!tab || !collectionTabs) {
          return;
        }

        const tabRect = tab.getBoundingClientRect();
        const containerRect = collectionTabs.getBoundingClientRect();
        const overflowed = tabRect.left < containerRect.left + 8 || tabRect.right > containerRect.right - 8;
        const maxScroll = collectionTabs.scrollWidth - collectionTabs.clientWidth;

        if (maxScroll <= 0) {
          return;
        }

        const tabCenter = tabRect.left + tabRect.width / 2;
        const containerCenter = containerRect.left + containerRect.width / 2;
        const nextScroll = Math.min(
          maxScroll,
          Math.max(0, collectionTabs.scrollLeft + (tabCenter - containerCenter))
        );

        if (overflowed || Math.abs(nextScroll - collectionTabs.scrollLeft) > 1) {
          collectionTabs.scrollTo({
            left: nextScroll,
            behavior: prefersReducedMotion ? 'auto' : 'smooth',
          });
        }
      };

      const setActiveTab = (url) => {
        if (!collectionTabs) {
          return null;
        }

        let active = null;
        collectionTabs.querySelectorAll('.tab-pill').forEach((tab) => {
          const isActive = sameLocation(tab.href, url);
          tab.classList.toggle('active', isActive);
          if (isActive) {
            active = tab;
          }
        });

        return active;
      };

      const initHotelCarousel = () => {
        const carousel = document.querySelector('[data-hotel-carousel]');
        if (!carousel) {
          return;
        }

        const track = carousel.querySelector('[data-carousel-track]');
        const pages = carousel.querySelectorAll('[data-carousel-page]');
        const viewport = carousel.querySelector('[data-carousel-viewport]');
        const prevButtons = document.querySelectorAll('[data-carousel-prev]');
        const nextButtons = document.querySelectorAll('[data-carousel-next]');
        const meta = carousel.querySelector('[data-carousel-meta]');
        const pageSize = Number(carousel.dataset.pageSize || 4);
        const total = Number(carousel.dataset.hotelCount || 0);
        const lastIndex = Math.max(0, pages.length - 1);
        let index = 0;
        let touchStartX = 0;
        let touchStartY = 0;

        const update = () => {
          if (track) {
            track.style.transform = 'translateX(-' + (index * 100) + '%)';
          }
          const atStart = index <= 0;
          const atEnd = index >= lastIndex;
          prevButtons.forEach((button) => {
            button.disabled = atStart;
            button.setAttribute('aria-disabled', atStart ? 'true' : 'false');
          });
          nextButtons.forEach((button) => {
            button.disabled = atEnd;
            button.setAttribute('aria-disabled', atEnd ? 'true' : 'false');
          });
          if (meta && total) {
            const start = index * pageSize + 1;
            const end = Math.min(total, (index + 1) * pageSize);
            meta.textContent = 'Showing ' + start + '–' + end + ' of ' + total + ' stays';
          }
        };

        const go = (delta) => {
          const next = Math.min(lastIndex, Math.max(0, index + delta));
          if (next === index) {
            return;
          }
          index = next;
          update();
        };

        prevButtons.forEach((button) => button.addEventListener('click', () => go(-1)));
        nextButtons.forEach((button) => button.addEventListener('click', () => go(1)));

        viewport?.addEventListener('keydown', (event) => {
          if (event.key === 'ArrowLeft') {
            event.preventDefault();
            go(-1);
          }
          if (event.key === 'ArrowRight') {
            event.preventDefault();
            go(1);
          }
        });

        viewport?.addEventListener('touchstart', (event) => {
          touchStartX = event.changedTouches[0].clientX;
          touchStartY = event.changedTouches[0].clientY;
        }, { passive: true });

        viewport?.addEventListener('touchend', (event) => {
          const touch = event.changedTouches[0];
          const dx = touch.clientX - touchStartX;
          const dy = touch.clientY - touchStartY;
          if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) {
            go(dx < 0 ? 1 : -1);
          }
        }, { passive: true });

        update();
      };

      const applyListings = async (payload) => {
        if (!hotelsSection) {
          return;
        }

        if (!prefersReducedMotion) {
          hotelsSection.classList.add('is-swapping');
          await wait(180);
        }

        hotelsSection.innerHTML = payload.html || '';

        if (pageTitleEl && payload.title) {
          pageTitleEl.textContent = payload.title;
        }
        if (payload.documentTitle) {
          document.title = payload.documentTitle;
        }
        if (mapCountEl && payload.mapCountLabel) {
          mapCountEl.textContent = payload.mapCountLabel;
        }
        if (applyCountEl && payload.applyLabel) {
          applyCountEl.textContent = payload.applyLabel;
        }

        if (window.lucide) {
          lucide.createIcons();
        }
        initHotelCarousel();

        hotelsSection.classList.remove('is-loading');
        hotelsSection.removeAttribute('aria-busy');
        if (!prefersReducedMotion) {
          void hotelsSection.offsetWidth;
        }
        hotelsSection.classList.remove('is-swapping');
      };

      const loadCategory = async (url, { push = false } = {}) => {
        if (!hotelsSection) {
          return;
        }

        if (listingsRequest) {
          listingsRequest.abort();
        }

        const controller = new AbortController();
        listingsRequest = controller;

        hotelsSection.classList.add('is-loading');
        hotelsSection.setAttribute('aria-busy', 'true');

        if (push && !sameLocation(window.location.href, url)) {
          window.history.pushState({ featuredCategory: true }, '', url);
        }

        try {
          const response = await fetch(url, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json',
            },
            credentials: 'same-origin',
            signal: controller.signal,
          });

          if (!response.ok) {
            throw new Error('Unable to load hotels.');
          }

          const payload = await response.json();
          await applyListings(payload);
        } catch (error) {
          if (error.name === 'AbortError') {
            return;
          }
          hotelsSection.classList.remove('is-loading', 'is-swapping');
          hotelsSection.removeAttribute('aria-busy');
        } finally {
          if (listingsRequest === controller) {
            listingsRequest = null;
          }
        }
      };

      if (collectionTabs) {
        requestAnimationFrame(() => {
          revealTab(collectionTabs.querySelector('.tab-pill.active'));
        });

        collectionTabs.addEventListener('click', (event) => {
          const tab = event.target.closest('a.tab-pill');
          if (!tab) {
            return;
          }

          if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
          }

          event.preventDefault();
          const active = setActiveTab(tab.href);
          revealTab(active || tab);

          if (sameLocation(window.location.href, tab.href)) {
            return;
          }

          loadCategory(tab.href, { push: true });
        });
      }

      const onFeaturedPopState = () => {
        const featuredTab = collectionTabs?.querySelector('.tab-pill');
        const featuredPath = featuredTab
          ? new URL(featuredTab.href, window.location.origin).pathname
          : '/featured-listings';

        if (window.location.pathname !== featuredPath) {
          return;
        }

        const active = setActiveTab(window.location.href);
        revealTab(active);
        loadCategory(window.location.href, { push: false });
      };

      window.addEventListener('popstate', onFeaturedPopState);

      document.addEventListener('public-page:leave', () => {
        if (listingsRequest) {
          listingsRequest.abort();
        }
        window.removeEventListener('popstate', onFeaturedPopState);
      }, { once: true });

      initHotelCarousel();
    </script>
    @endpush
</x-public-layout>