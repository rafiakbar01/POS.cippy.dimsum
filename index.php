<?php
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- Main Content Area -->
<main class="flex-1 max-w-7xl w-full mx-auto p-3 sm:p-6 lg:p-8 flex flex-col lg:flex-row gap-6 pb-28 lg:pb-8">

    <!-- LEFT SIDE: MENU SELECTION & CATALOG -->
    <div class="flex-1 flex flex-col gap-4 sm:gap-5">
        
        <!-- Header Banner & Variant Toggle -->
        <div class="bg-gradient-to-r from-pastel-creamSoft via-white to-pastel-creamSoft rounded-2xl p-4 sm:p-5 border border-pastel-cream/80 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div>
                <h2 class="font-display font-bold text-base sm:text-lg text-pastel-brown flex items-center gap-2">
                    <span>Pilih Varian Dimsum</span>
                </h2>
                <p class="text-[11px] sm:text-xs text-pastel-brownLight mt-0.5" id="variantSubtitle">Varian Cippy Dimsum Mini - Kecil-Kecil, Nikmatnya Juara!</p>
            </div>

            <!-- Variant Switcher Buttons -->
            <div class="flex bg-white p-1 rounded-xl border border-pastel-peach/40 shadow-xs w-full sm:w-auto">
                <button onclick="setVariant('mini')" id="btnVariantMini" class="flex-1 sm:flex-none px-4 py-2.5 sm:py-2 rounded-lg font-display font-bold text-xs sm:text-sm transition-all duration-200 bg-pastel-coral text-white shadow-xs flex items-center justify-center gap-1.5 active:scale-95">
                    <span>🥟 Dimsum Mini</span>
                </button>
                <button onclick="setVariant('besar')" id="btnVariantBesar" class="flex-1 sm:flex-none px-4 py-2.5 sm:py-2 rounded-lg font-display font-bold text-xs sm:text-sm transition-all duration-200 text-pastel-brownLight hover:text-pastel-brown flex items-center justify-center gap-1.5 active:scale-95">
                    <span>🥟 Dimsum Besar</span>
                </button>
            </div>
        </div>

        <!-- Search Bar & Category Filters -->
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
            
            <!-- Category Pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-2 sm:pb-0 scrollbar-none snap-x" id="categoryContainer">
                <button onclick="setCategory('all')" data-cat="all" class="cat-btn active px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-pastel-brown text-white shadow-xs snap-start">
                    Semua Menu
                </button>
                <button onclick="setCategory('Mentai / Mayo Cheese')" data-cat="Mentai / Mayo Cheese" class="cat-btn px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-white text-pastel-brownLight hover:bg-pastel-creamSoft border border-pastel-cream snap-start">
                    Mentai / Mayo
                </button>
                <button onclick="setCategory('Dimsum Lava')" data-cat="Dimsum Lava" class="cat-btn px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-white text-pastel-brownLight hover:bg-pastel-creamSoft border border-pastel-cream snap-start">
                    Dimsum Lava 🔥
                </button>
                <button onclick="setCategory('Dimsum Original')" data-cat="Dimsum Original" class="cat-btn px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-white text-pastel-brownLight hover:bg-pastel-creamSoft border border-pastel-cream snap-start">
                    Original
                </button>
                <button onclick="setCategory('Dimsum Bakar')" data-cat="Dimsum Bakar" class="cat-btn px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-white text-pastel-brownLight hover:bg-pastel-creamSoft border border-pastel-cream snap-start">
                    Dimsum Bakar
                </button>
                <button onclick="setCategory('Party Box Mix')" data-cat="Party Box Mix" class="cat-btn px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-white text-pastel-brownLight hover:bg-pastel-creamSoft border border-pastel-cream snap-start">
                    Party Box 📦
                </button>
            </div>

            <!-- Search Input -->
            <div class="relative w-full sm:w-56">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-pastel-brownLight"></i>
                <input type="text" id="searchInput" oninput="renderMenus()" placeholder="Cari menu..." class="w-full pl-9 pr-3 py-2 sm:py-1.5 text-xs bg-white rounded-full border border-pastel-cream focus:outline-none focus:ring-2 focus:ring-pastel-coral/50 text-pastel-brown font-medium shadow-xs">
            </div>

        </div>

        <!-- Menu Items Grid -->
        <div id="menuGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <!-- Dynamic Menu Cards loaded via JS -->
        </div>

    </div>

    <!-- RIGHT SIDE: DESKTOP CART PANEL (Visible on lg screens) -->
    <div class="hidden lg:flex w-96 flex-col bg-white rounded-2xl border border-pastel-peach/30 shadow-sm p-5 h-fit sticky top-20">
        
        <div class="flex items-center justify-between pb-3 border-b border-pastel-cream font-display">
            <div class="flex items-center gap-2">
                <div class="p-2 bg-pastel-coral/15 text-pastel-coralDark rounded-xl">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-pastel-brown">Pesanan Kasir</h3>
                    <p class="text-[11px] text-pastel-brownLight" id="cartItemCount">0 item dipilih</p>
                </div>
            </div>

            <button onclick="clearCart()" class="text-xs text-rose-500 hover:text-rose-700 font-semibold px-2 py-1 rounded-lg hover:bg-rose-50 transition-colors flex items-center gap-1">
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                <span>Kosongkan</span>
            </button>
        </div>

        <!-- Cart Items Scroll Area -->
        <div id="cartItemsList" class="flex-1 my-3 overflow-y-auto max-h-[340px] space-y-2.5 pr-1">
            <!-- Dynamic Cart Items loaded via JS -->
        </div>

        <!-- Order Note & Totals -->
        <div class="pt-3 border-t border-pastel-cream space-y-3">
            <div>
                <label class="block text-[11px] font-bold text-pastel-brownLight mb-1 flex items-center gap-1">
                    <i data-lucide="sticky-note" class="w-3 h-3 text-pastel-orange"></i>
                    <span>Catatan Pesanan (Opsional)</span>
                </label>
                <input type="text" id="customerNote" placeholder="Contoh: Saus dipisah, tanpa cabe..." class="w-full px-3 py-2 text-xs bg-pastel-creamSoft/40 rounded-xl border border-pastel-cream focus:outline-none focus:ring-1 focus:ring-pastel-coral text-pastel-brown">
            </div>

            <div class="bg-pastel-creamSoft/50 p-3 rounded-xl space-y-1.5 border border-pastel-cream/60">
                <div class="flex justify-between text-xs text-pastel-brownLight">
                    <span>Subtotal</span>
                    <span id="subtotalText" class="font-bold text-pastel-brown">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm text-pastel-brown font-extrabold pt-1 border-t border-pastel-cream/80">
                    <span>Total Pembayaran</span>
                    <span id="totalText" class="text-pastel-coralDark font-display text-base">Rp 0</span>
                </div>
            </div>

            <button onclick="openPaymentModal()" id="btnCheckout" disabled class="w-full py-3.5 bg-pastel-coral hover:bg-pastel-coralDark disabled:bg-gray-200 disabled:text-gray-400 text-white rounded-xl font-display font-bold text-sm shadow-md transition-all duration-200 flex items-center justify-center gap-2 active:scale-98">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                <span>Pilih Pembayaran</span>
            </button>
        </div>

    </div>

