<div class="container py-4">
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h2 class="mb-0">Catalog</h2>

    <form class="d-flex gap-2" method="get" action="/index.php">
      <input type="hidden" name="route" value="catalog">
      <input class="form-control" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Search title or author">
      <button class="btn btn-outline-primary">Search</button>
    </form>
  </div>

  <div class="row g-3">
    <?php foreach (($books ?? []) as $b): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card card-soft h-100">
          <div class="p-3 d-flex gap-3">
            <img class="cover" src="<?= htmlspecialchars($b['cover_url'] ?? '/images/default-cover.png') ?>" alt="">
            <div class="flex-grow-1">
              <div class="fw-semibold"><?= htmlspecialchars($b['Title'] ?? '') ?></div>
              <div class="text-muted small"><?= htmlspecialchars($b['author'] ?? '') ?></div>
              <div class="text-muted small"><?= htmlspecialchars($b['Genre'] ?? '') ?> • <?= htmlspecialchars((string)($b['published_year'] ?? '')) ?></div>
              <div class="mt-2">
                <a class="btn btn-sm btn-primary" href="/index.php?route=book/detail&id=<?= (int)$b['id'] ?>">View</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (empty($books)): ?>
      <div class="col-12">
        <div class="card card-soft p-4 text-muted">No books found.</div>
      </div>
    <?php endif; ?>
  </div>
</div>
