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
$playerData = $character->getCharacterByUserId($_SESSION['user_id']);
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-6">Character Profile</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Character Stats -->
                    <div>
                        <h2 class="text-xl font-bold mb-4">Stats</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Name:</span>
                                <span class="font-medium"><?php echo htmlspecialchars($playerData['name']); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Level:</span>
                                <span class="font-medium"><?php echo $playerData['level']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Experience:</span>
                                <span class="font-medium"><?php echo $playerData['experience']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Health:</span>
                                <span class="font-medium"><?php echo $playerData['health']; ?>/<?php echo $playerData['max_health']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Strength:</span>
                                <span class="font-medium"><?php echo $playerData['strength']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Defense:</span>
                                <span class="font-medium"><?php echo $playerData['defense']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Gold:</span>
                                <span class="font-medium"><?php echo $playerData['gold']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Character Actions -->
                    <div>
                        <h2 class="text-xl font-bold mb-4">Actions</h2>
                        <div class="space-y-4">
                            <a href="game.php" 
                               class="block w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                                Return to Game
                            </a>
                            <button onclick="restoreHealth()" 
                                    class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Restore Health (100 Gold)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function restoreHealth() {
    if (confirm('Restore health for 100 gold?')) {
        $.ajax({
            url: 'includes/character.php',
            method: 'POST',
            data: {
                action: 'restoreHealth'
            },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
    }
}
</script>

<?php require_once 'layouts/footer.php'; ?>