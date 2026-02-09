<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Books</h3>
    <a class="btn btn-primary" href="/index.php?route=admin/books/create">+ Add New Book</a>
  </div>

  <form class="d-flex gap-2 mb-3" method="get" action="/index.php">
    <input type="hidden" name="route" value="admin/books">
    <input class="form-control" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Search title/author">
    <button class="btn btn-outline-primary">Search</button>
  </form>

  <div class="card card-soft">
    <div class="table-responsive">
      <table class="table mb-0">
        <thead>
          <tr>
            <th>Book</th><th>Genre</th><th>Year</th><th style="width:220px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (($books ?? []) as $b): ?>
            <tr>
              <td>
                <div class="d-flex gap-2 align-items-center">
                  <?php $src = \App\Framework\Assets::coverSrc($b['cover_url'] ?? ''); ?>
                  <img class="cover" src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars(($b['Title'] ?? 'Book') . ' cover') ?>">
                  <div>
                    <div class="fw-semibold"><?= htmlspecialchars($b['Title'] ?? '') ?></div>
                    <div class="text-muted small"><?= htmlspecialchars($b['author'] ?? '') ?></div>
                  </div>
                </div>
              </td>
              <td><?= htmlspecialchars($b['Genre'] ?? '') ?></td>
              <td><?= htmlspecialchars((string)($b['published_year'] ?? '')) ?></td>
              <td>
                <a class="btn btn-sm btn-secondary" href="/index.php?route=admin/books/edit&id=<?= (int)$b['id'] ?>">Edit</a>
                <a class="btn btn-sm btn-outline-primary" href="/index.php?route=book/detail&id=<?= (int)$b['id'] ?>">View</a>

                <form method="post" action="/index.php?route=admin/books/delete" class="d-inline">
                  <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($books)): ?>
            <tr><td colspan="4" class="text-muted p-4">No books found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
