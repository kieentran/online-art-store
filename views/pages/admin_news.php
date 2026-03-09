<?php
// expects $news (mysqli_result) and $baseUrl
require_once __DIR__ . "/../../lib/models/user.php";
?>

<div class="hero-section">
  <h1 class="hero-title">Manage News</h1>
  <p class="hero-subtitle">Create and manage news items for the front page</p>
</div>

<div style="text-align: right; margin-bottom: 30px;">
  <a href="<?= $baseUrl ?>/admin/news/add" class="button">
    <span style="margin-right: 5px;">➕</span> Add News Item
  </a>
</div>

<?php if (isset($_SESSION['news_message'])): ?>
  <div class="success-message">
    <?= htmlspecialchars($_SESSION['news_message']) ?>
  </div>
  <?php unset($_SESSION['news_message']); ?>
<?php endif; ?>

<?php if ($news->num_rows === 0): ?>
  <div class="empty-state">
    <div class="empty-state-icon">📰</div>
    <h3>No news items yet</h3>
    <p>Create your first news item to display on the home page.</p>
  </div>
<?php else: ?>
  <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
    <table class="admin-table" style="width: 100%;">
      <thead>
        <tr>
          <th style="width: 250px;">Title</th>
          <th>Message Preview</th>
          <th style="width: 150px;">Date Posted</th>
          <th style="width: 100px;">Status</th>
          <th style="width: 180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($item = $news->fetch_assoc()): ?>
        <tr>
          <td>
            <strong><?= htmlspecialchars($item['Title']) ?></strong>
            <?php if ($item['IsActive']): ?>
              <span style="display: inline-block; background: #48bb78; color: white; font-size: 11px; padding: 2px 8px; border-radius: 10px; margin-left: 10px;">LIVE</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
              <?= htmlspecialchars(substr($item['Message'], 0, 100)) ?>...
            </div>
          </td>
          <td><?= date('M j, Y', strtotime($item['DatePosted'])) ?></td>
          <td>
            <?php if ($item['IsActive']): ?>
              <span style="color: #48bb78;">✓ Active</span>
            <?php else: ?>
              <span style="color: #718096;">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <div class="admin-actions">
              <a href="<?= $baseUrl ?>/admin/news/edit/<?= $item['NewsID'] ?>" 
                 style="background: #4299e1; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px;">
                ✏️ Edit
              </a>
              <form method="POST"
                    action="<?= $baseUrl ?>/admin/news/toggle/<?= $item['NewsID'] ?>"
                    style="display:inline">
                <button type="submit" 
                        style="background: <?= $item['IsActive'] ? '#f56565' : '#48bb78' ?>; 
                               color: white; 
                               padding: 6px 12px; 
                               border-radius: 6px; 
                               border: none; 
                               cursor: pointer; 
                               font-size: 13px;">
                  <?= $item['IsActive'] ? '🚫 Deactivate' : '✓ Activate' ?>
                </button>
              </form>
              <form method="POST"
                    action="<?= $baseUrl ?>/admin/news/delete/<?= $item['NewsID'] ?>"
                    style="display:inline"
                    onsubmit="return confirm('Are you sure you want to delete this news item?');">
                <button type="submit" class="btn-reject" style="padding: 6px 12px; font-size: 13px;">
                  🗑️ Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<div style="margin-top: 40px; text-align: center;">  <a href="<?= $baseUrl ?>/" class="button-secondary" style="margin-left: 10px;">Back to Home</a>
</div>
