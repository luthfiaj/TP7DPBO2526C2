<?php
class RoutineLog {
    private $conn;
    private $table_name = "routine_logs";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT l.*, r.title as routine_title, c.name as category_name, c.theme_color 
                  FROM " . $this->table_name . " l 
                  JOIN routines r ON l.routine_id = r.id 
                  JOIN categories c ON r.category_id = c.id 
                  ORDER BY l.log_date DESC, l.id DESC";
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

    public function create($routine_id, $log_date, $status, $notes) {
        $query = "INSERT INTO " . $this->table_name . " (routine_id, log_date, status, notes) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isss", $routine_id, $log_date, $status, $notes);
        return $stmt->execute();
    }

    public function update($id, $routine_id, $log_date, $status, $notes) {
        $query = "UPDATE " . $this->table_name . " SET routine_id = ?, log_date = ?, status = ?, notes = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isssi", $routine_id, $log_date, $status, $notes, $id);
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