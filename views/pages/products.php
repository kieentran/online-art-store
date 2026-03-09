<div class="hero-section">
  <h1 class="hero-title">Our Artworks</h1>
  <p class="hero-subtitle">Discover beautiful pieces by talented local Darwin artists</p>
</div>

<?php if (!$products || $products->num_rows === 0): ?>
  <div class="empty-state">
    <div class="empty-state-icon">🎨</div>
    <p>No artworks available at the moment. Check back soon!</p>
  </div>
<?php else: ?>
  <div class="products-grid">
    <?php while ($row = $products->fetch_assoc()): ?>
      <div class="product-card">
        <div class="product-image">
          🎨
        </div>
        <h3 class="product-name"><?= htmlspecialchars($row["Description"]) ?></h3>
        <p style="color: #666; font-size: 14px; margin: 8px 0;">by <?= htmlspecialchars($row["Artist"]) ?></p>
        <p class="product-price">$<?= number_format($row["Price"], 2) ?></p>
        <form method="GET" action="<?= $baseUrl ?>/add-to-cart/<?= $row["ProductID"] ?>">
          <button type="submit" class="add-to-cart-btn">Add to Cart</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
<?php endif; ?>