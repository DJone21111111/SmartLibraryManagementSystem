<?php
use App\Framework\Auth;
\App\Framework\TempData::start();
$user = Auth::user();
?>

<div class="container py-4">
    <h1 class="h3 mb-3">Account Settings</h1>

    <div class="card p-4">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <div><?= htmlspecialchars($user['name'] ?? '') ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div><?= htmlspecialchars($user['Email'] ?? $user['email'] ?? '') ?></div>
        </div>

        <div class="mt-3">
            <a class="btn btn-primary" href="/profile/edit">Edit Profile</a>
            <a class="btn btn-outline-secondary" href="/change-password">Change Password</a>
        </div>
    </div>
</div>
