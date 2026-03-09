<?php
// Get saved form data if validation failed
$old = $_SESSION['order_data'] ?? $_POST;
$error = $_SESSION['order_error'] ?? null;
unset($_SESSION['order_data']);
unset($_SESSION['order_error']);

// Calculate cart total
require_once __DIR__ . "/../../lib/models/products.php";
$product_model = new Product();
$cart = $_SESSION["cart"] ?? [];
$total = 0;

// Group cart items by product ID
$cart_items = [];
foreach ($cart as $id) {
    if (!isset($cart_items[$id])) { 
        $cart_items[$id] = 0;
    }
    $cart_items[$id]++;
}

// Calculate total
foreach ($cart_items as $id => $quantity) {
    $p = $product_model->get_by_id((int)$id);
    if ($p) {
        $total += $p["Price"] * $quantity;
    }
}

// Redirect to cart if empty
if (empty($cart)) {
    header("Location: " . $baseUrl . "/cart");
    exit;
}
?>

<div class="hero-section">
  <h1 class="hero-title">Checkout</h1>
  <p class="hero-subtitle">Just a few details and your items will be on their way!</p>
</div>

<?php if ($error): ?>
  <div style="background: #fee; color: #c33; padding: 20px; border-radius: 15px; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<form method="post" action="<?= $baseUrl ?>/order" style="max-width: 600px; margin: 0 auto;">
  <div style="background: #f7fafc; padding: 30px; border-radius: 20px; margin-bottom: 30px;">
    <h3 style="margin-bottom: 20px;">Personal Information</h3>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <div class="form-group">
        <label>First Name <span style="color: #e53e3e;">*</span></label>
        <input type="text" name="first_name" required
               value="<?= htmlspecialchars($old['first_name'] ?? "") ?>">
      </div>
      
      <div class="form-group">
        <label>Last Name <span style="color: #e53e3e;">*</span></label>
        <input type="text" name="last_name" required
               value="<?= htmlspecialchars($old['last_name'] ?? "") ?>">
      </div>
    </div>
    
    <div class="form-group">
      <label>Email Address <span style="color: #e53e3e;">*</span></label>
      <input type="email" name="email" required
             value="<?= htmlspecialchars($old['email'] ?? "") ?>"
             pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
             title="Please enter a valid email address">
      <small style="color: #666; font-size: 12px;">Order confirmation will be sent to this email</small>
    </div>
    
    <div class="form-group">
      <label>Phone Number</label>
      <input type="text" name="phone"
             value="<?= htmlspecialchars($old['phone'] ?? "") ?>"
             placeholder="Optional">
    </div>
  </div>
  
  <div style="background: #f7fafc; padding: 30px; border-radius: 20px;">
    <h3 style="margin-bottom: 20px;">Shipping Address</h3>
    
    <div class="form-group">
      <label>Address <span style="color: #e53e3e;">*</span></label>
      <textarea name="address" rows="3" required placeholder="Street address, apartment, suite, etc."><?= htmlspecialchars($old['address'] ?? "") ?></textarea>
    </div>
    
    <div class="form-group">
      <label>State <span style="color: #e53e3e;">*</span></label>
      <select name="state" required>
        <option value="">Select State</option>
        <option value="New South Wales" <?= (isset($old['state']) && $old['state'] == 'New South Wales') ? 'selected' : '' ?>>New South Wales</option>
        <option value="Victoria" <?= (isset($old['state']) && $old['state'] == 'Victoria') ? 'selected' : '' ?>>Victoria</option>
        <option value="Queensland" <?= (isset($old['state']) && $old['state'] == 'Queensland') ? 'selected' : '' ?>>Queensland</option>
        <option value="South Australia" <?= (isset($old['state']) && $old['state'] == 'South Australia') ? 'selected' : '' ?>>South Australia</option>
        <option value="Western Australia" <?= (isset($old['state']) && $old['state'] == 'Western Australia') ? 'selected' : '' ?>>Western Australia</option>
        <option value="Tasmania" <?= (isset($old['state']) && $old['state'] == 'Tasmania') ? 'selected' : '' ?>>Tasmania</option>
        <option value="Northern Territory" <?= (isset($old['state']) && $old['state'] == 'Northern Territory') ? 'selected' : '' ?>>Northern Territory</option>
        <option value="Australian Capital Territory" <?= (isset($old['state']) && $old['state'] == 'Australian Capital Territory') ? 'selected' : '' ?>>Australian Capital Territory</option>
      </select>
    </div>
    
    <div class="form-group">
      <label>Postcode <span style="color: #e53e3e;">*</span></label>
      <input type="text" name="postcode" required
             value="<?= htmlspecialchars($old['postcode'] ?? "") ?>"
             placeholder="Enter your postcode"
             pattern="[0-9]{4}"
             title="Please enter a valid 4-digit postcode">
    </div>
  </div>
  
  <div class="cart-buttons">
    <a href="<?= $baseUrl ?>/products" class="button-secondary">
      Continue Shopping
    </a>
    <button type="submit" style="padding: 18px 50px; font-size: 16px;">
      Complete Order - $<?= number_format($total, 2) ?>
    </button>
  </div>
</form>