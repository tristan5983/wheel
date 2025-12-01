<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Nickel Slots | Crypto Casino - Win Big with BNCL</title>

    <!-- SEO & Social -->
    <meta name="description" content="Big Nickel Slots - The ultimate crypto casino. Play slots, roulette & dice with BNCL token. Real Vegas feel, real excitement!">
    <meta name="keywords" content="Big Nickel Slots, BNCL, crypto casino, online slots, jackpot, blockchain gambling">
    <link rel="canonical" href="https://slots.bignickel.xyz/">
    <meta property="og:title" content="Big Nickel Slots - Win Big with BNCL">
    <meta property="og:description" content="Spin the reels and hit massive jackpots! Real crypto casino experience.">
    <meta property="og:url" content="https://slots.bignickel.xyz/">
    <meta property="og:image" content="https://slots.bignickel.xyz/images/social-preview.jpg">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #0f172a;
            background-image: linear-gradient(rgba(0,0,0,0.88), rgba(0,0,0,0.88)), url('images/background1.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .font-display { font-family: 'Righteous', cursive; }

        @keyframes spin-fast { 0% { transform: translateY(0); } 100% { transform: translateY(-100%); } }
        .animate-spin-fast { animation: spin-fast 0.12s linear infinite; }

        @keyframes spin-slow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .animate-spin-slow { animation: spin-slow 6s linear infinite; }

        @keyframes dice-roll { 0% { transform: translate(0,0) rotate(0); } 100% { transform: translate(0,0) rotate(540deg); } }
        .dice-rolling { animation: dice-roll 1.4s cubic-bezier(0.2, 0.8, 0.4, 1) forwards; }

        .slot-reel-container { overflow: hidden; height: 80px; }

        @keyframes jackpot-flash {
            0%, 100% { background: #0f172a; }
            50% { background: linear-gradient(45deg, #f59e0b, #ef4444, #8b5cf6, #10b981); }
        }
        .jackpot-active { animation: jackpot-flash 0.3s infinite; }
        .jackpot-text { text-shadow: 0 0 30px #f59e0b, 0 0 60px #ef4444; animation: pulse 1.5s infinite; }
    </style>
</head>
<body class="min-h-screen p-2 sm:p-4 flex items-start justify-center">
    <?php require 'config.php'; ?>

    <div id="app-container" class="relative w-full max-w-lg mx-auto bg-slate-800 rounded-2xl shadow-2xl p-6 border-4 border-cyan-400/80 overflow-hidden">
        <div class="text-center p-8 text-xl text-cyan-400">Loading Big Nickel Slots...</div>
    </div>

    <audio id="spin-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-slot-machine-win-1935.mp3" preload="auto"></audio>
    <audio id="win-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-winning-chimes-2015.mp3" preload="auto"></audio>
    <audio id="jackpot-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-jackpot-win-2000.mp3" preload="auto"></audio>

<script>
    const SOUNDS = {
        spin: document.getElementById('spin-sound'),
        win: document.getElementById('win-sound'),
        jackpot: document.getElementById('jackpot-sound')
    };
    const playSound = (name) => { const s = SOUNDS[name]; if(s){ s.currentTime=0; s.play().catch(()=>{}); } };
    const confetti = window.confetti;

    const triggerConfetti = () => {
        confetti({ particleCount: 200, spread: 70, origin: { y: 0.6 } });
        confetti({ particleCount: 100, angle: 60, spread: 55, origin: { x: 0 } });
        confetti({ particleCount: 100, angle: 120, spread: 55, origin: { x: 1 } });
    };

    const showJackpot = (amount) => {
        document.body.classList.add('jackpot-active');
        playSound('jackpot');
        triggerConfetti(); setTimeout(triggerConfetti, 800); setTimeout(triggerConfetti, 1600);
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 z-50 flex items-center justify-center pointer-events-none';
        overlay.innerHTML = `<div class="text-center"><h1 class="text-7xl sm:text-9xl font-display text-yellow-400 jackpot-text">JACKPOT!</h1><p class="text-5xl text-white mt-4">+${amount.toFixed(2)} BNCL</p></div>`;
        document.body.appendChild(overlay);
        setTimeout(() => { document.body.classList.remove('jackpot-active'); overlay.remove(); }, 6000);
    };

    const SYMBOLS = ['Cherry', 'Lemon', 'Jackpot', 'Bell'];
    let finalReels = null;

    let state = {
        balance: 5, isLoading: true, isAuthReady: false, currentGame: 'slots', isGameActive: false,
        slotsReels: ['?', '?', '?'], slotsMessage: 'Place your bet and spin!', slotsBetAmount: 1.00,
        rouletteResult: null, rouletteMessage: 'Place your bet on Red or Black.', rouletteBetAmount: 5.00,
        diceRollResult: null, diceMessage: 'Guess High (7+) or Low (6-)', diceBetAmount: 2.50
    };

    const appContainer = document.getElementById('app-container');

    function showLogin() {
        appContainer.innerHTML = `
            <div class="text-center p-8 text-white">
                <h2 class="text-4xl sm:text-6xl font-display text-yellow-500 mb-8">BIG NICKEL SLOTS</h2>
                <p class="text-red-400 mb-6">Login required to play</p>
                <input id="username" placeholder="Username" class="w-full p-3 rounded mb-3 bg-slate-700 text-white">
                <input id="password" type="password" placeholder="Password" class="w-full p-3 rounded mb-4 bg-slate-700 text-white">
                <div class="flex gap-3">
                    <button onclick="login()" class="flex-1 bg-cyan-600 hover:bg-cyan-700 py-3 rounded font-bold text-lg">Login</button>
                    <button onclick="register()" class="flex-1 bg-green-600 hover:bg-green-700 py-3 rounded font-bold text-lg">Sign Up</button>
                </div>
                <p id="auth-msg" class="mt-4 text-red-400 h-6"></p>
            </div>`;
    }

    async function login() {
        const u = document.getElementById('username').value.trim();
        const p = document.getElementById('password').value;
        const res = await fetch('login.php', {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'login',username:u,password:p})});
        const data = await res.json();
        if(data.success){ state.isAuthReady = true; await loadBalance(); renderApp(); }
        else document.getElementById('auth-msg').textContent = data.msg || "Login failed";
    }

    async function register() {
        const u = document.getElementById('username').value.trim();
        const p = document.getElementById('password').value;
        const res = await fetch('login.php', {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'register',username:u,password:p})});
        const data = await res.json();
        if(data.success) await login();
        else document.getElementById('auth-msg').textContent = data.msg || "Register failed";
    }

    async function logout() { await fetch('logout.php'); location.reload(); }

    async function loadBalance() {
        state.isLoading = true; renderApp();
        const res = await fetch('api/balance.php');
        const data = await res.json();
        if (data.balance !== undefined) state.balance = parseFloat(data.balance).toFixed(2);
        else if (data.error === 'Not logged in') { state.isAuthReady = false; showLogin(); return; }
        state.isLoading = false; state.isAuthReady = true; renderApp();
    }

    async function deductBet(a) {
        const r = await fetch('api/bet.php', {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({amount:a})});
        const d = await r.json();
        if(!d.success) throw new Error("Insufficient funds");
        await loadBalance();
    }

    async function addWin(a) {
        await fetch('api/win.php', {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({amount:a})});
        await loadBalance();
    }

    const updateState = (s) => { Object.assign(state, s); renderApp(); };

    window.setSlotsBet = v => updateState({slotsBetAmount: Math.max(1, Math.min(10, Math.round(parseFloat(v)||1)))});
    window.setRouletteBet = v => updateState({rouletteBetAmount: Math.max(1, Math.min(10, Math.round(parseFloat(v)||5)))});
    window.setDiceBet = v => updateState({diceBetAmount: Math.max(1, Math.min(10, Math.round(parseFloat(v)||2.5)))});
    window.setCurrentGame = g => updateState({currentGame:g, isGameActive:false, rouletteResult:null, diceRollResult:null});

    window.spinSlots = async () => {
        const bet = state.slotsBetAmount;
        if (state.isGameActive || state.balance < bet) return;
        playSound('spin');
        finalReels = null;
        updateState({isGameActive:true, slotsMessage:`Spinning ${bet.toFixed(2)} BNCL...`, slotsReels:['Spinning','Spinning','Spinning']});

        try {
            await deductBet(bet);
            finalReels = SYMBOLS.sort(() => Math.random() - 0.5).slice(0,3);
            const duration = 4500;
            setTimeout(() => determineSlotWin(finalReels, bet), duration);
            setTimeout(() => updateState({slotsReels: [finalReels[0], 'Spinning', 'Spinning']}), duration - 1200);
            setTimeout(() => updateState({slotsReels: [finalReels[0], finalReels[1], 'Spinning']}), duration - 700);
        } catch(e) {
            updateState({isGameActive:false, slotsMessage:"Not enough BNCL!"});
        }
    };

    const determineSlotWin = async (reels, bet) => {
        let win = 0;
        if (reels[0]===reels[1] && reels[1]===reels[2]) {
            win = reels[0]==='Jackpot' ? bet*15 : reels[0]==='Bell' ? bet*7.5 : reels[0]==='Cherry' ? bet*5 : bet*4;
        }
        if (win > 0) {
            const total = win + bet;
            await addWin(total);
            if (win >= bet*10) showJackpot(total);
            else playSound('win');
            updateState({isGameActive:false, slotsReels:reels, slotsMessage:`WIN! +${total.toFixed(2)} BNCL!`});
        } else {
            updateState({isGameActive:false, slotsReels:reels, slotsMessage:"No win. Try again!"});
        }
    };

    window.handleBetRoulette = async (color) => {
        const bet = state.rouletteBetAmount;
        if (state.isGameActive || state.balance < bet) return;
        playSound('spin');
        updateState({isGameActive:true, rouletteMessage:"Spinning...", rouletteResult:null});
        await deductBet(bet);
        setTimeout(async () => {
            const n = Math.floor(Math.random()*37);
            const result = n===0 ? 'Green' : n%2===0 ? 'Red' : 'Black';
            if (result === color) {
                playSound('win');
                await addWin(bet * 1.5);
                updateState({isGameActive:false, rouletteResult:result, rouletteMessage:`You win ${(bet*1.5).toFixed(2)}!`});
            } else {
                updateState({isGameActive:false, rouletteResult:result, rouletteMessage:`${result}. You lose.`});
            }
        }, 6000);
    };

    window.rollDice = async (guess) => {
        const bet = state.diceBetAmount;
        if (state.isGameActive || state.balance < bet) return;
        updateState({isGameActive:true, diceMessage:"Rolling..."});
        await deductBet(bet);
        setTimeout(async () => {
            const d1 = Math.floor(Math.random()*6)+1;
            const d2 = Math.floor(Math.random()*6)+1;
            const total = d1 + d2;
            const won = (guess==='High' && total>=7) || (guess==='Low' && total<=6);
            if (won) { playSound('win'); await addWin(bet * 1.5); }
            updateState({isGameActive:false, diceRollResult:[d1,d2], diceMessage: won ? `You win ${(bet*1.5).toFixed(2)}!` : `Total ${total}. You lose.`});
        }, 2000);
    };

    const renderApp = () => {
        if (!state.isAuthReady) return showLogin();
        if (state.currentGame === 'purchase') return appContainer.innerHTML = `<div class="text-center p-8"><h2 class="text-4xl font-display text-cyan-400 mb-6">Add Funds</h2><p class="text-white">Coming soon...</p><button onclick="setCurrentGame('slots')" class="mt-6 bg-cyan-600 hover:bg-cyan-700 py-3 px-8 rounded font-bold">Back to Slots</button></div>`;

        appContainer.innerHTML = `
            <header class="text-center mb-6">
                <h1 class="text-4xl sm:text-6xl font-display text-yellow-500 border-b-4 border-yellow-500 inline-block pb-2">BIG NICKEL SLOTS</h1>
                <div class="flex justify-center items-center gap-4 mt-6">
                    <p class="text-2xl text-white">Balance: <span class="text-cyan-400 font-bold">${state.balance} BNCL</span></p>
                    <button onclick="setCurrentGame('purchase')" class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-full font-bold">+ Add Funds</button>
                </div>
                <div class="flex gap-2 mt-6">
                    ${['Slots','Roulette','Dice'].map(g=>`<button onclick="setCurrentGame('${g.toLowerCase()}')" class="flex-1 py-3 rounded font-bold text-lg ${state.currentGame===g.toLowerCase()?'bg-yellow-500 text-black':'bg-slate-700 hover:bg-slate-600 text-white'}">${g}</button>`).join('')}
                </div>
            </header>

            ${state.isLoading ? '<div class="text-center p-12 text-cyan-400 text-2xl">Loading...</div>' :
            state.currentGame==='slots' ? `<div class="text-center">
                <div class="flex justify-center my-8 space-x-4">
                    ${state.slotsReels.map(s=>`<div class="slot-reel-container w-1/4 bg-slate-700 rounded-lg shadow-inner">
                        <div class="text-6xl p-4 h-20 flex items-center justify-center ${state.isGameActive?'animate-spin-fast':''}">${s}</div>
                    </div>`).join('')}
                </div>
                <p class="text-2xl text-yellow-500 mb-6 h-10">${state.slotsMessage}</p>
                <div class="flex justify-center gap-3 mb-6">
                    <button onclick="setSlotsBet(1)" class="px-4 py-2 rounded-full font-bold ${state.slotsBetAmount==1?'bg-yellow-500 text-black':'bg-slate-600'}">1</button>
                    <button onclick="setSlotsBet(5)" class="px-4 py-2 rounded-full font-bold ${state.slotsBetAmount==5?'bg-yellow-500 text-black':'bg-slate-600'}">5</button>
                    <button onclick="setSlotsBet(10)" class="px-4 py-2 rounded-full font-bold ${state.slotsBetAmount==10?'bg-yellow-500 text-black':'bg-slate-600'}">10</button>
                </div>
                <button onclick="spinSlots()" ${state.isGameActive||state.balance<state.slotsBetAmount?'disabled':''} class="w-full bg-cyan-600 hover:bg-cyan-700 disabled:opacity-50 py-5 rounded-xl font-bold text-3xl shadow-lg">SPIN</button>
            </div>` :
            state.currentGame==='roulette' ? `<div class="text-center">
                ${state.rouletteResult?`<p class="text-5xl font-bold mb-6 ${state.rouletteResult==='Red'?'text-red-500':state.rouletteResult==='Black'?'text-white':'text-green-500'}">${state.rouletteResult}!</p>`:''}
                <img src="images/roulette-wheel.png" class="w-64 h-64 mx-auto mb-8 ${state.isGameActive?'animate-spin-slow':''} rounded-full"/>
                <p class="text-2xl text-yellow-500 mb-6">${state.rouletteMessage}</p>
                <div class="flex gap-4 mb-6">
                    <button onclick="setRouletteBet(1)" class="px-4 py-2 rounded-full font-bold ${state.rouletteBetAmount==1?'bg-yellow-500 text-black':'bg-slate-600'}">1</button>
                    <button onclick="setRouletteBet(5)" class="px-4 py-2 rounded-full font-bold ${state.rouletteBetAmount==5?'bg-yellow-500 text-black':'bg-slate-600'}">5</button>
                    <button onclick="setRouletteBet(10)" class="px-4 py-2 rounded-full font-bold ${state.rouletteBetAmount==10?'bg-yellow-500 text-black':'bg-slate-600'}">10</button>
                </div>
                <div class="flex gap-4">
                    <button onclick="handleBetRoulette('Red')" ${state.isGameActive?'disabled':''} class="flex-1 bg-red-600 hover:bg-red-700 py-5 rounded-xl font-bold text-2xl disabled:opacity-50">RED</button>
                    <button onclick="handleBetRoulette('Black')" ${state.isGameActive?'disabled':''} class="flex-1 bg-black hover:bg-gray-900 border-2 border-white/50 py-5 rounded-xl font-bold text-2xl disabled:opacity-50">BLACK</button>
                </div>
            </div>` :
            `<div class="text-center">
                ${state.diceRollResult?`<div class="flex justify-center gap-8 mb-8 text-8xl">${state.diceRollResult.map(d=>`<span class="${state.isGameActive?'dice-rolling':''}">${d}</span>`).join('')}</div><p class="text-4xl text-yellow-500 mb-6">Total: ${state.diceRollResult[0]+state.diceRollResult[1]}</p>`:'<p class="text-9xl mb-12">Dice Dice</p>'}
                <p class="text-2xl text-yellow-500 mb-6">${state.diceMessage}</p>
                <div class="flex gap-4 mb-6">
                    <button onclick="setDiceBet(1)" class="px-4 py-2 rounded-full font-bold ${state.diceBetAmount==1?'bg-yellow-500 text-black':'bg-slate-600'}">1</button>
                    <button onclick="setDiceBet(5)" class="px-4 py-2 rounded-full font-bold ${state.diceBetAmount==5?'bg-yellow-500 text-black':'bg-slate-600'}">5</button>
                    <button onclick="setDiceBet(10)" class="px-4 py-2 rounded-full font-bold ${state.diceBetAmount==10?'bg-yellow-500 text-black':'bg-slate-600'}">10</button>
                </div>
                <div class="flex gap-4">
                    <button onclick="rollDice('High')" ${state.isGameActive?'disabled':''} class="flex-1 bg-green-600 hover:bg-green-700 py-5 rounded-xl font-bold text-2xl">HIGH (7+)</button>
                    <button onclick="rollDice('Low')" ${state.isGameActive?'disabled':''} class="flex-1 bg-red-600 hover:bg-red-700 py-5 rounded-xl font-bold text-2xl">LOW (6-)</button>
                </div>
            </div>`}

            <footer class="mt-12 pt-6 border-t border-slate-700 text-center">
                <p class="text-xs text-slate-400 mb-4">Simulation • BNCL has no real value</p>
                <button onclick="logout()" class="w-full bg-red-600 hover:bg-red-700 py-3 rounded font-bold text-lg">Logout</button>
            </footer>
        `;
    };

    // START
    if (document.cookie.includes('PHPSESSID')) loadBalance();
    else showLogin();
</script>
</body>
</html>
