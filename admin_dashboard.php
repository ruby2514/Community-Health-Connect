<?php
$pageTitle = "Admin Dashboard - Community Health Connect";
require 'config.php';

// Make sure admin is logged in
if (empty($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

// Safe fallback for name
$adminName = (!empty($_SESSION['admin_username'])) ? $_SESSION['admin_username'] : 'Admin';

// Get counts
$totalResources  = (int)$pdo->query("SELECT COUNT(*) FROM resources")->fetchColumn();
$totalCategories = (int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

require 'header.php';
?>

<h1 class="mb-3">Admin Dashboard</h1>
<p class="text-muted mb-4">
  Welcome, <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8'); ?>.
  Manage community resources and keep Community Health Connect up to date.
</p>

<div class="row g-3 mb-4">
  <div class="col-md-6">
    <div class="card admin-stat-card resources">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="text-uppercase small mb-1 opacity-75">Total Resources</div>
          <div class="display-6 fw-bold"><?= $totalResources; ?></div>
        </div>
        <div class="admin-stat-icon">
          <i class="bi bi-building-heart fs-4 text-white"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card admin-stat-card categories">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="text-uppercase small mb-1 opacity-75">Categories</div>
          <div class="display-6 fw-bold"><?= $totalCategories; ?></div>
        </div>
        <div class="admin-stat-icon">
          <i class="bi bi-grid-3x3-gap fs-4 text-white"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="d-flex flex-wrap gap-2 mb-3">
  <a href="manage_resources.php" class="btn btn-primary">
    <i class="bi bi-list-ul me-1"></i> Manage Resources
  </a>
  <a href="add_resource.php" class="btn btn-outline-primary">
    <i class="bi bi-plus-circle me-1"></i> Add New Resource
  </a>
  <a href="logout.php" class="btn btn-outline-secondary ms-auto">
    <i class="bi bi-box-arrow-right me-1"></i> Logout
  </a>
</div>

<?php require 'footer.php'; ?>
