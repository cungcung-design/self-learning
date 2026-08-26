<section class="footer-section">
  <div class="footer-wrapper">

    <!-- Top Newsletter Bar -->
    <div class="newsletter-banner">
      <div class="newsletter-text">
        <h3>Get exclusive travel deals & tips</h3>
        <p>Subscribe to our newsletter</p>
      </div>
      <form class="newsletter-form" onsubmit="event.preventDefault();">
        <input type="email" class="newsletter-input" placeholder="Enter your email" required>
        <button type="submit" class="newsletter-btn">Subscribe</button>
      </form>
    </div>

    <!-- Main Navigation Links & Brand Info -->
    <div class="footer-main">
      <!-- Brand Details -->
      <div class="brand-col">
        <div class="logo"><span>MR</span>studio</div>
        <p>Creating unforgettable travel experiences around the world.</p>
        <div class="social-links">
          <a href="#" class="social-circle" aria-label="Facebook"><i data-lucide="facebook"></i></a>
          <a href="#" class="social-circle" aria-label="Instagram"><i data-lucide="instagram"></i></a>
          <a href="#" class="social-circle" aria-label="Twitter"><i data-lucide="twitter"></i></a>
          <a href="#" class="social-circle" aria-label="Pinterest"><i data-lucide="pin"></i></a>
        </div>
      </div>

      <!-- Company Links -->
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Press</a></li>
          <li><a href="#">Blog</a></li>
        </ul>
      </div>

      <!-- Support Links -->
      <div class="footer-col">
        <h4>Support</h4>
        <ul>
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Cancellation</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="footer-col">
        <h4>Contact</h4>
        <div class="contact-info">
          <p>+1 234 567 890</p>
          <p>hello@mrstudio.com</p>
          <p>123 Beach Road,<br>Bali, Indonesia</p>
        </div>
      </div>
    </div>

    <!-- Bottom Copyright & Legal Links -->
    <div class="footer-bottom">
      <p>&copy; 2024 MRstudio. All rights reserved.</p>
      <div class="legal-links">
        <a href="#">Terms of Use</a>
        <a href="#">Privacy Policy</a>
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
