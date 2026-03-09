<?php
require_once "database.php";

class Testimonial extends Database {
  /** Get all un-approved (pending) testimonials */
  public function get_pending() {
    return $this->get_connection()
                ->query("SELECT * FROM testimonial WHERE Status = 0 ORDER BY DatePosted DESC");
  }

  /** Get all approved testimonials */
  public function get_approved() {
    return $this->get_connection()
                ->query("SELECT * FROM testimonial WHERE Status = 1 ORDER BY DatePosted DESC");
  }

  /** Insert a new testimonial with Status=0 (pending) */
  public function create(string $email, string $content): bool {
    $conn = $this->get_connection();
    
    // First, ensure the customer exists (to avoid foreign key constraint error)
    $check = $conn->prepare("SELECT CustEmail FROM customer WHERE CustEmail = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();
    
    // If customer doesn't exist, create a basic customer record
    if ($result->num_rows === 0) {
      $insert_customer = $conn->prepare("INSERT INTO customer (CustEmail, CustFName, CustLName) VALUES (?, 'Guest', 'User')");
      $insert_customer->bind_param("s", $email);
      $insert_customer->execute();
    }
    
    // Now insert the testimonial
    $stmt = $conn->prepare("INSERT INTO testimonial (CustEmail, Content, DatePosted, Status)
                           VALUES (?, ?, NOW(), 0)");
    $stmt->bind_param("ss", $email, $content);
    return $stmt->execute();
  }

  /** Approve a pending testimonial */
  public function approve(int $id): bool {
    $stmt = $this->get_connection()
                 ->prepare("UPDATE testimonial SET Status = 1 WHERE TestimonialID = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }

  /** Reject a testimonial by deleting it */
  public function reject(int $id): bool {
    $stmt = $this->get_connection()
                 ->prepare("DELETE FROM testimonial WHERE TestimonialID = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}