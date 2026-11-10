<?php
class Routine {
    private $conn;
    private $table_name = "routines";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT r.*, c.name as category_name, c.theme_color 
                  FROM " . $this->table_name . " r 
                  JOIN categories c ON r.category_id = c.id 
                  ORDER BY r.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function readByCategory($category_id) {
        $query = "SELECT r.*, c.name as category_name 
                  FROM " . $this->table_name . " r 
                  JOIN categories c ON r.category_id = c.id 
                  WHERE r.category_id = ? 
                  ORDER BY r.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($category_id, $title, $description, $day_of_week, $target_duration_minutes) {
        $query = "INSERT INTO " . $this->table_name . " (category_id, title, description, day_of_week, target_duration_minutes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isssi", $category_id, $title, $description, $day_of_week, $target_duration_minutes);
        return $stmt->execute();
    }

    public function update($id, $category_id, $title, $description, $day_of_week, $target_duration_minutes) {
        $query = "UPDATE " . $this->table_name . " SET category_id = ?, title = ?, description = ?, day_of_week = ?, target_duration_minutes = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isssii", $category_id, $title, $description, $day_of_week, $target_duration_minutes, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>