</main>


<!-- FLOATING MOBILE CART BAR (Visible on Mobile) -->
<div id="mobileCartFloatingBar" class="lg:hidden fixed bottom-14 left-0 right-0 z-30 px-3 pb-2 transition-all duration-300 transform translate-y-full opacity-0 pointer-events-none">
    <div onclick="openMobileCartModal()" class="bg-pastel-brown text-white p-3 sm:p-3.5 rounded-2xl shadow-xl border border-pastel-peach/40 flex items-center justify-between cursor-pointer active:scale-98">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-pastel-coral flex items-center justify-center text-white font-extrabold text-sm shadow-xs">
                <span id="mobileCartBadge">0</span>
            </div>
            <div>
                <p class="text-[10px] text-pastel-cream font-medium uppercase tracking-wider">Total Pesanan</p>
                <p class="font-display font-bold text-base text-white" id="mobileCartTotal">Rp 0</p>
            </div>
        </div>

        <div class="flex items-center gap-1.5 bg-pastel-coral text-white px-3.5 py-2 rounded-xl font-bold text-xs shadow-xs">
            <span>Lihat Keranjang</span>
            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
        </div>
    </div>
</div>


<!-- DEDICATED MOBILE CART MODAL (Full Responsive Bottom Sheet) -->
<div id="mobileCartModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-end justify-center p-0 lg:hidden">
    <div class="bg-white w-full rounded-t-3xl shadow-2xl border-t border-pastel-peach/40 overflow-hidden flex flex-col max-h-[85vh] animate-in slide-in-from-bottom duration-200">
        
        <div class="bg-pastel-creamSoft p-4 border-b border-pastel-cream flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="p-1.5 bg-pastel-coral/15 text-pastel-coralDark rounded-lg">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </div>
                <h3 class="font-display font-bold text-base text-pastel-brown">Keranjang Pesanan</h3>
            </div>
            
            <div class="flex items-center gap-2">
                <button onclick="clearCart()" class="text-xs text-rose-500 font-semibold px-2 py-1 rounded-lg bg-rose-50">
                    Kosongkan
                </button>
                <button onclick="closeMobileCartModal()" class="text-pastel-brownLight p-1 rounded-lg">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Scrollable Mobile Cart Items -->
        <div id="mobileCartItemsList" class="p-4 overflow-y-auto space-y-2.5 flex-1">
            <!-- Dynamic Cart Items -->
        </div>

        <!-- Mobile Cart Footer -->
        <div class="p-4 border-t border-pastel-cream bg-pastel-creamSoft/30 space-y-3">
            <div>
                <input type="text" id="mobileCustomerNote" oninput="syncCustomerNote(this.value)" placeholder="Catatan pesanan (opsional)..." class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-pastel-cream text-pastel-brown">
            </div>

            <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-pastel-cream">
                <span class="text-xs text-pastel-brownLight font-medium">Total Tagihan:</span>
                <span id="mobileTotalText" class="font-display font-extrabold text-lg text-pastel-coralDark">Rp 0</span>
            </div>

            <button onclick="closeMobileCartModal(); openPaymentModal();" id="mobileBtnCheckout" disabled class="w-full py-3.5 bg-pastel-coral hover:bg-pastel-coralDark disabled:bg-gray-200 disabled:text-gray-400 text-white rounded-xl font-display font-bold text-sm shadow-md transition-all">
                Pilih Pembayaran
            </button>
        </div>

    </div>
