<?php
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>

<div class="hero-section">
  <h1 class="hero-title">Admin Login</h1>
  <p class="hero-subtitle">Access the admin panel</p>
</div>

<div style="max-width: 400px; margin: 0 auto;">
  <?php if ($error): ?>
    <div style="background: #fee; color: #c33; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>
  
  <form method="POST" action="<?= $baseUrl ?>/admin/login">
    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" required placeholder="admin@email.com">
      <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
        Admin email address: admin123@gmail.com
      </small>
    </div>
    
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required placeholder="Enter admin password">
      <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
        Admin password: admin123
      </small>
    </div>
    
    <button type="submit" style="width: 100%;">Login</button>
  </form>
  
  <div style="text-align: center; margin-top: 30px;">
    <a href="<?= $baseUrl ?>/" style="color: #667eea;">← Back to Home</a>
  </div>
</div>