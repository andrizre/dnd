$(document).ready(function() {
    // Game initialization
    updateStats();
});

function updateStats() {
    // Fetch latest character stats from server
    $.ajax({
        url: 'includes/character.php',
        method: 'GET',
        data: { action: 'getStats' },
        success: function(response) {
            const stats = JSON.parse(response);
            $('#char-level').text(stats.level);
            $('#char-health').text(`${stats.health}/${stats.max_health}`);
            updateHealthBar(stats.health, stats.max_health);
        }
    });
}

function startQuest() {
    $.ajax({
        url: 'includes/quest.php',
        method: 'POST',
        data: { action: 'startQuest' },
        success: function(response) {
            const quest = JSON.parse(response);
            $('#game-area').html(`
                <h3 class="text-xl mb-4">${quest.title}</h3>
                <p class="mb-4">${quest.description}</p>
                <button onclick="completeQuest(${quest.id})" 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Complete Quest
                </button>
            `);
        }
    });
}

function enterDungeon() {
    $('#game-area').html(`
        <h3 class="text-xl mb-4">Dungeon Entrance</h3>
        <p class="mb-4">You've entered a dark dungeon. Strange noises echo from within...</p>
        <div class="grid grid-cols-2 gap-4">
            <button onclick="exploreDungeon()" 
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Explore Deeper
            </button>
            <button onclick="returnToTown()" 
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Return to Town
            </button>
        </div>
    `);
}

function updateHealthBar(current, max) {
    const percentage = (current / max) * 100;
    $('.bg-red-600').css('width', `${percentage}%`);
}

// Add more game functions as needed