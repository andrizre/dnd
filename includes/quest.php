<?php
class Quest {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getAvailableQuests($characterLevel) {
        $query = "SELECT * FROM quests WHERE min_level <= :level ORDER BY min_level ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':level' => $characterLevel]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function startQuest($userId, $questId) {
        $query = "INSERT INTO user_quests (user_id, quest_id) VALUES (:user_id, :quest_id)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':user_id' => $userId,
            ':quest_id' => $questId
        ]);
    }
    
    public function completeQuest($userId, $questId) {
        // Get quest rewards
        $query = "SELECT * FROM quests WHERE id = :quest_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':quest_id' => $questId]);
        $quest = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Update user_quests status
        $query = "UPDATE user_quests SET 
                 status = 'completed',
                 completed_at = NOW()
                 WHERE user_id = :user_id 
                 AND quest_id = :quest_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $userId,
            ':quest_id' => $questId
        ]);
        
        // Award experience and gold
        $character = new Character($this->conn);
        $characterData = $character->getCharacterByUserId($userId);
        $character->updateExperience($characterData['id'], $quest['experience_reward']);
        $character->updateGold($characterData['id'], $quest['gold_reward']);
        
        return [
            'experience' => $quest['experience_reward'],
            'gold' => $quest['gold_reward']
        ];
    }
}

// Handle AJAX requests
if(isset($_POST['action'])) {
    require_once '../config/database.php';
    require_once 'character.php';
    session_start();
    
    $database = new Database();
    $db = $database->getConnection();
    $quest = new Quest($db);
    
    switch($_POST['action']) {
        case 'startQuest':
            $character = new Character($db);
            $playerData = $character->getCharacterByUserId($_SESSION['user_id']);
            $availableQuests = $quest->getAvailableQuests($playerData['level']);
            // Randomly select a quest
            $randomQuest = $availableQuests[array_rand($availableQuests)];
            $quest->startQuest($_SESSION['user_id'], $randomQuest['id']);
            echo json_encode($randomQuest);
            break;
            
        case 'completeQuest':
            $rewards = $quest->completeQuest($_SESSION['user_id'], $_POST['quest_id']);
            echo json_encode($rewards);
            break;
    }
}
?>