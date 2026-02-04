<div class="container py-4">
  <h3 class="mb-3">Manage Loans</h3>

  <div class="card card-soft p-3">
    <?php if (empty($loans)): ?>
      <div class="text-muted">No active loans.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>User</th><th>Book</th><th>Loaned</th><th>Due</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($loans as $l): ?>
              <tr>
                <td><?= htmlspecialchars($l['user_id'] ?? '') ?></td>
                <td><?= htmlspecialchars($l['Title'] ?? '') ?></td>
                <td><?= htmlspecialchars($l['loaned_at'] ?? '') ?></td>
                <td><?= htmlspecialchars($l['due_at'] ?? '') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
