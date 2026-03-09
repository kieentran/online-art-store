<?php
require_once __DIR__ . "/database.php";

class PurchaseItem extends Database {
  /**
   * Add one item line to a purchase.
   * $productId must match your products.ProductID column.
   */
  public function create(int $purchaseNo, int $productId, int $quantity = 1): void {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      INSERT INTO purchaseitem
        (PurchaseNo, ProductID, Quantity)
      VALUES
        (?,          ?,         ?)
    ");
    $stmt->bind_param("iii", $purchaseNo, $productId, $quantity);
    $stmt->execute();
  }
}