</div>


<!-- MODAL PEMBAYARAN (With Added 15k, 25k, 55k Buttons) -->
<div id="paymentModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-end sm:items-center justify-center p-0 sm:p-4">
    <div class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-2xl shadow-2xl border border-pastel-peach/40 overflow-hidden animate-in fade-in slide-in-from-bottom-6 sm:zoom-in duration-200 max-h-[92vh] flex flex-col">
        
        <div class="bg-pastel-creamSoft p-4 border-b border-pastel-cream flex items-center justify-between">
            <h3 class="font-display font-bold text-base text-pastel-brown flex items-center gap-2">
                <span>Metode Pembayaran</span>
            </h3>
            <button onclick="closePaymentModal()" class="text-pastel-brownLight hover:text-pastel-brown p-1.5 rounded-lg hover:bg-white/60">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="p-4 sm:p-5 space-y-4 overflow-y-auto">
            
            <!-- Summary Amount -->
            <div class="bg-pastel-peach/10 p-3.5 rounded-2xl border border-pastel-peach/30 text-center">
                <p class="text-xs text-pastel-brownLight font-medium">Total Tagihan</p>
                <p class="font-display font-extrabold text-2xl text-pastel-coralDark" id="modalTotalText">Rp 0</p>
            </div>

            <!-- Payment Method Buttons -->
            <div>
                <label class="block text-xs font-bold text-pastel-brown mb-2">Pilih Cara Bayar (Info)</label>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="selectPaymentMethod('Tunai')" id="pmTunai" class="pm-btn active border-2 border-pastel-coral bg-pastel-coral/10 text-pastel-coralDark p-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95">
                        <span>💵 Tunai (Cash)</span>
                    </button>
                    <button type="button" onclick="selectPaymentMethod('QRIS')" id="pmQRIS" class="pm-btn border-2 border-gray-200 text-pastel-brownLight p-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95">
                        <span>📱 QRIS</span>
                    </button>
                    <button type="button" onclick="selectPaymentMethod('Transfer')" id="pmTransfer" class="pm-btn border-2 border-gray-200 text-pastel-brownLight p-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95">
                        <span>🏦 Transfer Bank</span>
                    </button>
                    <button type="button" onclick="selectPaymentMethod('Debit')" id="pmDebit" class="pm-btn border-2 border-gray-200 text-pastel-brownLight p-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95">
                        <span>💳 Debit / EDC</span>
                    </button>
                </div>
            </div>

            <!-- Cash Input Section (With 15k, 25k, 55k Buttons) -->
            <div id="cashInputSection" class="space-y-2.5 pt-2 border-t border-pastel-cream">
                <label class="block text-xs font-bold text-pastel-brown">Uang Diterima (Rp)</label>
                <input type="number" id="cashGivenInput" oninput="calculateChange()" placeholder="0" class="w-full px-3 py-2.5 text-lg font-bold bg-white rounded-xl border border-pastel-peach focus:outline-none focus:ring-2 focus:ring-pastel-coral text-pastel-brown">
                
                <!-- Quick Cash Buttons Grid (2 Rows of 4 Buttons: Pas, 10k, 15k, 20k, 25k, 50k, 55k, 100k) -->
                <div class="space-y-1.5 pt-1">
                    <div class="grid grid-cols-4 gap-1.5">
                        <button type="button" onclick="setQuickCash('pas')" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream">Pas</button>
                        <button type="button" onclick="setQuickCash(10000)" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream">10k</button>
                        <button type="button" onclick="setQuickCash(15000)" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream font-extrabold text-pastel-coralDark">15k</button>
                        <button type="button" onclick="setQuickCash(20000)" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream">20k</button>
                    </div>

                    <div class="grid grid-cols-4 gap-1.5">
                        <button type="button" onclick="setQuickCash(25000)" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream font-extrabold text-pastel-coralDark">25k</button>
                        <button type="button" onclick="setQuickCash(50000)" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream">50k</button>
                        <button type="button" onclick="setQuickCash(55000)" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream font-extrabold text-pastel-coralDark">55k</button>
                        <button type="button" onclick="setQuickCash(100000)" class="py-2 bg-pastel-creamSoft hover:bg-pastel-cream active:bg-pastel-cream text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream">100k</button>
                    </div>
                </div>

                <!-- Change Output -->
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200 mt-2">
                    <span class="text-xs font-medium text-pastel-brownLight">Kembalian:</span>
                    <span id="changeText" class="font-display font-extrabold text-base text-pastel-brown">Rp 0</span>
                </div>
            </div>

            <!-- Submit Transaction Button -->
            <button onclick="submitCheckout()" id="btnSubmitPayment" class="w-full py-3.5 bg-pastel-coral hover:bg-pastel-coralDark text-white rounded-xl font-display font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2 active:scale-98">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>Konfirmasi & Simpan Transaksi</span>
            </button>

        </div>

    </div>
