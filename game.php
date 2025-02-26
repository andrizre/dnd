<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/character.php';
require_once 'layouts/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ensure user_code exists
if (!isset($_SESSION['user_code'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    // Generate and save user_code if not exists
    $user_code = str_pad($_SESSION['user_id'], 6, '0', STR_PAD_LEFT);
    $query = "UPDATE users SET user_code = ? WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$user_code, $_SESSION['user_id']]);
    
    $_SESSION['user_code'] = $user_code;
}

$database = new Database();
$db = $database->getConnection();
$character = new Character($db);
$player_data = $character->getCharacterByUserId($_SESSION['user_id']);

// If character doesn't exist, redirect to character creation
if (!$player_data) {
    header('Location: create_character.php');
    exit;
}
?>

<!-- Navigation Bar -->
<nav class="bg-gray-900 p-4 mb-6">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white font-bold text-xl">DnD Game</div>
        <div class="flex items-center space-x-4">
            <a href="profile.php" class="text-white hover:text-gray-300">
                <?php echo htmlspecialchars($_SESSION['username']); ?> 
                (<?php echo htmlspecialchars($_SESSION['user_code']); ?>)
            </a>
            <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Logout
            </a>
        </div>
    </div>
</nav>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
    <!-- Character Stats -->
    <div class="bg-gray-800 p-6 rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Character Stats</h2>
        <a href="profile.php" class="text-sm text-blue-400 hover:text-blue-300">View Profile</a>
    </div>
    <div class="space-y-2">
        <p>Name: <span id="char-name"><?php echo htmlspecialchars($player_data['name']); ?></span></p>
        <p class="text-sm text-gray-400">Player: <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['user_code']); ?>)</p>
            <p>Level: <span id="char-level"><?php echo $player_data['level']; ?></span></p>
            <p>Health: <span id="char-health"><?php echo $player_data['health']; ?>/<?php echo $player_data['max_health']; ?></span></p>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
                <div class="bg-red-600 h-2.5 rounded-full" style="width: <?php echo ($player_data['health']/$player_data['max_health']*100); ?>%"></div>
            </div>
            <p>Experience: <span id="char-exp"><?php echo $player_data['experience']; ?></span></p>
            <p>Gold: <span id="char-gold"><?php echo $player_data['gold'] ?? 0; ?></span></p>
        </div>
    </div>

    <!-- Main Game Area -->
    <div class="bg-gray-800 p-6 rounded-lg md:col-span-2">
        <h2 class="text-xl font-bold mb-4">Current Location</h2>
        <div id="game-area" class="min-h-[300px]">
            <p>You are in the town square. Choose your next action:</p>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <button onclick="startQuest()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Start Quest
                </button>
                <button onclick="enterDungeon()" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Enter Dungeon
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add game.js -->
<script>
function startQuest() {
    alert('Quest system coming soon!');
}

function enterDungeon() {
    alert('Dungeon system coming soon!');
}
</script>

<?php require_once 'layouts/footer.php'; ?>