<div class="auth-page">
  <div class="auth-grid">
    <div class="auth-hero" style="background-image: url('/assets/Uploads/otherImages/loginImage.jpg')" aria-hidden="true"></div>
    <div class="auth-panel">
      <div class="auth-card">
        <h2 class="auth-title">Reset password</h2>
        <p class="auth-sub">Enter your email and we'll send reset instructions (demo).</p>

        <?php if (!empty($flash)): ?>
          <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?>"><?= htmlspecialchars($flash['message'] ?? '') ?></div>
        <?php endif; ?>

        <form method="post" action="/forgot-password">
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input class="form-control" name="email" type="email" required>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary">Send reset link</button>
            <a href="/login" class="small">Back to login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
