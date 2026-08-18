<?php
// includes/navbar.php - Navigation Header for Cippy Dimsum POS
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cippy Dimsum - POS Kasir & Rekap Keuangan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Export Libraries & Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pastel: {
                            bg: '#FFFDF9',
                            card: '#FFFFFF',
                            peach: '#FFBFA9',
                            coral: '#FF9EAA',
                            coralDark: '#E67382',
                            cream: '#FFE5AD',
                            creamSoft: '#FFF3D6',
                            orange: '#FF9F1C',
                            brown: '#4A3728',
                            brownLight: '#7A6250',
                            mint: '#A8DADC',
                            mintSoft: '#E8F5E9'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Quicksand', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FFFDF9;
            color: #4A3728;
        }
        .font-display {
            font-family: 'Quicksand', sans-serif;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #FFF3D6;
        }
        ::-webkit-scrollbar-thumb {
            background: #FFBFA9;
            border-radius: 99px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #FF9EAA;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-pastel-peach selection:text-pastel-brown">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-pastel-peach/30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand Name -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-gradient-to-tr from-pastel-coral to-pastel-cream flex items-center justify-center shadow-xs text-white font-black text-lg sm:text-xl font-display transform hover:rotate-6 transition-transform duration-300">
                        🥟
                    </div>
                    <div>
                        <h1 class="font-display font-extrabold text-base sm:text-xl tracking-tight text-pastel-brown flex items-center gap-1.5 sm:gap-2">
                            Cippy Dimsum
                            <span class="text-[9px] sm:text-[10px] font-sans font-bold bg-pastel-coral/20 text-pastel-coralDark px-2 py-0.5 rounded-full uppercase tracking-wider">Kasir</span>
                        </h1>
                        <p class="text-[10px] sm:text-xs text-pastel-brownLight font-medium">Lumer di Mulut, Nagih di Hati ♡</p>
                    </div>
                </div>

                <!-- Desktop Navigation Tabs -->
                <nav class="hidden md:flex items-center gap-2">
                    <a href="index.php" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium text-sm transition-all duration-200 <?php echo $currentPage === 'index.php' ? 'bg-pastel-coral text-white shadow-sm font-semibold' : 'text-pastel-brownLight hover:bg-pastel-creamSoft hover:text-pastel-brown'; ?>">
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        <span>Mesin Kasir</span>
                    </a>
                    
                    <a href="reports.php" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium text-sm transition-all duration-200 <?php echo $currentPage === 'reports.php' ? 'bg-pastel-coral text-white shadow-sm font-semibold' : 'text-pastel-brownLight hover:bg-pastel-creamSoft hover:text-pastel-brown'; ?>">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                        <span>Rekap Keuangan</span>
                    </a>

                    <a href="menu.php" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium text-sm transition-all duration-200 <?php echo $currentPage === 'menu.php' ? 'bg-pastel-coral text-white shadow-sm font-semibold' : 'text-pastel-brownLight hover:bg-pastel-creamSoft hover:text-pastel-brown'; ?>">
                        <i data-lucide="utensils" class="w-4 h-4"></i>
                        <span>Kelola Menu</span>
                    </a>
                </nav>

                <!-- Time Clock Indicator -->
                <div class="flex items-center gap-1.5 bg-pastel-creamSoft/80 px-2.5 py-1.5 rounded-xl border border-pastel-cream text-xs font-semibold text-pastel-brown">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-pastel-orange"></i>
                    <span id="navClock">--:--:--</span>
                </div>

            </div>
        </div>
    </header>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-lg border-t border-pastel-peach/30 shadow-lg px-4 py-2 flex items-center justify-around">
        <a href="index.php" class="flex flex-col items-center gap-1 px-3 py-1 rounded-xl transition-all <?php echo $currentPage === 'index.php' ? 'text-pastel-coral font-bold' : 'text-pastel-brownLight hover:text-pastel-brown'; ?>">
            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
            <span class="text-[10px]">Kasir</span>
        </a>
        <a href="reports.php" class="flex flex-col items-center gap-1 px-3 py-1 rounded-xl transition-all <?php echo $currentPage === 'reports.php' ? 'text-pastel-coral font-bold' : 'text-pastel-brownLight hover:text-pastel-brown'; ?>">
            <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
            <span class="text-[10px]">Rekap</span>
        </a>
        <a href="menu.php" class="flex flex-col items-center gap-1 px-3 py-1 rounded-xl transition-all <?php echo $currentPage === 'menu.php' ? 'text-pastel-coral font-bold' : 'text-pastel-brownLight hover:text-pastel-brown'; ?>">
            <i data-lucide="utensils" class="w-5 h-5"></i>
            <span class="text-[10px]">Menu</span>
        </a>
    </nav>

    <!-- GLOBAL TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed top-20 right-4 z-50 flex flex-col gap-2 pointer-events-none max-w-sm w-full px-2"></div>

    <!-- GLOBAL PASTEL CONFIRMATION MODAL -->
    <div id="customConfirmModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl border border-pastel-peach/40 overflow-hidden text-center p-6 space-y-4 animate-in fade-in zoom-in duration-200">
            <div id="confirmIconBg" class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold">
                ❓
            </div>
            <div>
                <h3 class="font-display font-extrabold text-lg text-pastel-brown" id="confirmTitle">Konfirmasi</h3>
                <p class="text-xs text-pastel-brownLight mt-1" id="confirmMessage">Apakah Anda yakin?</p>
            </div>
            <div class="grid grid-cols-2 gap-2 pt-2">
                <button onclick="closeConfirmModal(false)" class="py-2.5 bg-gray-100 hover:bg-gray-200 text-pastel-brown font-bold text-xs rounded-xl transition-all">
                    Batal
                </button>
                <button id="btnConfirmAction" class="py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs rounded-xl shadow-xs transition-all">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const clockEl = document.getElementById('navClock');
            if(clockEl) {
                const now = new Date();
                clockEl.innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // --- GLOBAL ANIMATED TOAST SYSTEM ---
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if(!container) return;

            const toast = document.createElement('div');
            
            let bgClass = 'bg-emerald-500 text-white';
            let icon = '✓';
            if(type === 'error') {
                bgClass = 'bg-rose-500 text-white';
                icon = '✕';
            } else if(type === 'warning') {
                bgClass = 'bg-amber-500 text-white';
                icon = '⚠️';
            }

            toast.className = `pointer-events-auto flex items-center gap-3 p-3.5 rounded-2xl shadow-xl ${bgClass} font-medium text-xs transform transition-all duration-300 translate-y-[-10px] opacity-0 animate-in slide-in-from-top-4 duration-300`;
            toast.innerHTML = `
                <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">${icon}</span>
                <span class="flex-1">${message}</span>
            `;

            container.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-y-[-10px]', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-[-10px]');
                setTimeout(() => toast.remove(), 300);
            }, 3200);
        }

        // --- GLOBAL PASTEL CONFIRM MODAL ---
        let confirmResolver = null;

        function customConfirm({ title = 'Konfirmasi', message = 'Apakah Anda yakin?', icon = '❓', buttonText = 'Ya, Lanjutkan', buttonClass = 'bg-rose-500 hover:bg-rose-600' }) {
            return new Promise((resolve) => {
                confirmResolver = resolve;
                
                document.getElementById('confirmTitle').innerText = title;
                document.getElementById('confirmMessage').innerText = message;
                document.getElementById('confirmIconBg').innerText = icon;
                
                const btnAction = document.getElementById('btnConfirmAction');
                btnAction.innerText = buttonText;
                btnAction.className = `py-2.5 ${buttonClass} text-white font-bold text-xs rounded-xl shadow-xs transition-all`;
                
                btnAction.onclick = () => {
                    closeConfirmModal(true);
                };

                const modal = document.getElementById('customConfirmModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        }

        function closeConfirmModal(result) {
            const modal = document.getElementById('customConfirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if(confirmResolver) {
                confirmResolver(result);
                confirmResolver = null;
            }
        }

        // --- CELEBRATION CONFETTI ANIMATION ---
        function triggerSuccessConfetti() {
            if(typeof confetti === 'function') {
                confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.6 },
                    colors: ['#FFBFA9', '#FF9EAA', '#FFE5AD', '#FF9F1C', '#A8DADC']
                });
            }
        }
    </script>
