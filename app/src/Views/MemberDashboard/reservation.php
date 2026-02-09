<?php
use App\Framework\Auth;
\App\Framework\TempData::start();
$user = Auth::user();
?>

<div class="container py-4">
	<h1 class="h3 mb-3">My Reservations</h1>
	<div class="card p-4 text-muted">You have no reservations (demo).</div>
</div>
