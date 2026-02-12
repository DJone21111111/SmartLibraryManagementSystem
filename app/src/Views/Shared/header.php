<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Library') ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/site.css">
  <link rel="stylesheet" href="/css/auth.css">
  <link rel="stylesheet" href="/css/catalog.css">
</head>
<body>

<main>
  <?php if (!empty($flash)): ?>
    <div class="container mt-3">
      <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?>"><?= htmlspecialchars($flash['message'] ?? '') ?></div>
      <div data-flash data-flash-message="<?= htmlspecialchars($flash['message'] ?? '') ?>" data-flash-type="<?= htmlspecialchars($flash['type'] ?? 'info') ?>" style="display:none"></div>
    </div>
  <?php endif; ?>