</div>


<!-- MODAL SUKSES TRANSAKSI -->
<div id="successModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl border border-pastel-peach/40 overflow-hidden text-center p-6 space-y-4 animate-in fade-in zoom-in duration-200">
        
        <div class="w-16 h-16 bg-pastel-mintSoft text-emerald-600 rounded-full flex items-center justify-center mx-auto text-2xl shadow-inner font-black">
            ✓
        </div>

        <div>
            <h3 class="font-display font-extrabold text-xl text-pastel-brown">Transaksi Berhasil!</h3>
            <p class="text-xs text-pastel-brownLight mt-1 font-mono font-semibold" id="successTxCode">CIPPY-20260818-0001</p>
        </div>

        <div class="bg-pastel-creamSoft/60 p-4 rounded-2xl border border-pastel-cream text-left space-y-2 text-xs">
            <div class="flex justify-between">
                <span class="text-pastel-brownLight">Waktu:</span>
                <span id="successTime" class="font-bold text-pastel-brown">--:--</span>
            </div>
            <div class="flex justify-between">
                <span class="text-pastel-brownLight">Metode Bayar:</span>
                <span id="successMethod" class="font-bold text-pastel-brown">Tunai</span>
            </div>
            <div class="flex justify-between border-t border-pastel-cream/80 pt-2">
                <span class="text-pastel-brownLight">Total Bayar:</span>
                <span id="successTotal" class="font-bold text-pastel-coralDark text-sm">Rp 0</span>
            </div>
            <div id="successCashRow" class="flex justify-between">
                <span class="text-pastel-brownLight">Kembalian:</span>
                <span id="successChange" class="font-bold text-pastel-brown">Rp 0</span>
            </div>
        </div>

        <button onclick="closeSuccessModal()" class="w-full py-3.5 bg-pastel-coral hover:bg-pastel-coralDark text-white rounded-xl font-display font-bold text-sm shadow-xs transition-all active:scale-98">
            + Transaksi Baru
        </button>

    </div>
