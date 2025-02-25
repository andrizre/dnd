<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'layouts/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $auth = new Auth($db);
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($auth->login($username, $password)) {
        header('Location: game.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-center mb-8">Login</h1>
        
        <?php if ($error): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium mb-2">Username</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:border-red-500">
            </div>
            
            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Login
            </button>
        </form>
        
        <p class="mt-6 text-center text-sm">
            Don't have an account?
            <a href="register.php" class="text-red-500 hover:text-red-400">Register here</a>
        </p>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>