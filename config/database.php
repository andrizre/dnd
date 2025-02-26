<?php
class Database {
    private $host = "localhost";
    private $db_name = "dungeon_rpg";
    private $username = "root";  // Sesuaikan dengan username database Anda
    private $password = "";      // Sesuaikan dengan password database Anda
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>