</div>

<script>
    let allMenus = [];
    let currentVariant = 'mini'; // 'mini' or 'besar'
    let currentCategory = 'all';
    let cart = [];
    let selectedPaymentMethod = 'Tunai';

    document.addEventListener('DOMContentLoaded', () => {
        loadMenus();
    });

    async function loadMenus() {
        try {
            const res = await fetch('api/pos.php?action=get_menus');
            const result = await res.json();
            if(result.status === 'success') {
                allMenus = result.data;
                renderMenus();
            }
        } catch (e) {
            console.error('Error loading menus:', e);
        }
    }

    function setVariant(variant) {
        currentVariant = variant;
        
        const btnMini = document.getElementById('btnVariantMini');
        const btnBesar = document.getElementById('btnVariantBesar');
        const subtitle = document.getElementById('variantSubtitle');

        if(variant === 'mini') {
            btnMini.className = 'flex-1 sm:flex-none px-4 py-2.5 sm:py-2 rounded-lg font-display font-bold text-xs sm:text-sm transition-all duration-200 bg-pastel-coral text-white shadow-xs flex items-center justify-center gap-1.5 active:scale-95';
            btnBesar.className = 'flex-1 sm:flex-none px-4 py-2.5 sm:py-2 rounded-lg font-display font-bold text-xs sm:text-sm transition-all duration-200 text-pastel-brownLight hover:text-pastel-brown flex items-center justify-center gap-1.5 active:scale-95';
            subtitle.innerText = 'Varian Cippy Dimsum Mini - Kecil-Kecil, Nikmatnya Juara!';
        } else {
            btnBesar.className = 'flex-1 sm:flex-none px-4 py-2.5 sm:py-2 rounded-lg font-display font-bold text-xs sm:text-sm transition-all duration-200 bg-pastel-coral text-white shadow-xs flex items-center justify-center gap-1.5 active:scale-95';
            btnMini.className = 'flex-1 sm:flex-none px-4 py-2.5 sm:py-2 rounded-lg font-display font-bold text-xs sm:text-sm transition-all duration-200 text-pastel-brownLight hover:text-pastel-brown flex items-center justify-center gap-1.5 active:scale-95';
            subtitle.innerText = 'Varian Cippy Dimsum Besar - Lumer di Mulut, Nagih di Hati ♡';
        }

        renderMenus();
    }

    function setCategory(cat) {
        currentCategory = cat;
        document.querySelectorAll('.cat-btn').forEach(btn => {
            if(btn.getAttribute('data-cat') === cat) {
                btn.className = 'cat-btn active px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-pastel-brown text-white shadow-xs snap-start';
            } else {
                btn.className = 'cat-btn px-3.5 py-2 sm:py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all bg-white text-pastel-brownLight hover:bg-pastel-creamSoft border border-pastel-cream snap-start';
            }
        });
        renderMenus();
    }

    function renderMenus() {
        const grid = document.getElementById('menuGrid');
        const search = document.getElementById('searchInput').value.toLowerCase().trim();

        const filtered = allMenus.filter(m => {
            const matchesVariant = m.variant === currentVariant;
            const matchesCat = (currentCategory === 'all') || (m.category === currentCategory);
            const matchesSearch = m.name.toLowerCase().includes(search) || m.category.toLowerCase().includes(search);
            return matchesVariant && matchesCat && matchesSearch;
        });

        if(filtered.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full py-12 text-center text-pastel-brownLight/60">
                    <p class="text-sm font-medium">Menu tidak ditemukan</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = filtered.map(m => `
            <div class="bg-white rounded-2xl p-3 sm:p-4 border border-pastel-peach/30 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                        <span class="text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-md ${m.variant === 'mini' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800'}">
                            ${m.variant.toUpperCase()}
                        </span>
                        <span class="text-[10px] sm:text-[11px] font-medium text-pastel-brownLight bg-pastel-creamSoft px-1.5 sm:px-2 py-0.5 rounded-md truncate max-w-[100px] sm:max-w-none">
                            ${m.category}
                        </span>
                    </div>

                    <h4 class="font-display font-bold text-xs sm:text-sm text-pastel-brown group-hover:text-pastel-coralDark transition-colors line-clamp-2">
                        ${m.name}
                    </h4>
                    
                    ${m.portion ? `<p class="text-[11px] sm:text-xs text-pastel-brownLight mt-1 flex items-center gap-1"><i data-lucide="package" class="w-3 h-3 text-pastel-orange"></i> ${m.portion}</p>` : ''}
                </div>

                <div class="mt-3 sm:mt-4 pt-2.5 sm:pt-3 border-t border-pastel-cream/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <div>
                        <p class="text-[9px] sm:text-[10px] text-pastel-brownLight font-medium">Harga</p>
                        <p class="font-display font-extrabold text-sm sm:text-base text-pastel-coralDark">
                            Rp ${parseInt(m.price).toLocaleString('id-ID')}
                        </p>
                    </div>

                    <button onclick="addToCart(${m.id})" class="w-full sm:w-auto px-3 py-2 bg-pastel-creamSoft hover:bg-pastel-coral hover:text-white active:bg-pastel-coral active:text-white text-pastel-brown font-bold text-xs rounded-xl shadow-xs transition-all duration-200 flex items-center justify-center gap-1 active:scale-95">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Tambah</span>
                    </button>
                </div>
            </div>
        `).join('');

        lucide.createIcons();
    }

    function addToCart(menuId) {
        const item = allMenus.find(m => m.id === menuId);
        if(!item) return;

        const existing = cart.find(c => c.id === menuId);
        if(existing) {
            existing.quantity++;
        } else {
            cart.push({
                ...item,
                quantity: 1,
                note: ''
            });
        }

        renderCart();
    }

    function updateCartQty(menuId, delta) {
        const index = cart.findIndex(c => c.id === menuId);
        if(index > -1) {
            cart[index].quantity += delta;
            if(cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
        }
        renderCart();
    }

    function updateCartItemNote(menuId, note) {
        const item = cart.find(c => c.id === menuId);
        if(item) {
            item.note = note;
        }
    }

    function syncCustomerNote(val) {
        document.getElementById('customerNote').value = val;
    }

    function clearCart() {
        cart = [];
        renderCart();
        closeMobileCartModal();
    }

    function openMobileCartModal() {
        const modal = document.getElementById('mobileCartModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeMobileCartModal() {
        const modal = document.getElementById('mobileCartModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function renderCart() {
        const container = document.getElementById('cartItemsList');
        const mobileContainer = document.getElementById('mobileCartItemsList');
        
        const cartCount = document.getElementById('cartItemCount');
        const subtotalText = document.getElementById('subtotalText');
        const totalText = document.getElementById('totalText');
        const mobileTotalText = document.getElementById('mobileTotalText');
        
        const btnCheckout = document.getElementById('btnCheckout');
        const mobileBtnCheckout = document.getElementById('mobileBtnCheckout');

        const totalItems = cart.reduce((sum, i) => sum + i.quantity, 0);
        const grandTotal = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);

        const totalFormatted = `Rp ${grandTotal.toLocaleString('id-ID')}`;

        cartCount.innerText = `${totalItems} item dipilih`;
        subtotalText.innerText = totalFormatted;
        totalText.innerText = totalFormatted;
        mobileTotalText.innerText = totalFormatted;

        btnCheckout.disabled = cart.length === 0;
        mobileBtnCheckout.disabled = cart.length === 0;

        // Mobile Floating Bar Updates
        const mobileFloatingBar = document.getElementById('mobileCartFloatingBar');
        const mobileCartBadge = document.getElementById('mobileCartBadge');
        const mobileCartTotal = document.getElementById('mobileCartTotal');

        if(totalItems > 0) {
            mobileCartBadge.innerText = totalItems;
            mobileCartTotal.innerText = totalFormatted;
            mobileFloatingBar.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');
        } else {
            mobileFloatingBar.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');
        }

        const emptyHtml = `
            <div class="py-10 text-center text-pastel-brownLight/60 flex flex-col items-center justify-center">
                <i data-lucide="shopping-bag" class="w-12 h-12 stroke-[1.5] mb-2 text-pastel-peach"></i>
                <p class="text-xs font-medium">Belum ada menu yang dipilih</p>
                <p class="text-[10px] text-pastel-brownLight/40 mt-1">Klik item menu di sebelah kiri untuk menambah</p>
            </div>
        `;

        if(cart.length === 0) {
            container.innerHTML = emptyHtml;
            mobileContainer.innerHTML = emptyHtml;
            lucide.createIcons();
            return;
        }

        const cartHtml = cart.map(item => `
            <div class="p-2.5 bg-pastel-creamSoft/30 rounded-xl border border-pastel-cream/80 space-y-1.5">
                <div class="flex items-start justify-between">
                    <div>
                        <h5 class="font-display font-bold text-xs text-pastel-brown">${item.name}</h5>
                        <p class="text-[10px] text-pastel-brownLight">Rp ${parseInt(item.price).toLocaleString('id-ID')} / pcs</p>
                    </div>
                    <span class="font-bold text-xs text-pastel-coralDark">
                        Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
                    </span>
                </div>

                <div class="flex items-center justify-between pt-1 gap-2">
                    <input type="text" value="${item.note || ''}" onchange="updateCartItemNote(${item.id}, this.value)" placeholder="Catatan item..." class="w-full px-2 py-1 text-[10px] bg-white rounded-lg border border-pastel-cream text-pastel-brown focus:outline-none">
                    
                    <div class="flex items-center gap-2 bg-white px-2 py-1 rounded-lg border border-pastel-cream">
                        <button onclick="updateCartQty(${item.id}, -1)" class="text-pastel-brownLight hover:text-pastel-coral font-bold text-sm px-1.5 py-0.5 active:scale-95">-</button>
                        <span class="font-bold text-xs text-pastel-brown w-4 text-center">${item.quantity}</span>
                        <button onclick="updateCartQty(${item.id}, 1)" class="text-pastel-brownLight hover:text-pastel-coral font-bold text-sm px-1.5 py-0.5 active:scale-95">+</button>
                    </div>
                </div>
            </div>
        `).join('');

        container.innerHTML = cartHtml;
        mobileContainer.innerHTML = cartHtml;

        lucide.createIcons();
    }

    function openPaymentModal() {
        if(cart.length === 0) return;
        const grandTotal = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
        document.getElementById('modalTotalText').innerText = `Rp ${grandTotal.toLocaleString('id-ID')}`;
        
        document.getElementById('cashGivenInput').value = grandTotal;
        calculateChange();

        document.getElementById('paymentModal').classList.remove('hidden');
        document.getElementById('paymentModal').classList.add('flex');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.getElementById('paymentModal').classList.remove('flex');
    }

    function selectPaymentMethod(method) {
        selectedPaymentMethod = method;
        document.querySelectorAll('.pm-btn').forEach(btn => {
            btn.className = 'pm-btn border-2 border-gray-200 text-pastel-brownLight p-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95';
        });

        const activeBtn = document.getElementById('pm' + method);
        if(activeBtn) {
            activeBtn.className = 'pm-btn active border-2 border-pastel-coral bg-pastel-coral/10 text-pastel-coralDark p-3 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95';
        }

        const cashSec = document.getElementById('cashInputSection');
        if(method === 'Tunai') {
            cashSec.style.display = 'block';
        } else {
            cashSec.style.display = 'none';
        }
    }

    function setQuickCash(val) {
        const grandTotal = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
        const cashInput = document.getElementById('cashGivenInput');
        if(val === 'pas') {
            cashInput.value = grandTotal;
        } else {
            cashInput.value = val;
        }
        calculateChange();
    }

    function calculateChange() {
        const grandTotal = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
        const cashGiven = parseInt(document.getElementById('cashGivenInput').value) || 0;
        const change = Math.max(0, cashGiven - grandTotal);
        document.getElementById('changeText').innerText = `Rp ${change.toLocaleString('id-ID')}`;
    }

    async function submitCheckout() {
        if(cart.length === 0) return;
        
        const grandTotal = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
        const cashGiven = parseInt(document.getElementById('cashGivenInput').value) || 0;
        const customerNote = document.getElementById('customerNote').value || document.getElementById('mobileCustomerNote').value;

        if(selectedPaymentMethod === 'Tunai' && cashGiven < grandTotal) {
            showToast('Uang yang diberikan kurang dari total tagihan!', 'warning');
            return;
        }

        const payload = {
            items: cart,
            payment_method: selectedPaymentMethod,
            cash_given: (selectedPaymentMethod === 'Tunai') ? cashGiven : grandTotal,
            customer_note: customerNote
        };

        try {
            const btnSubmit = document.getElementById('btnSubmitPayment');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span>Memproses...</span>';

            const res = await fetch('api/pos.php?action=checkout', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const result = await res.json();

            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i data-lucide="check-circle" class="w-5 h-5"></i><span>Konfirmasi & Simpan Transaksi</span>';
            lucide.createIcons();

            if(result.status === 'success') {
                closePaymentModal();
                closeMobileCartModal();
                triggerSuccessConfetti(); // 🎉 Trigger Confetti Celebration Animation!
                
                // Save to LocalStorage Backup permanently so data never resets!
                try {
                    let localBackup = JSON.parse(localStorage.getItem('cippy_tx_history') || '[]');
                    localBackup.unshift({
                        ...result.data,
                        items: [...cart]
                    });
                    localStorage.setItem('cippy_tx_history', JSON.stringify(localBackup));
                } catch(err) {
                    console.error('LocalStorage Backup Error:', err);
                }

                showSuccessModal(result.data);
                cart = [];
                document.getElementById('customerNote').value = '';
                document.getElementById('mobileCustomerNote').value = '';
                renderCart();
            } else {
                showToast('Gagal menyimpan transaksi: ' + result.message, 'error');
            }

        } catch (e) {
            console.error('Checkout Error:', e);
            showToast('Terjadi kesalahan koneksi saat memproses checkout.', 'error');
        }
    }

    function showSuccessModal(data) {
        document.getElementById('successTxCode').innerText = data.transaction_code;
        document.getElementById('successTime').innerText = data.created_at;
        document.getElementById('successMethod').innerText = data.payment_method;
        document.getElementById('successTotal').innerText = `Rp ${parseInt(data.total_amount).toLocaleString('id-ID')}`;

        if(data.payment_method === 'Tunai') {
            document.getElementById('successCashRow').style.display = 'flex';
            document.getElementById('successChange').innerText = `Rp ${parseInt(data.change_amount).toLocaleString('id-ID')}`;
        } else {
            document.getElementById('successCashRow').style.display = 'none';
        }

        document.getElementById('successModal').classList.remove('hidden');
        document.getElementById('successModal').classList.add('flex');
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
        document.getElementById('successModal').classList.remove('flex');
    }
</script>

</body>
</html>
