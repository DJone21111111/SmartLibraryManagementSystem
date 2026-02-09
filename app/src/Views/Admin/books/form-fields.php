<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input class="form-control" name="Title" required value="<?= htmlspecialchars($book['Title'] ?? '') ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Author</label>
    <input class="form-control" name="author" required value="<?= htmlspecialchars($book['author'] ?? '') ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label">ISBN</label>
    <input class="form-control" name="ISBN" value="<?= htmlspecialchars($book['ISBN'] ?? '') ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label">Genre</label>
    <input class="form-control" name="Genre" value="<?= htmlspecialchars($book['Genre'] ?? '') ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label">Published Year</label>
    <input class="form-control" name="published_year" value="<?= htmlspecialchars((string)($book['published_year'] ?? '')) ?>">
  </div>

  <div class="col-12">
    <label class="form-label">Cover URL</label>
    <input class="form-control" name="cover_url" placeholder="Filename or path (e.g. cover_01_xxx.webp or /assets/Uploads/covers/cover_01.webp)" value="<?= htmlspecialchars($book['cover_url'] ?? '') ?>">
    <div class="form-text">If empty, a default cover will be used.</div>
  </div>

  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea class="form-control" name="Description" rows="4"><?= htmlspecialchars($book['Description'] ?? '') ?></textarea>
  </div>
</div>
