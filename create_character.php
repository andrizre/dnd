<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/character.php';
require_once 'layouts/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $character = new Character($db);
    
    $character_name = $_POST['character_name'];
    
    if ($character->createCharacter($_SESSION['user_id'], $character_name)) {
        header('Location: game.php');
        exit;
    } else {
        $error = 'Error creating character';
    }
}
?>

<div class="min-h-screen flex items-center justify-center py-12">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-center mb-8">Create Your Character</h1>
        
        <?php if ($error): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-6">
            <div>
                <label for="character_name" class="block text-sm font-medium mb-2">Character Name</label>
                <input type="text" id="character_name" name="character_name" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Create Character
            </button>
        </form>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>