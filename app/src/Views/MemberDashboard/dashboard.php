<?php
use App\Framework\Auth;
\App\Framework\TempData::start();
$user = Auth::user();
?>

<div class="container py-4">
	<h1 class="h3 mb-3">Member Dashboard</h1>

	<div class="card p-4">
		<div class="fw-bold">Welcome, <?= htmlspecialchars($user['email'] ?? $user['id'] ?? 'Member') ?></div>
		<p class="mb-0 text-muted">Use the links below to view your loans and reservations.</p>
		<div class="mt-3">
			<a class="btn btn-outline-primary me-2" href="/dashboard/loans">My loans</a>
			<a class="btn btn-outline-secondary" href="/dashboard/reservation">My reservations</a>
		</div>
	</div>
</div>
