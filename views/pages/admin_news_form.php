<?php
// expects $news (array or null for edit), $baseUrl, $isEdit (bool)
$title = $isEdit ? 'Edit News Item' : 'Add News Item';
$buttonText = $isEdit ? 'Update News' : 'Publish News';
?>

<div class="hero-section">
  <h1 class="hero-title"><?= $title ?></h1>
  <p class="hero-subtitle"><?= $isEdit ? 'Update your news item' : 'Create a new announcement for the home page' ?></p>
</div>

<div style="max-width: 800px; margin: 0 auto;">
  <?php if (isset($_SESSION['news_error'])): ?>
    <div style="background: #fee; color: #c33; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
      <?= htmlspecialchars($_SESSION['news_error']) ?>
    </div>
    <?php unset($_SESSION['news_error']); ?>
  <?php endif; ?>
  
  <form method="POST" action="<?= $baseUrl ?>/admin/news/<?= $isEdit ? 'edit/' . $news['NewsID'] : 'add' ?>">
    <div class="form-group">
      <label>News Title <span style="color: #e53e3e;">*</span></label>
      <input type="text" 
             name="title" 
             required 
             placeholder="e.g., New Exhibition Opening Soon!"
             value="<?= $isEdit ? htmlspecialchars($news['Title']) : '' ?>"
             maxlength="200">
      <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
        Keep it short and attention-grabbing (max 200 characters)
      </small>
    </div>
    
    <div class="form-group">
      <label>Message Content <span style="color: #e53e3e;">*</span></label>
      <textarea name="message" 
                required 
                rows="8" 
                placeholder="Write your news announcement here..."
                style="resize: vertical;"><?= $isEdit ? htmlspecialchars($news['Message']) : '' ?></textarea>
      <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
        This will appear on the home page. You can include details about exhibitions, new artists, special events, or any company updates.
      </small>
    </div>
    
    <div class="form-group">
      <label style="display: flex; align-items: center; cursor: pointer;">
        <input type="checkbox" 
               name="is_active" 
               value="1"
               style="width: auto; margin-right: 10px;"
               <?= ($isEdit && $news['IsActive']) || !$isEdit ? 'checked' : '' ?>>
        <span>Publish immediately</span>
      </label>
      <small style="color: #666; font-size: 12px; display: block; margin-top: 5px; margin-left: 30px;">
        Only active news items will be shown on the home page. Uncheck to save as draft.
      </small>
    </div>

    <?php if ($isEdit): ?>
      <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
        <p style="color: #4a5568; font-size: 14px; margin: 0;">
          <strong>Posted on:</strong> <?= date('F j, Y', strtotime($news['DatePosted'])) ?>
        </p>
      </div>
    <?php endif; ?>
    
    <div style="display: flex; gap: 15px; margin-top: 30px;">
      <button type="submit" style="flex: 1;"><?= $buttonText ?></button>
      <a href="<?= $baseUrl ?>/admin/news" class="button-secondary" style="flex: 1; text-align: center;">Cancel</a>
    </div>
  </form>

  <!-- Preview Section -->
  <div style="margin-top: 60px;">
    <h3 style="margin-bottom: 20px;">Preview (How it will look on the home page)</h3>
    <section class="latest-news" id="news-preview">
      <h2>Latest News</h2>
      <h3 id="preview-title"><?= $isEdit ? htmlspecialchars($news['Title']) : 'Your news title will appear here' ?></h3>
      <p id="preview-message"><?= $isEdit ? nl2br(htmlspecialchars($news['Message'])) : 'Your news message will appear here...' ?></p>
      <small>Posted on <?= date('j M Y') ?></small>
    </section>
  </div>
</div>
