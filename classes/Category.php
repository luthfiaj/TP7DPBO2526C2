<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
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

    public function create($name, $description, $theme_color) {
        $query = "INSERT INTO " . $this->table_name . " (name, description, theme_color) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $name, $description, $theme_color);
        return $stmt->execute();
    }

    public function update($id, $name, $description, $theme_color) {
        $query = "UPDATE " . $this->table_name . " SET name = ?, description = ?, theme_color = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $name, $description, $theme_color, $id);
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