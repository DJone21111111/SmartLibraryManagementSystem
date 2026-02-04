<?php if (!empty($flash)): ?>
  <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?> card-soft">
    <?= htmlspecialchars($flash['message'] ?? '') ?>
  </div>
<?php endif; ?>
