<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
      <div class="card card-soft p-4">
        <h3 class="fw-bold mb-3 text-center">Register</h3>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="/index.php?route=register">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" type="email" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" name="password" type="password" required>
          </div>

          <button class="btn btn-primary w-100">Create Account</button>

          <p class="text-muted small mt-3 mb-0 text-center">
            Already have an account? <a href="/index.php?route=login">Login</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
