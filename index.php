<?php
$pageTitle = "Home - Community Health Connect";
require 'config.php';
require 'header.php';
?>

<div class="row g-4 align-items-center">
  <div class="col-lg-7">
    <section class="hero-section mb-4">
      <div class="hero-pill mb-3">
        <span class="badge-dot" style="width:8px;height:8px;border-radius:999px;background:#22c55e;"></span>
        <span>Community Health • Access • Support</span>
      </div>

      <h1 class="hero-title mb-3">
        Community Health <span style="color:#bbf7d0;">Connect</span><br>
        to services that care.
      </h1>

      <p class="hero-subtitle mb-4">
        Search for clinics, food assistance, shelters, mental health services, and more — all in one place,
        designed to support public health and health equity.
      </p>

      <div class="hero-buttons d-flex flex-wrap gap-2 mb-3">
        <a href="search_resources.php" class="btn btn-primary">
          <i class="bi bi-search-heart-fill me-2"></i> Search by ZIP or City
        </a>
        <a href="emergency.php" class="btn btn-outline-light">
          <i class="bi bi-exclamation-octagon-fill me-1"></i> Hotlines & Crisis Support
        </a>
      </div>
    </section>
  </div>

  <div class="col-lg-5">
    <div class="row g-3">
      <div class="col-12">
        <div class="card feature-card">
          <div class="card-body d-flex gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center"
                 style="background:rgba(53,199,62,0.1); color:var(--chc-green); padding:0.8rem;">
              <i class="bi bi-geo-alt-fill fs-4"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Location-based search</h5>
              <p class="card-text small mb-0">
                Enter your city or ZIP code to discover nearby health and social services.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card feature-card">
          <div class="card-body d-flex gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center"
                 style="background:rgba(84,123,203,0.1); color:var(--chc-blue); padding:0.8rem;">
              <i class="bi bi-funnel-fill fs-4"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Filter by need</h5>
              <p class="card-text small mb-0">
                Focus on what matters most: food, housing, mental health, women’s health, and more.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card feature-card">
          <div class="card-body d-flex gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center"
                 style="background:rgba(17,24,39,0.06); color:var(--chc-dark); padding:0.8rem;">
              <i class="bi bi-shield-heart fs-4"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">Public health focused</h5>
              <p class="card-text small mb-0">
                Built to support social determinants of health and connect people to care.
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php require 'footer.php'; ?>
