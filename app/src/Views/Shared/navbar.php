<?php
use App\Framework\Auth;
$user = Auth::user();
$route = $_GET['route'] ?? 'home';
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-brown">
  <div class="container-fluid px-3">
    <a class="navbar-brand fw-bold" href="/index.php?route=home">📚 Smart Library</a>

    <div class="collapse navbar-collapse show">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
        <li class="nav-item"><a class="nav-link" href="/index.php?route=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?route=catalog">Catalog</a></li>

        <?php if (!$user): ?>
          <li class="nav-item"><a class="btn btn-light btn-sm" href="/index.php?route=login">Login</a></li>
          <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="/index.php?route=register">Register</a></li>
        <?php else: ?>
          <li class="nav-item">
            <span class="navbar-text text-white small">
              Welcome, <?= htmlspecialchars($user['email'] ?? 'User') ?>
            </span>
          </li>

          <?php if (($user['role'] ?? '') === 'librarian'): ?>
            <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="/index.php?route=admin/dashboard">Admin</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="/index.php?route=dashboard">Dashboard</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="btn btn-light btn-sm" href="/index.php?route=logout">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid px-3 mt-3">
  <?php if (!empty($flash)): ?>
    <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?> card-soft">
      <?= htmlspecialchars($flash['message'] ?? '') ?>
    </div>
  <?php endif; ?>
</div>
