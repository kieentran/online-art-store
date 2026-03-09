<?php
class Database {
  protected static $connection;

  public function __construct() {
    if (!self::$connection) {
      self::$connection = new mysqli("localhost", "root", "", "art_store_db");
      if (self::$connection->connect_error) {
        die("Connection failed: " . self::$connection->connect_error);
      }
    }
  }

  public function get_connection() {
    return self::$connection;
  }
}
?>
