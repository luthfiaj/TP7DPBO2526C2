<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "db_daily_routine";
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8");
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>