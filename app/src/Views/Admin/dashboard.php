<div class="container-fluid px-3">
  <div class="row g-3">

    <div class="col-lg-3">
      <div class="sidebar rounded-4 p-3">
        <div class="text-white fw-bold mb-2">Admin Menu</div>
        <a class="<?= ($_GET['route'] ?? '') === 'admin/dashboard' ? 'active' : '' ?>" href="/index.php?route=admin/dashboard">Dashboard</a>
        <a class="<?= str_contains($_GET['route'] ?? '', 'admin/books') ? 'active' : '' ?>" href="/index.php?route=admin/books">Manage Books</a>
        <a class="<?= ($_GET['route'] ?? '') === 'admin/loans' ? 'active' : '' ?>" href="/index.php?route=admin/loans">Manage Loans</a>
        <a class="<?= ($_GET['route'] ?? '') === 'admin/reservations' ? 'active' : '' ?>" href="/index.php?route=admin/reservations">Manage Reservations</a>
      </div>
    </div>

    <div class="col-lg-9">
      <div class="card card-soft p-4">
        <h3 class="fw-bold mb-1">Admin Dashboard</h3>
        <p class="text-muted mb-0">Manage books, loans and reservations.</p>
      </div>
    </div>

  </div>
</div>
