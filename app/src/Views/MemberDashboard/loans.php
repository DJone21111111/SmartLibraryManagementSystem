<?php
use App\Framework\Auth;
\App\Framework\TempData::start();
$user = Auth::user();
?>

<div class="container py-4">
	<h1 class="h3 mb-3">My Loans</h1>

	<?php
	$loans = $loans ?? [];

	if (empty($loans) && !empty($user['id'])) {
		try {
			$svc = new \App\Services\LoanService();
			$fetched = $svc->getMyLoans((int)$user['id']);
			if (!empty($fetched)) {
				$loans = $fetched;
			}
		} catch (\Throwable $ex) {
		}
	}

	if (empty($loans)):
	?>
		<div class="card p-4 text-muted">You have no active loans.</div>
	<?php else: ?>
		<div class="list-group">
			<?php foreach ($loans as $l):
				$title = $l['Title'] ?? '';
				$author = $l['author'] ?? '';
				$cover = $l['cover_url'] ?? $l['cover'] ?? '';
				if (trim($cover) === '') {
					$coverPath = '/assets/Uploads/covers/default-cover.svg';
				} else {
					$coverPath = preg_match('#(^/|assets/Uploads/)#i', $cover) ? '/' . ltrim($cover, '/') : '/assets/Uploads/covers/' . rawurlencode($cover);
				}
			?>
			<div class="card mb-3 p-3">
				<div class="d-flex">
					<div style="width:72px;flex:0 0 72px;margin-right:12px"><img src="<?= $coverPath ?>" alt="<?= htmlspecialchars($title) ?>" class="img-fluid" onerror="this.onerror=null;this.src='/assets/Uploads/covers/default-cover.svg'"></div>
					<div class="flex-grow-1">
						<div class="fw-bold"><?= htmlspecialchars($title) ?></div>
						<div class="small text-muted">Author: <?= htmlspecialchars($author) ?></div>
						<div class="small text-muted mt-2">Loaned: <?= htmlspecialchars($l['loaned_at'] ?? '') ?> • Due: <?= htmlspecialchars($l['due_at'] ?? '') ?></div>
					</div>
					<div class="text-end">
						<form method="post" action="/loan/return">
							<input type="hidden" name="loan_id" value="<?= (int)($l['id'] ?? 0) ?>">
							<button type="submit" class="btn btn-outline-primary">Return</button>
						</form>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
