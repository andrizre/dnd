<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'layouts/header.php';
?>

<div class="min-h-screen flex flex-col items-center justify-center">
    <div class="text-center mb-8">
        <h1 class="text-5xl font-bold text-red-500 mb-4">Welcome to Dungeon RPG</h1>
        <p class="text-xl text-gray-300">Embark on an epic journey through dangerous dungeons!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl">
        <!-- Features -->
        <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Features</h2>
            <ul class="space-y-2">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Create your unique character
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Battle fearsome monsters
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Complete epic quests
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Earn gold and experience
                </li>
            </ul>
        </div>

        <!-- Call to Action -->
        <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Start Your Adventure</h2>
            <p class="mb-6 text-gray-300">Join thousands of players in this exciting world of adventure and glory!</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="space-y-4">
                    <a href="register.php" class="block w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                        Create Account
                    </a>
                    <a href="login.php" class="block w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                        Login
                    </a>
                </div>
            <?php else: ?>
                <a href="game.php" class="block w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                    Continue Adventure
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>