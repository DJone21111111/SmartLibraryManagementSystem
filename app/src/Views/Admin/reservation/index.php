<div class="container py-4">
  <h3 class="mb-3">Manage Reservations</h3>

  <div class="card card-soft p-3">
    <?php if (empty($reservations)): ?>
      <div class="text-muted">No reservations.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>Book</th><th>User</th><th>Status</th><th>Created</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservations as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['Title'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['user_id'] ?? '') ?></td>
                <td><span class="badge text-bg-light badge-soft"><?= htmlspecialchars($r['Status'] ?? '') ?></span></td>
                <td><?= htmlspecialchars($r['created_at'] ?? '') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
