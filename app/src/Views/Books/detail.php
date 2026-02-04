<?php
use App\Framework\Auth;
$user = Auth::user();
?>

<div class="container py-4">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card card-soft p-3">
        <img class="w-100" style="border-radius:12px; object-fit:cover; height:380px;"
             src="<?= htmlspecialchars($book['cover_url'] ?? '/images/default-cover.png') ?>" alt="">
      </div>
    </div>

    <div class="col-md-8">
      <div class="card card-soft p-4">
        <h2 class="fw-bold mb-1"><?= htmlspecialchars($book['Title'] ?? '') ?></h2>
        <div class="text-muted mb-3"><?= htmlspecialchars($book['author'] ?? '') ?></div>

        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="badge text-bg-light badge-soft"><?= htmlspecialchars($book['Genre'] ?? '') ?></span>
          <span class="badge text-bg-light badge-soft"><?= htmlspecialchars((string)($book['published_year'] ?? '')) ?></span>
          <span class="badge text-bg-light badge-soft">ISBN: <?= htmlspecialchars($book['ISBN'] ?? '') ?></span>
        </div>

        <p class="text-muted"><?= nl2br(htmlspecialchars($book['Description'] ?? '')) ?></p>

        <div class="d-flex gap-2">
          <?php if (!$user): ?>
            <a class="btn btn-primary" href="/index.php?route=login">Login to Borrow/Reserve</a>
          <?php else: ?>
            <form method="post" action="/index.php?route=loan/borrow">
              <input type="hidden" name="book_id" value="<?= (int)$book['id'] ?>">
              <button class="btn btn-success">Borrow</button>
            </form>

            <form method="post" action="/index.php?route=reserve">
              <input type="hidden" name="book_id" value="<?= (int)$book['id'] ?>">
              <button class="btn btn-warning">Reserve</button>
            </form>
          <?php endif; ?>

          <a class="btn btn-outline-secondary" href="/index.php?route=catalog">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
