<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/character.php';
require_once 'layouts/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$character = new Character($db);
$player_data = $character->getCharacterByUserId($_SESSION['user_id']);
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Character Stats -->
    <div class="bg-gray-800 p-6 rounded-lg">
        <h2 class="text-xl font-bold mb-4">Character Stats</h2>
        <div class="space-y-2">
            <p>Level: <span id="char-level"><?php echo $player_data['level']; ?></span></p>
            <p>Health: <span id="char-health"><?php echo $player_data['health']; ?>/<?php echo $player_data['max_health']; ?></span></p>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
                <div class="bg-red-600 h-2.5 rounded-full" style="width: <?php echo ($player_data['health']/$player_data['max_health']*100); ?>%"></div>
            </div>
            <p>Experience: <?php echo $player_data['experience']; ?></p>
            <p>Gold: <?php echo $player_data['gold']; ?></p>
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

<script src="/assets/js/game.js"></script>

<?php require_once 'layouts/footer.php'; ?>