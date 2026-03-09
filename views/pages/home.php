<div class="hero-section">
  <h1 class="hero-title">
    Welcome to our<br>
    Darwin Online Art Gallery
  </h1>
  <p class="hero-subtitle">
    Explore original paintings, prints, and sculptures by local artists. Find the perfect piece to inspire your home or office.
  </p>
</div>

<?php if (!empty($latest)): ?>
  <section class="latest-news">
    <h2>Latest News</h2>
    <h3><?= htmlspecialchars($latest["Title"]) ?></h3>
    <p><?= nl2br(htmlspecialchars($latest["Message"])) ?></p>
    <small>Posted on <?= date("j M Y", strtotime($latest["DatePosted"])) ?></small>
  </section>
<?php endif; ?>

<div style="text-align: center; margin-top: 60px;">
  <a href="<?= $baseUrl ?>/products" class="button">Browse Artworks</a>
</div>

<!-- Decorative artwork field at bottom -->
<div style="margin-top: 80px; text-align: center; font-size: 40px; opacity: 0.5;">
  🎨 🖼️ 🎭 🗿 🎨 🖼️ 🎭
</div>