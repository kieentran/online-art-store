<?php
$orderNo = $_SESSION["last_order_no"] ?? null;
$email_sent = $_SESSION["email_sent"] ?? null;
$email_error = $_SESSION["email_error"] ?? null;
$customer_email = $_SESSION["customer_email"] ?? '';
unset($_SESSION["email_sent"]);
unset($_SESSION["email_error"]);
unset($_SESSION["customer_email"]);
?>

<div class="hero-section">
  <h1 class="hero-title">Order Received! 📦</h1>
  <p class="hero-subtitle">We've received your order and it's being processed</p>
</div>

<div style="max-width: 800px; margin: 0 auto;">
  <?php if (!empty($orderNo)): ?>
    <!-- Order Success Box -->
    <div style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); 
                padding: 40px; 
                border-radius: 20px; 
                text-align: center; 
                color: #1a5c3a; 
                margin-bottom: 30px; 
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
      <h2 style="margin-bottom: 10px; font-size: 28px;">Order Successfully Placed!</h2>
      <p style="font-size: 18px;">Order Number: <strong>#<?= htmlspecialchars($orderNo) ?></strong></p>
    </div>

    <!-- Email Status Box -->
    <?php if ($email_sent): ?>
      <div style="padding: 30px; 
                  border-radius: 20px; 
                  margin-bottom: 30px; 
                  text-align: center; 
                  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                  background: #d4edda;
                  border: 1px solid #c3e6cb;
                  color: #155724;">
        <div style="font-size: 48px; margin-bottom: 15px;">✅</div>
        <h3 style="margin-bottom: 10px; font-size: 22px;">Email Sent Successfully</h3>
        <p>We've sent an order confirmation to: <strong><?= htmlspecialchars($customer_email) ?></strong></p>
        <p style="font-size: 14px; margin-top: 10px; opacity: 0.8;">Please check your inbox (and spam folder) for your order details.</p>
      </div>
    <?php else: ?>
      <div style="padding: 30px; 
                  border-radius: 20px; 
                  margin-bottom: 30px; 
                  text-align: center; 
                  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                  background: #fff3cd;
                  border: 1px solid #ffeaa7;
                  color: #856404;">
        <div style="font-size: 48px; margin-bottom: 15px;">⚠️</div>
        <h3 style="margin-bottom: 10px; font-size: 22px;">Email Delivery Issue</h3>
        <p>We couldn't send the confirmation email to: <strong><?= htmlspecialchars($customer_email) ?></strong></p>
        <p style="font-size: 14px; margin-top: 10px; opacity: 0.8;">Don't worry - your order has been processed successfully!</p>
      </div>
    <?php endif; ?>

    <!-- File Backup Status -->
    <div style="background: #f8f9fa; 
                padding: 30px; 
                border-radius: 20px; 
                margin-bottom: 30px; 
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
      <h3 style="margin-bottom: 20px; font-size: 20px;">📄 Order Backups Created</h3>
      <div style="display: flex; flex-direction: column; gap: 15px;">
        <div style="display: flex; 
                    align-items: center; 
                    gap: 15px; 
                    padding: 15px; 
                    background: white; 
                    border-radius: 10px; 
                    border: 1px solid #e2e8f0;">
          <span style="font-size: 24px;">📧</span>
          <div>
            <strong>Customer Copy:</strong>
            <span style="display: block; 
                         font-family: monospace; 
                         font-size: 13px; 
                         color: #666; 
                         margin-top: 2px;">mail_to_customer_<?= $orderNo ?>.html</span>
          </div>
        </div>
        <div style="display: flex; 
                    align-items: center; 
                    gap: 15px; 
                    padding: 15px; 
                    background: white; 
                    border-radius: 10px; 
                    border: 1px solid #e2e8f0;">
          <span style="font-size: 24px;">📋</span>
          <div>
            <strong>Store Copy:</strong>
            <span style="display: block; 
                         font-family: monospace; 
                         font-size: 13px; 
                         color: #666; 
                         margin-top: 2px;">mail_to_store_<?= $orderNo ?>.txt</span>
          </div>
        </div>
      </div>
    </div>

    <!-- What's Next Section -->
    <div style="background: #f7fafc; 
                padding: 30px; 
                border-radius: 20px; 
                margin-bottom: 30px;">
      <h3 style="margin-bottom: 15px; font-size: 20px;">What's Next?</h3>
      <ol style="padding-left: 20px;">
        <li style="margin-bottom: 10px; line-height: 1.8;">Your order is being prepared for shipment</li>
        <li style="margin-bottom: 10px; line-height: 1.8;">You'll receive tracking information once shipped</li>
        <li style="margin-bottom: 10px; line-height: 1.8;">Delivery typically takes 3-5 business days</li>
      </ol>
    </div>

    <!-- Decorative Icons -->
    <div style="text-align: center; font-size: 60px; margin: 40px 0;">
      <span style="margin: 0 10px;">🎨</span>
      <span style="margin: 0 10px;">📦</span>
      <span style="margin: 0 10px;">🚚</span>
    </div>

  <?php else: ?>
    <div class="empty-state">
      <p>No order information available.</p>
    </div>
  <?php endif; ?>

  <!-- Action Buttons -->
  <div style="display: flex; 
              justify-content: center; 
              gap: 20px; 
              margin-top: 40px;">
    <a href="<?= $baseUrl ?>/products" class="button">Continue Shopping</a>
    <a href="<?= $baseUrl ?>/" class="button-secondary">Back to Home</a>
  </div>
</div>