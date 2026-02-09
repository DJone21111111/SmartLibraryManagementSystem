<?php
use App\Framework\Auth;
?>
<div class="app-shell d-flex">
  <?php if (empty($hideSidebar)): ?>
  <aside class="site-sidebar">
    <div class="sidebar-brand px-3 mb-4">
      <a class="d-flex align-items-center gap-2" href="/">
        <div style="width:40px;height:40px;background:var(--accent);border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">SL</div>
        <div>
          <div style="font-weight:700;color:#fff;">Smart <span style="color:var(--accent)">Library</span></div>
        </div>
      </a>
    </div>

    <?php
      $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
      $path = rtrim($path, '/') ?: '/';
      $loggedIn = Auth::check();

      $dashboardActive = ($loggedIn && strpos($path, '/dashboard') === 0) ? ' active' : '';
      $catalogActive   = (strpos($path, '/catalog') === 0 || strpos($path, '/books') === 0 || $path === '/') ? ' active' : '';
      $loansActive     = (strpos($path, '/loans') === 0) ? ' active' : '';
      $reservActive    = (strpos($path, '/reservations') === 0) ? ' active' : '';
      $settingsActive  = (strpos($path, '/settings') === 0) ? ' active' : '';
    ?>

    <nav class="nav flex-column px-2">
      <a class="nav-link d-flex align-items-center px-3 py-2<?= $dashboardActive ?>" href="/dashboard"><i class="bi bi-grid-1x2-fill me-2"></i> Dashboard</a>
      <a class="nav-link d-flex align-items-center px-3 py-2<?= $catalogActive ?>" href="/catalog"><i class="bi bi-book-half me-2"></i> Catalog</a>
      <a class="nav-link d-flex align-items-center px-3 py-2<?= $loansActive ?>" href="/loans"><i class="bi bi-journal-bookmark me-2"></i> My Loans</a>
      <a class="nav-link d-flex align-items-center px-3 py-2<?= $reservActive ?>" href="/reservations"><i class="bi bi-calendar-check me-2"></i> My Reservations</a>
      <a class="nav-link d-flex align-items-center px-3 py-2<?= $settingsActive ?>" href="/settings"><i class="bi bi-gear me-2"></i> Settings</a>
    </nav>

    <div class="sidebar-footer px-3 mt-auto text-white-50">© 2024 Smart Library</div>
  </aside>
  <?php endif; ?>

  <div class="app-main flex-grow-1<?= !empty($hideSidebar) ? ' no-sidebar' : '' ?>">
    <?php if (empty($hideSidebar)): ?>
    <nav class="topbar">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <?php $isCatalogActive = trim($catalogActive ?? '') !== ''; ?>
              <li class="breadcrumb-item<?= $isCatalogActive ? ' active' : '' ?>" <?= $isCatalogActive ? 'aria-current="page"' : '' ?>>
                <?php if ($isCatalogActive): ?>
                  Catalog
                <?php else: ?>
                  <a href="/catalog">Catalog</a>
                <?php endif; ?>
              </li>
            </ol>
          </nav>
        </div>

        <div class="d-flex align-items-center gap-3">
          <?php if (Auth::check()): $u = Auth::user(); ?>
            <div class="text-muted">Welcome, <?= htmlspecialchars($u['name'] ?? $u['email'] ?? 'User') ?>!</div>
            <div class="dropdown">
              <a class="btn btn-light btn-sm rounded-circle" href="#" role="button" data-bs-toggle="dropdown"><?= strtoupper(substr($u['name'] ?? 'U',0,1)) ?></a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a class="btn btn-outline-primary btn-sm" href="/login">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
    <!-- main content starts here (views will render inside app-main) -->
    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-12">
          <!-- content -->
        </div>
      </div>
    </div>
    <!-- VIEW CONTENT WILL APPEAR AFTER THIS -->
    <?php else: ?>
    <!-- For pages which hide the sidebar (like login), keep a simple container placeholder so the view can render a full-bleed split layout -->
    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-12">
          <!-- content placeholder for full-width pages -->
        </div>
      </div>
    </div>
    <?php endif; ?>

<?php
// Note: `Shared/footer.php` will close the opened layout containers.
?>
