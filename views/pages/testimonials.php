<?php
require_once __DIR__ . "/../../lib/models/user.php";
require_once __DIR__ . "/../../lib/models/customer.php";
$thank_you = isset($_GET['submitted']) && $_GET['submitted'] == '1';
$error = $_SESSION['testimonial_error'] ?? null;
unset($_SESSION['testimonial_error']);
$isAdmin = User::isAdmin();
?>

<div class="hero-section">
  <h1 class="hero-title">Customer Love</h1>
  <p class="hero-subtitle">See what our customers are saying about their magical finds</p>
</div>

<?php if ($thank_you): ?>
  <div class="success-message">
    ✨ Thank you! Your testimonial has been submitted and is awaiting review.
  </div>
<?php endif; ?>

<?php if ($error): ?>
  <div style="background: #fee; color: #c33; padding: 20px; border-radius: 15px; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<?php if (!$isAdmin): ?>
<div style="max-width: 600px; margin: 0 auto 60px;">
  <h2 style="text-align: center; margin-bottom: 30px;">Share Your Experience</h2>
  
  <form method="POST" action="<?= $baseUrl ?>/testimonials">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
      <div class="form-group">
        <label>First Name <span style="color: #e53e3e;">*</span></label>
        <input type="text" name="first_name" required placeholder="Your first name">
      </div>
      
      <div class="form-group">
        <label>Last Name <span style="color: #e53e3e;">*</span></label>
        <input type="text" name="last_name" required placeholder="Your last name">
      </div>
    </div>
    
    <div class="form-group">
      <label>Email Address <span style="color: #e53e3e;">*</span></label>
      <input type="email" name="email" required placeholder="your@email.com">
      <small style="color: #666; font-size: 12px;">Your email will not be displayed publicly</small>
    </div>

    <div class="form-group">
      <label>Your Testimonial <span style="color: #e53e3e;">*</span></label>
      <textarea name="content" rows="4" required placeholder="Tell us about your experience with Darwin Art Store..."></textarea>
    </div>

    <div style="text-align: center;">
      <button type="submit">Submit Testimonial</button>
    </div>
  </form>
</div>

<hr style="border: none; border-top: 1px solid #e2e8f0; margin: 60px 0;">
<?php endif; ?>

<h2 style="text-align: center; margin-bottom: 40px;">What Our Customers Say</h2>

<?php if (!$testimonials || $testimonials->num_rows === 0): ?>
  <div class="empty-state">
    <div class="empty-state-icon">💬</div>
    <p>No testimonials yet. Be the first to share your experience!</p>
  </div>
<?php else: ?>
  <div style="max-width: 800px; margin: 0 auto;">
    <?php while ($t = $testimonials->fetch_assoc()): ?>
      <div class="testimonial-card">
        <p class="testimonial-content">
          <?= nl2br(htmlspecialchars($t['Content'])) ?>
        </p>
        <div class="testimonial-author">
          <?php 
            // Get customer name from database
            $C = new Customer();
            $customer = $C->find_by_email($t['CustEmail']);
            $displayName = $customer ? htmlspecialchars($customer['CustFName'] . ' ' . $customer['CustLName']) : 'Anonymous';
          ?>
          — <?= $displayName ?> 
          <br>
          <small><?= date('F j, Y', strtotime($t['DatePosted'])) ?></small>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php endif; ?>