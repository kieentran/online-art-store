<?php
require_once "database.php";

class Product extends Database {
  
  // Fetch all products
  public function get_all() {
    $conn = $this->get_connection();
    $query = "SELECT ProductID, Description, Artist, Price FROM products";
    $result = $conn->query($query);

    if (!$result) {
      die("❌ Query failed: " . $conn->error);
    }
    
    return $result;
  }

  // Fetch one product by ID
  public function get_by_id($id) {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("SELECT ProductID, Description, Artist, Price FROM products WHERE ProductID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      return null;
    }

    return $result->fetch_assoc();
  }
}
?>