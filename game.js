<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Casino - Mobile Lobby</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-900 via-indigo-900 to-blue-900 text-white min-h-screen">
    
    <!-- Header -->
    <div class="bg-black/30 backdrop-blur-sm border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                    </svg>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                        Royal Casino
                    </h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-4 py-2 rounded-full font-bold shadow-lg">
                        $<span id="balance">1,000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600 mx-4 mt-4 rounded-2xl shadow-2xl">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative px-6 py-8">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-yellow-300 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                </svg>
                <span class="text-yellow-300 font-semibold text-sm uppercase tracking-wide">
                    Welcome Bonus
                </span>
            </div>
            <h2 class="text-3xl font-bold mb-2">Get 200% Match</h2>
            <p class="text-white/90 mb-4">Up to $2,000 on your first deposit</p>
            <button class="bg-white text-purple-900 px-6 py-2 rounded-full font-bold hover:bg-yellow-300 transition-all transform hover:scale-105">
                Claim Now
            </button>
        </div>
        <div class="absolute -right-8 -bottom-8 text-9xl opacity-20">🎰</div>
    </div>

    <!-- Category Filter -->
    <div class="px-4 mt-6">
        <div class="flex gap-2 overflow-x-auto pb-2 hide-scrollbar" id="categoryFilter">
            <button data-category="all" class="category-btn active flex items-center gap-2 px-4 py-2 rounded-full font-semibold whitespace-nowrap transition-all">
                ✨ All Games
            </button>
            <button data-category="slots" class="category-btn flex items-center gap-2 px-4 py-2 rounded-full font-semibold whitespace-nowrap transition-all">
                ⚡ Slots
            </button>
            <button data-category="table" class="category-btn flex items-center gap-2 px-4 py-2 rounded-full font-semibold whitespace-nowrap transition-all">
                💎 Table Games
            </button>
            <button data-category="poker" class="category-btn flex items-center gap-2 px-4 py-2 rounded-full font-semibold whitespace-nowrap transition-all">
                ♠️ Poker
            </button>
        </div>
    </div>

    <!-- Hot Games Section -->
    <div class="px-4 mt-6" id="hotGamesSection">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <h3 class="text-xl font-bold">🔥 Hot Games</h3>
        </div>
        <div class="flex gap-3 overflow-x-auto pb-2 hide-scrollbar" id="hotGamesContainer"></div>
    </div>

    <!-- All Games Grid -->
    <div class="px-4 mt-6 pb-24">
        <h3 class="text-xl font-bold mb-3" id="gamesTitle">All Games</h3>
        <div class="grid grid-cols-2 gap-3" id="gamesContainer"></div>
    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-black/40 backdrop-blur-lg border-t border-white/10">
        <div class="flex justify-around items-center py-3 px-4">
            <button class="flex flex-col items-center gap-1 text-yellow-400">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M7.5 18C6.1 18 5 16.9 5 15.5S6.1 13 7.5 13 10 14.1 10 15.5 8.9 18 7.5 18M7.5 11C6.1 11 5 9.9 5 8.5S6.1 6 7.5 6 10 7.1 10 8.5 8.9 11 7.5 11M16.5 18C15.1 18 14 16.9 14 15.5S15.1 13 16.5 13 19 14.1 19 15.5 17.9 18 16.5 18M16.5 11C15.1 11 14 9.9 14 8.5S15.1 6 16.5 6 19 7.1 19 8.5 17.9 11 16.5 11Z"/>
                </svg>
                <span class="text-xs font-semibold">Games</span>
            </button>
            <button class="flex flex-col items-center gap-1 text-white/50 hover:text-white/80">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z"/>
                </svg>
                <span class="text-xs">Favorites</span>
            </button>
            <button class="flex flex-col items-center gap-1 text-white/50 hover:text-white/80">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span class="text-xs">Rewards</span>
            </button>
            <button class="flex flex-col items-center gap-1 text-white/50 hover:text-white/80">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                </svg>
                <span class="text-xs">VIP</span>
            </button>
        </div>
    </div>

    <script>
        const games = [
            { id: 1, name: "Lucky Sevens", category: "slots", image: "🎰", minBet: 1, maxBet: 100, hot: true, players: 234 },
            { id: 2, name: "Diamond Rush", category: "slots", image: "💎", minBet: 5, maxBet: 500, hot: true, players: 189 },
            { id: 3, name: "Blackjack Classic", category: "table", image: "🃏", minBet: 10, maxBet: 1000, hot: false, players: 156 },
            { id: 4, name: "Roulette Royale", category: "table", image: "🎡", minBet: 5, maxBet: 500, hot: false, players: 178 },
            { id: 5, name: "Fruit Blast", category: "slots", image: "🍒", minBet: 1, maxBet: 50, hot: false, players: 98 },
            { id: 6, name: "Poker Palace", category: "poker", image: "♠️", minBet: 20, maxBet: 2000, hot: true, players: 267 },
            { id: 7, name: "Golden Pharaoh", category: "slots", image: "👑", minBet: 2, maxBet: 200, hot: false, players: 143 },
            { id: 8, name: "Baccarat Elite", category: "table", image: "💰", minBet: 25, maxBet: 5000, hot: false, players: 87 }
        ];

        let selectedCategory = 'all';

        function renderHotGames() {
            const container = document.getElementById('hotGamesContainer');
            const hotGames = games.filter(g => g.hot);
            
            container.innerHTML = hotGames.map(game => `
                <div class="flex-shrink-0 w-40 bg-gradient-to-br from-orange-500/20 to-red-500/20 backdrop-blur-sm border border-orange-500/30 rounded-xl p-4 cursor-pointer hover:scale-105 transition-transform" onclick="launchGame(${game.id})">
                    <div class="text-5xl mb-2">${game.image}</div>
                    <h4 class="font-bold text-sm mb-1">${game.name}</h4>
                    <div class="flex items-center gap-1 text-xs text-white/70">
                        <span>${game.players} playing</span>
                    </div>
                </div>
            `).join('');
        }

        function renderGames() {
            const container = document.getElementById('gamesContainer');
            const filteredGames = selectedCategory === 'all' ? games : games.filter(g => g.category === selectedCategory);
            
            container.innerHTML = filteredGames.map(game => `
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl overflow-hidden cursor-pointer hover:scale-105 hover:border-yellow-500/50 transition-all" onclick="launchGame(${game.id})">
                    <div class="relative bg-gradient-to-br from-purple-600/30 to-indigo-600/30 p-8 flex items-center justify-center">
                        <div class="text-6xl">${game.image}</div>
                        ${game.hot ? '<div class="absolute top-2 right-2 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs px-2 py-1 rounded-full font-bold flex items-center gap-1">🔥 HOT</div>' : ''}
                    </div>
                    <div class="p-3">
                        <h4 class="font-bold mb-1">${game.name}</h4>
                        <div class="flex justify-between items-center text-xs text-white/60">
                            <span>$${game.minBet}-$${game.maxBet}</span>
                            <span class="flex items-center gap-1">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                ${game.players}
                            </span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function launchGame(gameId) {
            const game = games.find(g => g.id === gameId);
            alert(`Launching ${game.name}...\n\nThis would navigate to the game screen.\nMin Bet: $${game.minBet} | Max Bet: $${game.maxBet}`);
            // Replace this with: window.location.href = `games/${game.name.toLowerCase().replace(/\s+/g, '-')}.html`;
        }

        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                selectedCategory = e.currentTarget.dataset.category;
                
                // Update active state
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('active', 'bg-gradient-to-r', 'from-yellow-500', 'to-orange-500', 'text-white', 'shadow-lg', 'scale-105');
                    b.classList.add('bg-white/10', 'text-white/70');
                });
                e.currentTarget.classList.add('active', 'bg-gradient-to-r', 'from-yellow-500', 'to-orange-500', 'text-white', 'shadow-lg', 'scale-105');
                e.currentTarget.classList.remove('bg-white/10', 'text-white/70');
                
                // Update title and show/hide hot games
                const categoryNames = { all: 'All Games', slots: 'Slots', table: 'Table Games', poker: 'Poker' };
                document.getElementById('gamesTitle').textContent = categoryNames[selectedCategory];
                document.getElementById('hotGamesSection').style.display = selectedCategory === 'all' ? 'block' : 'none';
                
                renderGames();
            });
        });

        // Initial render
        renderHotGames();
        renderGames();
    </script>
</body>
</html>
