<?php
if (!isset($pageTitle)) $pageTitle = "Community Health Connect";
$currentPage = basename($_SERVER['PHP_SELF']);
function navActive(string $file, string $currentPage): string {
  return ($file === $currentPage) ? ' active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom styles -->
  <link href="styles.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
  <div class="container main-container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="logo.png" alt="Community Health Connect logo" style="height:32px; width:auto;">
      <span>COMMUNITY HEALTH <span class="brand-highlight">CONNECT</span></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item">
          <a class="nav-link<?= navActive('index.php', $currentPage) ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= navActive('search_resources.php', $currentPage) ?>" href="search_resources.php">Search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= navActive('about.php', $currentPage) ?>" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold text-warning d-flex align-items-center gap-1<?= navActive('emergency.php', $currentPage) ?>" href="emergency.php">
            <i class="bi bi-exclamation-triangle-fill"></i> Hotlines
          </a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light btn-sm ms-lg-2" href="admin_login.php">
            <i class="bi bi-person-gear me-1"></i> Admin
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="flex-grow-1 py-4">
  <div class="container main-container">
