<div class="container py-4">
  <h3 class="mb-3">My Reservations</h3>

  <div class="card card-soft p-3">
    <?php if (empty($reservations)): ?>
      <div class="text-muted">No reservations.</div>
    <?php else: ?>
      <?php foreach ($reservations as $r): ?>
        <div class="border rounded-3 p-2 mb-2">
          <div class="fw-semibold"><?= htmlspecialchars($r['Title'] ?? '') ?></div>
          <div class="text-muted small">Status: <?= htmlspecialchars($r['Status'] ?? '') ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
