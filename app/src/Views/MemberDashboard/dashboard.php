<?php
use App\Framework\Auth;
\App\Framework\TempData::start();
$user = Auth::user();
// Ensure we display the user's full name when available. If session lacks name, try loading from DB and persist.
if (!empty($user['id']) && empty($user['name'])) {
	try {
		$repo = new \App\Repository\UserRepository();
		$dbu = $repo->findById((int)$user['id']);
		if ($dbu && !empty($dbu['name'])) {
			$user['name'] = $dbu['name'];
			\App\Framework\Auth::login($user);
		}
	} catch (\Throwable $ex) {
		// ignore lookup errors in the view
	}
}

// Prepare display name: prefer full name, fallback to local-part of email
$displayName = $user['name'] ?? null;
if (empty($displayName) && !empty($user['email'])) {
	$displayName = strtok($user['email'], '@');
}
?>

<div class="container py-4">
	<div class="page-header mb-3">
		<h1 class="display-5">Welcome, <?= htmlspecialchars($displayName ?? ($user['email'] ?? 'Member')) ?>!</h1>
		<p class="lead text-muted">Browse our collection and find your next great read.</p>
	</div>

	<div class="mb-3">
		<a class="btn btn-outline-primary me-2" href="/dashboard/loans">My loans</a>
		<a class="btn btn-outline-secondary" href="/dashboard/reservation">My reservations</a>
	</div>
</div>

<?php
// When embedding the catalog we suppress its own header and outer container
$suppressCatalogHeader = true;
$suppressCatalogContainer = true;

// Embed the catalog below the welcome card. The controller provides `books`, `q`, and `filter`.
// Include the Books index view so the dashboard shows the same catalog UI.
try {
	$catalogPath = __DIR__ . '/../Books/index.php';
	if (file_exists($catalogPath)) {
		include $catalogPath;
	}
} catch (\Throwable $ex) {
	// If include fails, show a simple link to the catalog
	echo '<div class="container py-4"><div class="alert alert-warning">Could not load catalog. <a href="/catalog">Open Catalog</a></div></div>';
}

