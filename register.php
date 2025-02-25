<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/character.php';
require_once 'layouts/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $auth = new Auth($db);
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $character_name = $_POST['character_name'];
    
    // Validate password match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        try {
            // Register user
            if ($auth->register($username, $email, $password)) {
                // Create character
                $character = new Character($db);
                if ($character->createCharacter($_SESSION['user_id'], $character_name)) {
                    $success = 'Registration successful! You can now login.';
                    header('Refresh: 3; URL=login.php');
                } else {
                    $error = 'Error creating character';
                }
            } else {
                $error = 'Username or email already exists';
            }
        } catch (Exception $e) {
            $error = 'An error occurred during registration';
        }
    }
}
?>

<div class="min-h-screen flex items-center justify-center py-12">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-center mb-8">Register</h1>
        
        <?php if ($error): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium mb-2">Username</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label for="confirm_password" class="block text-sm font-medium mb-2">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label for="character_name" class="block text-sm font-medium mb-2">Character Name</label>
                <input type="text" id="character_name" name="character_name" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Register
            </button>
        </form>
        
        <p class="mt-6 text-center text-sm">
            Already have an account?
            <a href="login.php" class="text-red-500 hover:text-red-400">Login here</a>
        </p>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>