<div class="container py-4">
  <h3 class="mb-3">Edit Book</h3>

  <div class="card card-soft p-4">
    <form method="post" action="/index.php?route=admin/books/edit&id=<?= (int)($book['id'] ?? 0) ?>">
      <?php include __DIR__ . '/form-fields.php'; ?>
      <button class="btn btn-primary">Save Changes</button>
      <a class="btn btn-outline-secondary" href="/index.php?route=admin/books">Cancel</a>
    </form>
  </div>
</div>
