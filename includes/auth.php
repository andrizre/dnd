<?php
class Auth {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password) {
        // Check if username or email already exists
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            return false;
        }

        // Insert new user
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        if ($stmt->execute([$username, $email, $hashed_password])) {
            $_SESSION['user_id'] = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }

    public function login($username, $password) {
        // Find user by username
        $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Start session and store user data
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                return true;
            }
        }
        
        return false;
    }

    public function logout() {
    // Destroy session
    session_start();
    session_unset();
    session_destroy();
    
    // Redirect to login page
    header('Location: login.php');
    exit;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>