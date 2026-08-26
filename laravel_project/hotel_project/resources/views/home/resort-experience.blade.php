<section class="resort-experience">
  <div class="experiences-container">
    <!-- Left Column -->
    <div class="content-side">
      <div class="title-wrapper">
        <h2>Resort Experiences</h2>
      </div>

      <div class="features-list">
        <!-- Infinity Pool -->
        <div class="feature-item">
          <div class="icon-circle">
            <svg viewBox="0 0 24 24">
              <path d="M12 2a6 6 0 0 0-6 6c0 4.5 6 12 6 12s6-7.5 6-12a6 6 0 0 0-6-6z" />
              <circle cx="12" cy="8" r="2.5" />
            </svg>
          </div>
          <div class="feature-text">
            <h3>Infinity Pool</h3>
            <p>Swim with a view</p>
          </div>
        </div>

        <!-- Private Beach -->
        <div class="feature-item">
          <div class="icon-circle">
            <svg viewBox="0 0 24 24">
              <path d="M12 18V9" />
              <path d="M12 9c-3 0-5.5-2-5.5-5 3.5 0 5.5 2 5.5 5z" />
              <path d="M12 9c3 0 5.5-2 5.5-5-3.5 0-5.5 2-5.5 5z" />
              <path d="M4 20c2-1 4-1 6 0s4 1 6 0 3-.5 4 0" />
            </svg>
          </div>
          <div class="feature-text">
            <h3>Private Beach</h3>
            <p>Feel the ocean breeze</p>
          </div>
        </div>

        <!-- Sunset Lounge -->
        <div class="feature-item">
          <div class="icon-circle">
            <svg viewBox="0 0 24 24">
              <path d="M12 4v4" />
              <path d="M12 12a4 4 0 0 0-4 4h8a4 4 0 0 0-4-4z" />
              <path d="M4 20h16" />
              <path d="M7 10l-1.5-1.5" />
              <path d="M17 10l1.5-1.5" />
            </svg>
          </div>
          <div class="feature-text">
            <h3>Sunset Lounge</h3>
            <p>Unwind at golden hour</p>
          </div>
        </div>

        <!-- Spa & Wellness -->
        <div class="feature-item">
          <div class="icon-circle">
            <svg viewBox="0 0 24 24">
              <circle cx="12" cy="6" r="2.5" />
              <path d="M7 13a5 5 0 0 1 10 0v5a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-5z" />
              <path d="M12 13v4" />
            </svg>
          </div>
          <div class="feature-text">
            <h3>Spa & Wellness</h3>
            <p>Rejuvenate your body</p>
          </div>
        </div>
      </div>

      <button class="cta-btn">Explore All Experiences</button>
    </div>

    <!-- Right Column (Image Showcase) -->
    <div class="media-side">
      <img id="mainDisplayImg" class="main-bg" src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80" alt="Resort Sunset View">
      
      <!-- Video Play Icon -->
      <button class="play-button" aria-label="Play video">
        <svg viewBox="0 0 24 24">
          <polygon points="6 3 20 12 6 21 6 3"></polygon>
        </svg>
      </button>

      <!-- Bottom Previews -->
      <div class="thumbnails-bar">
        <div class="thumb-item active" onclick="changeImage(this, 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80')">
          <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=300&q=80" alt="Infinity Pool Preview">
        </div>
        <div class="thumb-item" onclick="changeImage(this, 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=1200&q=80')">
          <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=300&q=80" alt="Private Beach Preview">
        </div>
        <div class="thumb-item" onclick="changeImage(this, 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1200&q=80')">
          <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=300&q=80" alt="Sunset Lounge Preview">
        </div>
        <div class="thumb-item" onclick="changeImage(this, 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=1200&q=80')">
          <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=300&q=80" alt="Spa Wellness Preview">
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  function changeImage(element, highResSrc) {
    const mainImg = document.getElementById('mainDisplayImg');
    
    mainImg.style.opacity = '0.3';
    
    setTimeout(() => {
      mainImg.src = highResSrc;
      mainImg.style.opacity = '1';
    }, 150);

    document.querySelectorAll('.thumb-item').forEach(item => {
      item.classList.remove('active');
    });
    element.classList.add('active');
  }
</script>
@endpush
