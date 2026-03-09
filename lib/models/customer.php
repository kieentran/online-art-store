<?php
require_once __DIR__ . "/database.php";

class Customer extends Database {
  /**
   * Look up a customer by email.
   * Returns associative array or null.
   */
  public function find_by_email(string $email): ?array {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      SELECT * 
        FROM customer 
       WHERE CustEmail = ?
      LIMIT 1
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc() ?: null;
  }

  /**
   * Insert a brand-new customer.
   * Returns the email (primary key).
   */
  public function create(array $data): string {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      INSERT INTO customer
        (CustEmail, CustFName, CustLName, Phone, Address, State, PostCode)
      VALUES
        (?,        ?,          ?,         ?,     ?,       ?,     ?)
    ");
    $stmt->bind_param(
      "sssssss",
      $data['email'],
      $data['first_name'],
      $data['last_name'],
      $data['phone'],
      $data['address'],
      $data['state'],
      $data['postcode']
    );
    $stmt->execute();
    return $data['email'];
  }
}