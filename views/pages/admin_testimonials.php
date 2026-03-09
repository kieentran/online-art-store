<?php
// expects $pending and $approved (mysqli_result) and $baseUrl
require_once __DIR__ . "/../../lib/models/user.php";
?>

<div class="hero-section">
  <h1 class="hero-title">Manage Testimonials</h1>
  <p class="hero-subtitle">Review and approve customer testimonials</p>
</div>

<h2 style="margin-bottom: 30px;">Pending Testimonials</h2>

<?php if ($pending->num_rows === 0): ?>
  <div class="empty-state" style="margin-bottom: 60px;">
    <div class="empty-state-icon">✅</div>
    <h3>All caught up!</h3>
    <p>No new testimonials awaiting review.</p>
  </div>
<?php else: ?>
  <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 60px;">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Customer Email</th>
          <th>Message</th>
          <th>Date Posted</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = $pending->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['CustEmail']) ?></td>
          <td style="max-width: 300px;"><?= nl2br(htmlspecialchars($row['Content'])) ?></td>
          <td><?= date('M j, Y', strtotime($row['DatePosted'])) ?></td>
          <td>
            <div class="admin-actions">
              <form method="POST"
                    action="<?= $baseUrl ?>/admin/testimonials/approve/<?= $row['TestimonialID'] ?>"
                    style="display:inline">
                <button type="submit" class="btn-approve">✓ Approve</button>
              </form>
              <form method="POST"
                    action="<?= $baseUrl ?>/admin/testimonials/reject/<?= $row['TestimonialID'] ?>"
                    style="display:inline">
                <button type="submit" class="btn-reject">✗ Reject</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<hr style="border: none; border-top: 1px solid #e2e8f0; margin: 60px 0;">

<h2 style="margin-bottom: 30px;">Approved Testimonials</h2>

<?php if ($approved->num_rows === 0): ?>
  <div class="empty-state">
    <div class="empty-state-icon">💬</div>
    <p>No approved testimonials yet.</p>
  </div>
<?php else: ?>
  <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Customer Email</th>
          <th>Message</th>
          <th>Date Posted</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($t = $approved->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($t['CustEmail']) ?></td>
          <td style="max-width: 300px;"><?= nl2br(htmlspecialchars($t['Content'])) ?></td>
          <td><?= date('M j, Y', strtotime($t['DatePosted'])) ?></td>
          <td>
            <div class="admin-actions">
              <form method="POST"
                    action="<?= $baseUrl ?>/admin/testimonials/reject/<?= $t['TestimonialID'] ?>"
                    style="display:inline"
                    onsubmit="return confirm('Are you sure you want to remove this testimonial?');">
                <button type="submit" class="btn-reject">✗ Remove</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<div style="margin-top: 40px; text-align: center;">
  <a href="<?= $baseUrl ?>/" class="button">Back to Home</a>
</div>