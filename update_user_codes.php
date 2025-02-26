<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    // First, add the user_code column if it doesn't exist
    $db->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS user_code VARCHAR(6) UNIQUE");
    
    // Get all users without user_code
    $query = "SELECT id FROM users WHERE user_code IS NULL OR user_code = ''";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Generate 6-digit code padded with zeros
        $user_code = str_pad($row['id'], 6, '0', STR_PAD_LEFT);
        
        // Update user with new code
        $update = "UPDATE users SET user_code = ? WHERE id = ?";
        $updateStmt = $db->prepare($update);
        $updateStmt->execute([$user_code, $row['id']]);
    }
    
    echo "Successfully updated user codes!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>