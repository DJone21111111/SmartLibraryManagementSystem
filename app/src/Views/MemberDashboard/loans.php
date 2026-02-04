<div class="container py-4">
  <h3 class="mb-3">My Loans</h3>

  <div class="card card-soft p-3">
    <?php if (empty($loans)): ?>
      <div class="text-muted">No active loans.</div>
    <?php else: ?>
      <?php foreach ($loans as $l): ?>
        <div class="d-flex justify-content-between align-items-center border rounded-3 p-2 mb-2">
          <div class="d-flex gap-2 align-items-center">
            <img class="cover" src="<?= htmlspecialchars($l['cover_url'] ?? '/images/default-cover.png') ?>" alt="">
            <div>
              <div class="fw-semibold"><?= htmlspecialchars($l['Title'] ?? '') ?></div>
              <div class="text-muted small">Due: <?= htmlspecialchars($l['due_at'] ?? '') ?></div>
            </div>
          </div>

          <form method="post" action="/index.php?route=loan/return">
            <input type="hidden" name="loan_id" value="<?= (int)$l['id'] ?>">
            <button class="btn btn-sm btn-outline-success">Return</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
