<?php
class Battle {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function generateMonster($playerLevel) {
        // Generate a monster based on player level
        $monster = [
            'name' => $this->getRandomMonsterName(),
            'level' => rand($playerLevel - 1, $playerLevel + 1),
            'health' => rand(80, 120) * $playerLevel,
            'strength' => rand(8, 12) * $playerLevel,
            'defense' => rand(5, 8) * $playerLevel,
            'experience_reward' => rand(20, 30) * $playerLevel,
            'gold_reward' => rand(10, 15) * $playerLevel
        ];
        return $monster;
    }
    
    private function getRandomMonsterName() {
        $monsters = [
            'Goblin', 'Orc', 'Skeleton', 'Zombie', 'Dark Elf',
            'Troll', 'Ogre', 'Werewolf', 'Vampire', 'Dragon Wyrmling'
        ];
        return $monsters[array_rand($monsters)];
    }
    
    public function calculateDamage($attacker, $defender) {
        $baseDamage = $attacker['strength'] - ($defender['defense'] * 0.5);
        $randomFactor = rand(80, 120) / 100; // 0.8 to 1.2 multiplier
        return max(1, round($baseDamage * $randomFactor));
    }
    
    public function processBattle($characterId, $monster) {
        $character = new Character($this->conn);
        $playerData = $character->getCharacterByUserId($characterId);
        
        $battleLog = [];
        $round = 1;
        
        while ($playerData['health'] > 0 && $monster['health'] > 0) {
            // Player attacks
            $playerDamage = $this->calculateDamage($playerData, $monster);
            $monster['health'] -= $playerDamage;
            $battleLog[] = "Round {$round}: You deal {$playerDamage} damage to the {$monster['name']}";
            
            // Monster attacks if still alive
            if ($monster['health'] > 0) {
                $monsterDamage = $this->calculateDamage($monster, $playerData);
                $playerData['health'] -= $monsterDamage;
                $battleLog[] = "Round {$round}: {$monster['name']} deals {$monsterDamage} damage to you";
            }
            
            $round++;
        }
        
        // Determine battle outcome
        $result = [
            'victory' => $playerData['health'] > 0,
            'battleLog' => $battleLog,
            'playerHealthRemaining' => max(0, $playerData['health']),
            'rewards' => [
                'experience' => $monster['experience_reward'],
                'gold' => $monster['gold_reward']
            ]
        ];
        
        // Update character if victorious
        if ($result['victory']) {
            $character->updateExperience($characterId, $monster['experience_reward']);
            $character->updateGold($characterId, $monster['gold_reward']);
        }
        
        return $result;
    }
}

// Handle AJAX requests
if(isset($_POST['action'])) {
    require_once '../config/database.php';
    require_once 'character.php';
    session_start();
    
    $database = new Database();
    $db = $database->getConnection();
    $battle = new Battle($db);
    
    switch($_POST['action']) {
        case 'startBattle':
            $character = new Character($db);
            $playerData = $character->getCharacterByUserId($_SESSION['user_id']);
            $monster = $battle->generateMonster($playerData['level']);
            echo json_encode($monster);
            break;
            
        case 'processBattle':
            $result = $battle->processBattle($_SESSION['user_id'], $_POST['monster']);
            echo json_encode($result);
            break;
    }
}
?>