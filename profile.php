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
            <span class="text-white">
                <?php echo htmlspecialchars($_SESSION['username']); ?> 
                (<?php echo htmlspecialchars($_SESSION['user_code']); ?>)
            </span>
            <a href="game.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Back to Game
            </a>
            <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-6">Character Profile</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                        <div class="space-y-2">
                            <p><span class="font-medium">Character Name:</span> <?php echo htmlspecialchars($player_data['name']); ?></p>
                            <p><span class="font-medium">Player:</span> <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['user_code']); ?>)</p>
                            <p><span class="font-medium">Level:</span> <?php echo $player_data['level']; ?></p>
                            <p><span class="font-medium">Experience:</span> <?php echo $player_data['experience']; ?></p>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Stats</h2>
                        <div class="space-y-2">
                            <div>
                                <p class="font-medium">Health</p>
                                <div class="w-full bg-gray-600 rounded-full h-2.5">
                                    <div class="bg-red-600 h-2.5 rounded-full" style="width: <?php echo ($player_data['health']/$player_data['max_health']*100); ?>%"></div>
                                </div>
                                <p class="text-sm"><?php echo $player_data['health']; ?>/<?php echo $player_data['max_health']; ?></p>
                            </div>
                            <p><span class="font-medium">Gold:</span> <?php echo $player_data['gold'] ?? 0; ?></p>
                        </div>
                    </div>
                </div>

                <!-- Additional Stats & Progress -->
                <div class="space-y-4">
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Progress</h2>
                        <div class="space-y-2">
                            <p><span class="font-medium">Next Level:</span> <?php echo ($player_data['level'] + 1); ?></p>
                            <div>
                                <p class="font-medium">Experience Progress</p>
                                <div class="w-full bg-gray-600 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>