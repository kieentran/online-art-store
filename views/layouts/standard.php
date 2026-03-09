<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Darwin Art Store - Shop The Charm Of Our Art</title>
  <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
  <script src="<?= $baseUrl ?>/assets/js/script.js"></script>
</head>
<body>
  <?php
    require_once __DIR__ . "/../../lib/models/user.php";
    $b = $baseUrl ?? '';
    $isAdmin = User::isAdmin();
    $currentUser = User::current();
  ?>
  
  <div class="main-container">
    <nav>
      <a href="<?= $b ?>/" class="nav-brand">Darwin Art Store</a>
      
      <div class="nav-links">
        <a href="<?= $b ?>/">Home</a>
        <a href="<?= $b ?>/products">Products</a>
        <a href="<?= $baseUrl ?>/testimonials" class="nav-link">Testimonials</a>
        <?php if ($isAdmin): ?>
          <a href="<?= $baseUrl ?>/admin/news" class="nav-link">Manage News</a>
          <a href="<?= $baseUrl ?>/admin/testimonials" class="nav-link">Manage Testimonials</a>
        <?php endif; ?>
        <a href="<?= $b ?>/contact">Contacts</a>
      </div>
      
      <div class="nav-icons">
        <a href="<?= $b ?>/cart">
          <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </a>
        <?php if ($isAdmin): ?>
          <div style="display: flex; align-items: center; gap: 15px;">
            <span style="background: #667eea; color: white; padding: 4px 12px; border-radius: 15px; font-size: 13px; font-weight: 500;">Admin</span>
            <a href="<?= $b ?>/admin/logout" style="color: #666; font-size: 14px; text-decoration: none; hover:color: #333;">Logout</a>
          </div>
        <?php else: ?>
          <a href="<?= $b ?>/admin/login" style="color: #667eea; font-weight: 600;">Admin Login</a>
        <?php endif; ?>
      </div>
    </nav>

    <main>
      <?php include $content; ?>
    </main>
  </div>

  <!-- Decorative artwork -->
  <div class="artwork-decoration"></div>

  <script src="<?= $baseUrl ?>/js/script.js"></script>

</body>
</html>