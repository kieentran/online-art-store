<?php
require_once "database.php";

class Order extends Database {
  public function create($email, $cart) {
    $conn = $this->get_connection();

    // Insert into Purchase
    $today = date("Y-m-d");
    $stmt = $conn->prepare("INSERT INTO Purchase (DateOrdered, CustEmail) VALUES (?, ?)");
    $stmt->bind_param("ss", $today, $email);
    if (!$stmt->execute()) {
      return false;
    }

    $purchaseNo = $conn->insert_id;

    // Insert items
    $item_stmt = $conn->prepare("INSERT INTO PurchaseItem (PurchaseNo, ProductID, Quantity) VALUES (?, ?, ?)");
    foreach ($cart as $productID) {
      $qty = 1; // later: support quantities
      $item_stmt->bind_param("iii", $purchaseNo, $productID, $qty);
      $item_stmt->execute();
    }

    return $purchaseNo;
  }
}
?>
