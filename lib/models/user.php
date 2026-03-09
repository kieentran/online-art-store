<?php
require_once __DIR__ . "/database.php";

class User extends Database {
  // Authenticate admin user only
  public function login(string $email, string $password): array|false {
    // Only allow admin login
    if ($email !== 'admin123@gmail.com') {
      return false;
    }
    
    $conn = $this->get_connection();
    
    // Check if admin exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      // Verify password
      if (password_verify($password, $user['password'])) {
        return $user;
      }
    }
    
    return false;
  }
  
   // Register admin user only
  public function register(string $email, string $password): bool {
    // Only allow admin registration
    if ($email !== 'admin123@gmail.com') {
      return false;
    }
    
    $conn = $this->get_connection();
    
    // Check if admin already exists
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
      return false; // Admin already exists
    }
    
    // Hash password and insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $is_admin = 1; // Always admin
    
    $stmt = $conn->prepare("INSERT INTO users (email, password, is_admin, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ssi", $email, $hashed_password, $is_admin);
    
    if ($stmt->execute()) {
      // Also ensure customer record exists for admin
      $cust_check = $conn->prepare("SELECT CustEmail FROM customer WHERE CustEmail = ?");
      $cust_check->bind_param("s", $email);
      $cust_check->execute();
      
      if ($cust_check->get_result()->num_rows === 0) {
        $fname = 'Admin';
        $lname = 'Account';
        $insert_customer = $conn->prepare("INSERT INTO customer (CustEmail, CustFName, CustLName) VALUES (?, ?, ?)");
        $insert_customer->bind_param("sss", $email, $fname, $lname);
        $insert_customer->execute();
      }
      
      return true;
    }
    
    return false;
  }
  
  // Check if user is admin
  public static function isAdmin(): bool {
    return isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1;
  }
  
  // Get current user
  public static function current(): ?array {
    return $_SESSION['user'] ?? null;
  }
}