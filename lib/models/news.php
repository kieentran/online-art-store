<?php
require_once __DIR__ . "/database.php";

class News extends Database {
  /**
   * Fetch the single most‐recent news row.
   * @return array|null
   */
  public function get_latest(): ?array {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      SELECT NewsID, Title, Message, DatePosted
        FROM news
       WHERE IsActive = 1
       ORDER BY DatePosted DESC, NewsID DESC
       LIMIT 1
    ");
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }

  /**
   * Get all news items for admin management
   * @return mysqli_result
   */
  public function get_all() {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      SELECT NewsID, Title, Message, DatePosted, IsActive
        FROM news
       ORDER BY DatePosted DESC
    ");
    $stmt->execute();
    return $stmt->get_result();
  }

  /**
   * Get a specific news item by ID
   * @param int $id
   * @return array|null
   */
  public function get_by_id(int $id): ?array {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      SELECT NewsID, Title, Message, DatePosted, IsActive
        FROM news
       WHERE NewsID = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }

  /**
   * Create a new news item
   * @param string $title
   * @param string $message
   * @param bool $isActive
   * @return int|false Returns the new NewsID or false on failure
   */
  public function create(string $title, string $message, bool $isActive = true) {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      INSERT INTO news (Title, Message, DatePosted, IsActive)
      VALUES (?, ?, NOW(), ?)
    ");
    $active = $isActive ? 1 : 0;
    $stmt->bind_param("ssi", $title, $message, $active);
    
    if ($stmt->execute()) {
      return $conn->insert_id;
    }
    return false;
  }

  /**
   * Update an existing news item
   * @param int $id
   * @param string $title
   * @param string $message
   * @param bool $isActive
   * @return bool
   */
  public function update(int $id, string $title, string $message, bool $isActive): bool {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      UPDATE news
         SET Title = ?, Message = ?, IsActive = ?
       WHERE NewsID = ?
    ");
    $active = $isActive ? 1 : 0;
    $stmt->bind_param("ssii", $title, $message, $active, $id);
    return $stmt->execute();
  }

  /**
   * Delete a news item
   * @param int $id
   * @return bool
   */
  public function delete(int $id): bool {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("DELETE FROM news WHERE NewsID = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }

  /**
   * Toggle the active status of a news item
   * @param int $id
   * @return bool
   */
  public function toggle_active(int $id): bool {
    $conn = $this->get_connection();
    $stmt = $conn->prepare("
      UPDATE news
         SET IsActive = NOT IsActive
       WHERE NewsID = ?
    ");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }

  /**
   * Get count of active news items
   * @return int
   */
  public function count_active(): int {
    $conn = $this->get_connection();
    $result = $conn->query("SELECT COUNT(*) as count FROM news WHERE IsActive = 1");
    $row = $result->fetch_assoc();
    return (int)$row['count'];
  }
}