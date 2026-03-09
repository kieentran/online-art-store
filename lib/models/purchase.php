<?php
require_once __DIR__ . "/database.php";

class Purchase extends Database {
  /**
   * Create a new purchase record.
   * Returns the new auto-increment PurchaseNo.
   */
  public function create(string $custEmail): int {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      INSERT INTO purchase 
        (DateOrdered, CustEmail)
      VALUES
        (NOW(),       ?)
    ");
    $stmt->bind_param("s", $custEmail);
    $stmt->execute();
    return $conn->insert_id;
  }
}
