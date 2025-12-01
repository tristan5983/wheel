<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Nickel Slots | Crypto Casino - Slots, Roulette & Dice</title>

    <!-- SEO & Social -->
    <meta name="description" content="Big Nickel Slots - Play high-stakes crypto casino games with BNCL token. Slots, roulette, dice. RTP ~80%, house edge ~20%.">
    <meta name="keywords" content="Big Nickel Slots, BNCL token, crypto casino, online slots, roulette, dice game, blockchain gambling">
    <link rel="canonical" href="https://slots.bignickel.xyz/">
    <meta property="og:title" content="Big Nickel Slots - Win Big with BNCL!">
    <meta property="og:description" content="Spin to win in our crypto casino simulation. Real Vegas thrills with BNCL token.">
    <meta property="og:url" content="https://slots.bignickel.xyz/">
    <meta property="og:image" content="https://slots.bignickel.xyz/images/social-preview.jpg">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Big Nickel Slots - Crypto Jackpots Await">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #0f172a;
            background-image: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('images/background1.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .font-display { font-family: 'Righteous', cursive; }
        .dot { display: flex; align-items: center; justify-content: center; }
        
        /* Slower slot spin */
        @keyframes spin-fast { 0% { transform: translateY(0); } 100% { transform: translateY(-100%); } }
        .animate-spin-fast { animation: spin-fast 0.12s linear infinite; }

        /* Roulette */
        @keyframes spin-slow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .animate-spin-slow { animation: spin-slow 6s linear infinite; }

        /* Dice */
        @keyframes dice-roll-spin {
            0% { transform: translate(0, 0) rotate(0deg) scale(1); }
            20% { transform: translate(8px, -10px) rotate(120deg) scale(1.1); }
            40% { transform: translate(-8px, 8px) rotate(240deg) scale(0.9); }
            60% { transform: translate(6px, -6px) rotate(360deg) scale(1.1); }
            80% { transform: translate(-6px, 6px) rotate(480deg) scale(0.95); }
            100% { transform: translate(0, 0) rotate(540deg) scale(1); }
        }
        .dice-rolling { animation: dice-roll-spin 1.4s cubic-bezier(0.2, 0.8, 0.4, 1) forwards; }

        .token-info::-webkit-scrollbar { width: 6px; background: #1e293b; }
        .token-info::-webkit-scrollbar-thumb { background: #38bdf8; border-radius: 3px; }
        
        .slot-reel-container { overflow: hidden; height: 80px; }
        
        /* Jackpot celebration */
        @keyframes jackpot-flash { 0%, 100% { background: #0f172a; } 50% { background: linear-gradient(45deg, #f59e0b, #ef4444, #8b5cf6); } }
        .jackpot-active { animation: jackpot-flash 0.3s infinite; }
        .jackpot-text { text-shadow: 0 0 30px #f59e0b; animation: pulse 1.5s infinite; }
    </style>
</head>
<body class="min-h-screen p-2 sm:p-4 flex items-start justify-center">
    <?php require 'config.php'; ?>

    <div id="app-container" class="w-full max-w-lg mx-auto bg-slate-800 rounded-2xl shadow-2xl p-4 sm:p-6 border-4 border-cyan-400/80">
        <div class="text-center p-8 text-xl text-cyan-400">Loading Big Nickel Slots...</div>
    </div>

    <!-- Audio -->
    <audio id="spin-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-slot-machine-win-1935.mp3" preload="auto"></audio>
    <audio id="win-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-winning-chimes-2015.mp3" preload="auto"></audio>
    <audio id="jackpot-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-jackpot-win-2000.mp3" preload="auto"></audio>

<script>
    // Constants
    const TOKEN_NAME = 'BNCL';
    const MIN_BET = 1.00;
    const MAX_BET = 10.00;
    const BNCL_CONTRACT = '0x67aC2BB295F533D9E7f62Cf5B5Dc755E8bBb8A60';
    const BNCL_WALLET = '0x67aC2BB295F533D9E7f62Cf5B5Dc755E8bBb8A60';
    const ETRANSFER_EMAIL = 'etransfer@bignickelcasino.io';
    const SIMULATED_TOPUP = 500;

    const SYMBOL_MAP = { '🍒': 'Cherry', '🍋': 'Lemon', '7️⃣': 'Jackpot', '🔔': 'Bell' };
    const SYMBOLS = Object.keys(SYMBOL_MAP);

    // Audio
    const SOUNDS = {
        spin: document.getElementById('spin-sound'),
        win: document.getElementById('win-sound'),
        jackpot: document.getElementById('jackpot-sound')
    };
    const playSound = (name) => { const s = SOUNDS[name]; if (s) { s.currentTime = 0; s.play().catch(() => {}); } };

    // Confetti & Jackpot
    const triggerConfetti = () => {
        confetti({ particleCount: 200, spread: 70, origin: { y: 0.6 } });
        setTimeout(() => confetti({ particleCount: 100, angle: 60, spread: 55, origin: { x: 0 } }), 100);
        setTimeout(() => confetti({ particleCount: 100, angle: 120, spread: 55, origin: { x: 1 } }), 200);
    };
    const showJackpotCelebration = (amount) => {
        document.body.classList.add('jackpot-active');
        playSound('jackpot');
        triggerConfetti();
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 z-50 flex items-center justify-center pointer-events-none bg-black/50';
        overlay.innerHTML = `<div class="text-center"><h1 class="text-6xl sm:text-8xl font-display text-yellow-400 jackpot-text mb-4">JACKPOT!</h1><p class="text-4xl text-white">+${amount.toFixed(2)} ${TOKEN_NAME}</p></div>`;
        document.body.appendChild(overlay);
        setTimeout(() => { document.body.classList.remove('jackpot-active'); overlay.remove(); }, 5000);
    };

    let state = {
        userId: null,
        balance: 5.00,
        isLoading: true,
        error: null,
        isAuthReady: false,
        currentGame: 'slots',
        isGameActive: false,
        slotsReels: ['?', '?', '?'],
        slotsMessage: 'Place your bet and spin!',
        slotsBetAmount: 1.00,
        rouletteResult: null,
        rouletteMessage: 'Place your bet on Red or Black.',
        rouletteBetAmount: 5.00,
        diceRollResult: null,
        diceMessage: 'Guess High (7+) or Low (6-).',
        diceBetAmount: 2.50
    };

    let finalReels = null; // For staggered slots

    const appContainer = document.getElementById('app-container');

    // Auth
    function showLogin() {
        appContainer.innerHTML = `
            <div class="text-center p-8 text-white">
                <h2 class="text-4xl sm:text-5xl font-display text-yellow-500 mb-8">BIG NICKEL SLOTS</h2>
                <p class="text-red-400 mb-4">You must log in to play.</p>
                <input id="username" placeholder="Username" class="w-full p-3 rounded mb-3 bg-slate-700 text-white">
                <input id="password" type="password" placeholder="Password" class="w-full p-3 rounded mb-4 bg-slate-700 text-white">
                <div class="flex gap-3">
                    <button onclick="login()" class="flex-1 bg-cyan-600 hover:bg-cyan-700 py-3 rounded font-bold text-lg transition">Login</button>
                    <button onclick="register()" class="flex-1 bg-green-600 hover:bg-green-700 py-3 rounded font-bold text-lg transition">Sign Up</button>
                </div>
                <p id="auth-msg" class="mt-4 text-red-400 h-6"></p>
            </div>`;
    }

    async function login() {
        const u = document.getElementById('username').value.trim();
        const p = document.getElementById('password').value;
        const res = await fetch('login.php', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({action: 'login', username: u, password: p})});
        const data = await res.json();
        if (data.success) {
            state.isAuthReady = true;
            await loadBalance();
            renderApp();
        } else {
            document.getElementById('auth-msg').textContent = data.msg || 'Login failed';
        }
    }

    async function register() {
        const u = document.getElementById('username').value.trim();
        const p = document.getElementById('password').value;
        const res = await fetch('login.php', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({action: 'register', username: u, password: p})});
        const data = await res.json();
        if (data.success) {
            await login();
        } else {
            document.getElementById('auth-msg').textContent = data.msg || 'Register failed';
        }
    }

    async function logout() {
        await fetch('logout.php');
        location.reload();
    }

    // Balance
    async function loadBalance() {
        state.isLoading = true;
        renderApp();
        const res = await fetch('api/balance.php');
        const data = await res.json();
        if (data.balance !== undefined) {
            state.balance = parseFloat(data.balance).toFixed(2);
            state.isLoading = false;
        } else if (data.error === 'Not logged in') {
            state.isAuthReady = false;
            showLogin();
            return;
        } else {
            state.error = data.error || 'Failed to load balance.';
            state.isLoading = false;
        }
        state.isAuthReady = true;
        renderApp();
    }

    async function deductBet(amount) {
        const res = await fetch('api/bet.php', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({amount})});
        const data = await res.json();
        if (!data.success) throw new Error(data.insufficient ? 'Insufficient funds' : 'Bet failed');
        await loadBalance();
    }

    async function addWin(amount) {
        await fetch('api/win.php', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({amount})});
        await loadBalance();
    }

    // State update
    const updateState = (newState) => {
        Object.assign(state, newState);
        renderApp();
    };

    // Helpers
    const renderLoading = () => `<div class="text-center p-8 text-xl text-cyan-400">Connecting...</div>`;
    const renderError = (msg) => `<div class="text-center p-8 text-red-500">Error: ${msg}</div>`;

    // Dice Face
    const DiceFace = (value) => {
        const patterns = {1: [5], 2: [0,10], 3: [0,5,10], 4: [0,2,8,10], 5: [0,2,5,8,10], 6: [0,2,3,7,8,10]};
        const dots = Array.from({length: 11}, (_, i) => `<div class="w-2.5 h-2.5 rounded-full ${patterns[value].includes(i) ? 'bg-black' : 'opacity-0'}"></div>`).join('');
        return `<div class="dice-face grid grid-cols-3 gap-1 p-3 bg-white w-14 h-14 rounded-xl shadow-lg">${dots}</div>`;
    };

    // Game Buttons
    const renderGameButton = (name) => {
        const isCurrent = state.currentGame === name.toLowerCase();
        return `<button onclick="setCurrentGame('${name.toLowerCase()}')" class="flex-1 py-3 rounded font-bold text-lg transition ${isCurrent ? 'bg-yellow-500 text-slate-900' : 'bg-slate-700 hover:bg-slate-600 text-white'}">${name}</button>`;
    };

    // Bet Selector (expanded 1-10)
    const BetSelector = (currentGame) => {
        let currentBet, setBetFunc;
        if (currentGame === 'slots') { currentBet = state.slotsBetAmount; setBetFunc = 'setSlotsBet'; }
        else if (currentGame === 'roulette') { currentBet = state.rouletteBetAmount; setBetFunc = 'setRouletteBet'; }
        else { currentBet = state.diceBetAmount; setBetFunc = 'setDiceBet'; }

        const betOptions = [1,2,3,4,5,6,7,8,9,10].map(n => n.toFixed(2));

        return `
            <div class="flex flex-col space-y-3">
                <div class="flex justify-center items-center space-x-2">
                    <label class="text-white text-lg font-semibold">Bet (${TOKEN_NAME}):</label>
                    <input type="number" min="${MIN_BET}" max="${MAX_BET}" step="1" value="${parseFloat(currentBet).toFixed(2)}" onchange="${setBetFunc}(this.value)" class="w-28 p-2 rounded bg-slate-700 text-cyan-300 text-center font-mono">
                </div>
                <div class="flex flex-wrap justify-center gap-2">
                    ${betOptions.map(amount => `<button onclick="${setBetFunc}('${amount}')" class="px-2 py-1 rounded-full font-bold text-sm transition ${parseFloat(amount) === parseFloat(currentBet) ? 'bg-yellow-500 text-slate-900' : 'bg-slate-600 hover:bg-slate-500 text-white'}">${amount}</button>`).join('')}
                </div>
            </div>
        `;
    };

    // Render Games
    const renderSlotMachine = () => {
        return `<div class="text-center">
            <div class="flex justify-center my-6 space-x-4">
                ${state.slotsReels.map(r => `<div class="slot-reel-container w-1/4 bg-slate-700 rounded-lg shadow-inner"><div class="text-6xl p-4 h-20 text-yellow-500 flex items-center justify-center ${state.isGameActive ? 'animate-spin-fast' : ''}">${r}</div></div>`).join('')}
            </div>
            <p class="text-xl h-6 text-yellow-500 mb-6">${state.slotsMessage}</p>
            ${BetSelector('slots')}
            <button onclick="spinSlots()" ${state.isGameActive || state.balance < state.slotsBetAmount ? 'disabled' : ''} class="mt-6 w-full bg-cyan-600 hover:bg-cyan-700 py-3 rounded-xl font-bold text-xl disabled:opacity-50 transition shadow-lg">
                Spin
            </button>
            <p class="text-sm text-cyan-400 mt-4">Match 3 for win! (7️⃣ pays 8x - RTP ~80%)</p>
        </div>`;
    };

    const renderRoulette = () => {
        const resultColor = state.rouletteResult === 'Red' ? 'text-red-500' : state.rouletteResult === 'Black' ? 'text-white' : 'text-green-500';
        const resultHtml = state.rouletteResult ? `<p class="text-3xl font-bold mb-4 ${resultColor}">${state.rouletteResult} Wins!</p>` : '';
        const wheelHtml = state.isGameActive ? `<div class="w-40 h-40 sm:w-48 sm:h-48 mx-auto mb-6 bg-red-600 rounded-full animate-spin-slow"></div>` : `<div class="w-40 h-40 sm:w-48 sm:h-48 mx-auto mb-6 bg-red-600 rounded-full"></div>`;
        return `<div class="text-center">
            ${resultHtml}
            ${wheelHtml}
            <p class="text-xl h-6 text-yellow-500 mb-6">${state.rouletteMessage}</p>
            ${BetSelector('roulette')}
            <div class="flex justify-center space-x-4 mt-6">
                <button onclick="handleBetRoulette('Red')" ${state.isGameActive || state.balance < state.rouletteBetAmount ? 'disabled' : ''} class="flex-1 bg-red-600 hover:bg-red-700 py-3 rounded-xl font-bold text-lg disabled:opacity-50">Bet Red</button>
                <button onclick="handleBetRoulette('Black')" ${state.isGameActive || state.balance < state.rouletteBetAmount ? 'disabled' : ''} class="flex-1 bg-black text-white border-2 border-white/50 hover:bg-gray-800 py-3 rounded-xl font-bold text-lg disabled:opacity-50">Bet Black</button>
            </div>
            <p class="text-sm text-cyan-400 mt-4">1.5x payout (house edge 33% - RTP ~67%)</p>
        </div>`;
    };

    const renderDiceRoll = () => {
        const isRolling = state.isGameActive;
        const diceClass = isRolling ? 'dice-rolling' : '';
        const resultHtml = state.diceRollResult ? `<div class="flex justify-center space-x-4 mb-4">${DiceFace(state.diceRollResult[0]).replace('dice-face', `dice-face ${diceClass}`)}${DiceFace(state.diceRollResult[1]).replace('dice-face', `dice-face ${diceClass}`)}</div><p class="text-3xl font-bold text-yellow-500 mb-4">Total: ${state.diceRollResult[0] + state.diceRollResult[1]}</p>` : `<p class="text-6xl text-cyan-400 mb-6"><span class="${diceClass}">🎲</span> <span class="${diceClass}">🎲</span></p>`;
        return `<div class="text-center">
            ${resultHtml}
            <p class="text-xl h-6 text-yellow-500 mb-6">${state.diceMessage}</p>
            ${BetSelector('dice')}
            <div class="flex justify-center space-x-4 mt-6">
                <button onclick="rollDice('High')" ${state.isGameActive || state.balance < state.diceBetAmount ? 'disabled' : ''} class="flex-1 bg-green-600 hover:bg-green-700 py-3 rounded-xl font-bold text-lg disabled:opacity-50">High (7+)</button>
                <button onclick="rollDice('Low')" ${state.isGameActive || state.balance < state.diceBetAmount ? 'disabled' : ''} class="flex-1 bg-red-600 hover:bg-red-700 py-3 rounded-xl font-bold text-lg disabled:opacity-50">Low (6-)</button>
            </div>
            <p class="text-sm text-cyan-400 mt-4">1.5x payout (house edge 33% - RTP ~67%)</p>
        </div>`;
    };

    // Add Funds Page
    const renderTokenPurchase = () => {
        return `<div class="text-center p-2">
            <h2 class="text-3xl font-display text-cyan-400 mb-6">Add ${TOKEN_NAME}</h2>
            <div class="bg-slate-700 p-4 rounded-xl shadow-inner mb-6 space-y-4 text-left token-info h-96 overflow-y-auto">
                <p class="text-lg text-yellow-500 font-semibold border-b pb-2">Simulation Details</p>
                <div><h3 class="font-bold text-white mb-1">1. Buy BNCL (Sim)</h3><p class="text-sm text-slate-400 mb-2">Contract: <code class="text-green-400">${BNCL_CONTRACT}</code></p></div>
                <div><h3 class="font-bold text-white mb-1">2. Transfer (Sim)</h3><p class="text-sm text-slate-400 mb-2">Wallet: <code class="text-green-400">${BNCL_WALLET}</code></p></div>
                <div><h3 class="font-bold text-white mb-1">3. E-Transfer (Sim)</h3><p class="text-sm text-slate-400 mb-2">Email: <code class="text-green-400">${ETRANSFER_EMAIL}</code></p></div>
                <div class="bg-red-900/40 p-3 rounded-lg border border-red-500"><h3 class="font-bold text-red-400 mb-1">Note: Include username in memo!</h3></div>
                <p class="text-red-400 text-xs italic">Demo: Adds ${SIMULATED_TOPUP} ${TOKEN_NAME} instantly.</p>
            </div>
            <button onclick="simulateTopUp()" class="w-full bg-green-600 hover:bg-green-700 py-3 rounded-xl font-bold text-xl">Add ${SIMULATED_TOPUP} ${TOKEN_NAME}</button>
            <button onclick="setCurrentGame('slots')" class="mt-4 w-full bg-slate-600 py-3 rounded-xl font-bold">Back to Slots</button>
        </div>`;
    };

    window.simulateTopUp = async () => {
        updateState({isLoading: true});
        try {
            await addWin(SIMULATED_TOPUP);
            updateState({currentGame: 'slots', slotsMessage: `+${SIMULATED_TOPUP} ${TOKEN_NAME} added!`});
        } catch (e) {
            updateState({error: 'Top-up failed.'});
        }
    };

    // Bet Setters (1-10 step)
    window.setSlotsBet = (v) => { const val = Math.round(parseFloat(v) || MIN_BET); updateState({slotsBetAmount: Math.max(MIN_BET, Math.min(MAX_BET, val))}); };
    window.setRouletteBet = (v) => { const val = Math.round(parseFloat(v) || MIN_BET); updateState({rouletteBetAmount: Math.max(MIN_BET, Math.min(MAX_BET, val))}); };
    window.setDiceBet = (v) => { const val = Math.round(parseFloat(v) || MIN_BET); updateState({diceBetAmount: Math.max(MIN_BET, Math.min(MAX_BET, val))}); };
    window.setCurrentGame = (game) => updateState({currentGame: game, isGameActive: false, rouletteResult: null, diceRollResult: null});

    // Games Logic (tuned RTP ~80%)
    window.spinSlots = async () => {
        const bet = state.slotsBetAmount;
        if (state.isGameActive || state.balance < bet) return;
        playSound('spin');
        updateState({isGameActive: true, slotsMessage: `Spinning ${bet.toFixed(2)} ${TOKEN_NAME}...`, slotsReels: ['?', '?', '?']});
        finalReels = null;
        try {
            await deductBet(bet);
            finalReels = [SYMBOLS[Math.floor(Math.random() * SYMBOLS.length)], SYMBOLS[Math.floor(Math.random() * SYMBOLS.length)], SYMBOLS[Math.floor(Math.random() * SYMBOLS.length)]];
            const duration = 4500;
            setTimeout(() => determineSlotWin(finalReels, bet), duration);
            setTimeout(() => updateState({slotsReels: [finalReels[0], '?', '?']}), duration - 1200);
            setTimeout(() => updateState({slotsReels: [finalReels[0], finalReels[1], '?']}), duration - 600);
        } catch (e) {
            updateState({isGameActive: false, slotsMessage: 'Insufficient funds!'});
        }
    };

    const determineSlotWin = async (reels, bet) => {
        let profit = 0;
        if (reels[0] === reels[1] && reels[1] === reels[2]) {
            const sym = reels[0];
            profit = sym === '7️⃣' ? bet * 7 : sym === '🔔' ? bet * 4 : sym === '🍒' ? bet * 2 : bet * 1; // Tuned for ~80% RTP
        }
        updateState({isGameActive: false, slotsReels: reels});
        if (profit > 0) {
            const total = profit + bet;
            await addWin(total);
            playSound(profit >= bet * 5 ? 'jackpot' : 'win');
            if (profit >= bet * 5) showJackpotCelebration(total);
            updateState({slotsMessage: `Win! +${total.toFixed(2)} ${TOKEN_NAME}`});
        } else {
            updateState({slotsMessage: 'No win. Try again!'});
        }
    };

    window.handleBetRoulette = async (color) => {
        const bet = state.rouletteBetAmount;
        if (state.isGameActive || state.balance < bet) return;
        playSound('spin');
        updateState({isGameActive: true, rouletteResult: null, rouletteMessage: `Bet ${bet.toFixed(2)} ${TOKEN_NAME} on ${color}...`});
        try {
            await deductBet(bet);
            setTimeout(async () => {
                const roll = Math.floor(Math.random() * 37);
                const result = roll === 0 ? 'Green' : roll % 2 === 0 ? 'Red' : 'Black';
                const won = result.toUpperCase() === color.toUpperCase();
                let winAmount = 0;
                if (won) {
                    winAmount = bet * 1.5; // 1.5x payout, ~33% house edge
                    await addWin(winAmount);
                    playSound('win');
                }
                updateState({isGameActive: false, rouletteResult: result, rouletteMessage: won ? `Win ${winAmount.toFixed(2)} ${TOKEN_NAME}!` : `Lost on ${result}.`});
            }, 6000);
        } catch (e) {
            updateState({isGameActive: false, rouletteMessage: 'Insufficient funds!'});
        }
    };

    window.rollDice = async (guess) => {
        const bet = state.diceBetAmount;
        if (state.isGameActive || state.balance < bet) return;
        updateState({isGameActive: true, diceMessage: 'Rolling...'});
        try {
            await deductBet(bet);
            setTimeout(async () => {
                const d1 = Math.floor(Math.random() * 6) + 1;
                const d2 = Math.floor(Math.random() * 6) + 1;
                const total = d1 + d2;
                const won = (guess === 'High' && total >= 7) || (guess === 'Low' && total <= 6);
                let winAmount = 0;
                if (won) {
                    winAmount = bet * 1.5; // 1.5x payout, ~33% house edge
                    await addWin(winAmount);
                    playSound('win');
                }
                updateState({isGameActive: false, diceRollResult: [d1, d2], diceMessage: won ? `Win ${winAmount.toFixed(2)} ${TOKEN_NAME}!` : `Total ${total}. Lost.`});
            }, 2000);
        } catch (e) {
            updateState({isGameActive: false, diceMessage: 'Insufficient funds!'});
        }
    };

    // Main Render
    const renderApp = () => {
        if (!state.isAuthReady) { showLogin(); return; }
        if (state.currentGame === 'purchase') { appContainer.innerHTML = renderTokenPurchase(); return; }

        let gameContent;
        if (state.isLoading) gameContent = renderLoading();
        else if (state.error) gameContent = renderError(state.error);
        else if (state.currentGame === 'slots') gameContent = renderSlotMachine();
        else if (state.currentGame === 'roulette') gameContent = renderRoulette();
        else if (state.currentGame === 'dice') gameContent = renderDiceRoll();
        else gameContent = renderError('Game not found.');

        const header = `<header class="text-center mb-6">
            <h1 class="text-3xl sm:text-4xl font-display text-yellow-500 border-b-4 border-yellow-500 inline-block pb-1">BIG NICKEL SLOTS</h1>
            <div class="flex items-center justify-center space-x-4 mt-4">
                <p class="text-xl text-white">${TOKEN_NAME}: <span class="text-cyan-400 font-bold">${state.balance}</span></p>
                <button onclick="setCurrentGame('purchase')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-full font-bold">+ Add Funds</button>
            </div>
            <div class="flex justify-center gap-2 mt-4">${renderGameButton('Slots')}${renderGameButton('Roulette')}${renderGameButton('Dice')}</div>
        </header>`;

        const footer = `<footer class="mt-8 pt-4 border-t border-slate-700 text-center text-xs text-slate-500">Simulation - RTP ~80% | <button onclick="logout()" class="bg-red-600 hover:bg-red-700 py-1 px-3 rounded text-white font-bold ml-2">Logout</button></footer>`;

        appContainer.innerHTML = header + gameContent + footer;
    };

    // Start
    if (document.cookie.includes('PHPSESSID')) loadBalance();
    else showLogin();
</script>
</body>
</html>
