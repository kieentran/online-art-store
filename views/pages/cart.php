<?php
// Ensure session is started
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . "/../../lib/models/products.php";

$product_model = new Product();
$cart          = $_SESSION["cart"] ?? [];
$total         = 0;

// Group cart items by product ID to show quantities
$cart_items = [];
foreach ($cart as $id) {
    if (!isset($cart_items[$id])) {
        $cart_items[$id] = 0;
    }
    $cart_items[$id]++;
}
?>

<div class="hero-section">
  <h1 class="hero-title">Your Cart</h1>
  <p class="hero-subtitle">Review your selections</p>
</div>

<?php if (empty($cart)): ?>
  <div class="empty-state">
    <div class="empty-state-icon">🛒</div>
    <h3>Your cart is empty</h3>
    <p>Looks like you haven't added any items yet!</p>
    <br>
    <a href="<?= $baseUrl ?>/products" class="button">Continue Shopping</a>
  </div>
<?php else: ?>
  <table class="cart-table">
    <thead>
      <tr>
        <th>Item</th>
        <th>Artist</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($cart_items as $id => $quantity): ?>
        <?php 
          $p = $product_model->get_by_id((int)$id);
          if ($p):
            $subtotal = $p["Price"] * $quantity;
            $total += $subtotal;
        ?>
          <tr>
            <td>
              <strong><?= htmlspecialchars($p["Description"]) ?></strong>
            </td>
            <td><?= htmlspecialchars($p["Artist"]) ?></td>
            <td>$<?= number_format($p["Price"], 2) ?></td>
            <td><?= $quantity ?></td>
            <td>$<?= number_format($subtotal, 2) ?></td>
            <td>
              <a href="<?= $baseUrl ?>/remove-from-cart/<?= $p['ProductID'] ?>" 
                 style="color: #f56565; text-decoration: none;">Remove 1</a>
            </td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
      <tr>
        <td colspan="4"><strong>Total</strong></td>
        <td class="cart-total">$<?= number_format($total, 2) ?></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  
  <div class="cart-buttons">
    <a href="<?= $baseUrl ?>/products" class="button-secondary">
      ← Continue Shopping
    </a>
    <a href="<?= $baseUrl ?>/order" class="button">
      Proceed to Checkout →
    </a>
  </div>
<?php endif; ?>