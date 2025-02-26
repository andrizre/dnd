<?php
class Character {
    private $conn;
    private $table_name = "characters";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createCharacter($user_id, $character_name) {
        // Insert new character
        $query = "INSERT INTO " . $this->table_name . " 
                 (user_id, name, level, experience, health, max_health, gold) 
                 VALUES (?, ?, 1, 0, 100, 100, 0)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id, $character_name]);
    }

    public function getCharacterByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return null;
    }

    public function updateCharacter($character_id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $character_id;
        
        $query = "UPDATE " . $this->table_name . " SET " . implode(", ", $fields) . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute($values);
    }
}
?>