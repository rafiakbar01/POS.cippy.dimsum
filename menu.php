<?php
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto p-3 sm:p-6 lg:p-8 space-y-4 sm:space-y-6 pb-24 sm:pb-8">

    <!-- Header Banner & Action Buttons -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-pastel-peach/30 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h2 class="font-display font-bold text-lg sm:text-xl text-pastel-brown flex items-center gap-2">
                <i data-lucide="utensils" class="w-5 h-5 sm:w-6 sm:h-6 text-pastel-coral"></i>
                <span>Kelola Menu & Harga Modal (HPP)</span>
            </h2>
            <p class="text-[11px] sm:text-xs text-pastel-brownLight mt-0.5 sm:mt-1">Atur daftar menu, harga jual, dan modal (HPP) untuk perhitungan untung rugi yang presisi.</p>
        </div>

        <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center w-full sm:w-auto">
            <button onclick="resetToDefaults()" class="px-3 py-2.5 bg-pastel-creamSoft hover:bg-pastel-cream active:scale-95 text-pastel-brown font-bold text-xs rounded-xl border border-pastel-cream shadow-xs transition-all flex items-center justify-center gap-1.5">
                <i data-lucide="rotate-ccw" class="w-4 h-4 text-pastel-orange"></i>
                <span>Reset Default</span>
            </button>

            <button onclick="openMenuModal()" class="px-3.5 py-2.5 bg-pastel-coral hover:bg-pastel-coralDark active:scale-95 text-white font-bold text-xs rounded-xl shadow-xs transition-all flex items-center justify-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Menu</span>
            </button>
        </div>
    </div>

    <!-- Menu List Table Container -->
    <div class="bg-white rounded-2xl border border-pastel-peach/30 shadow-xs overflow-hidden">
        <div class="p-3.5 sm:p-4 bg-pastel-creamSoft/40 border-b border-pastel-cream flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            
            <!-- Filters -->
            <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center w-full sm:w-auto">
                <select id="variantFilter" onchange="renderMenuTable()" class="px-3 py-2 bg-white text-xs font-bold text-pastel-brown rounded-xl border border-pastel-cream focus:outline-none">
                    <option value="all">Semua Varian</option>
                    <option value="mini">🥟 Dimsum Mini</option>
                    <option value="besar">🥟 Dimsum Besar</option>
                </select>

                <select id="categoryFilter" onchange="renderMenuTable()" class="px-3 py-2 bg-white text-xs font-bold text-pastel-brown rounded-xl border border-pastel-cream focus:outline-none">
                    <option value="all">Semua Kategori</option>
                    <option value="Mentai / Mayo Cheese">Mentai / Mayo</option>
                    <option value="Dimsum Lava">Dimsum Lava</option>
                    <option value="Dimsum Original">Original</option>
                    <option value="Dimsum Bakar">Dimsum Bakar</option>
                    <option value="Party Box Mix">Party Box Mix</option>
                </select>
            </div>

            <!-- Search -->
            <div class="relative w-full sm:w-56">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-pastel-brownLight"></i>
                <input type="text" id="menuSearchInput" oninput="renderMenuTable()" placeholder="Cari nama menu..." class="w-full pl-9 pr-3 py-2 text-xs bg-white rounded-full border border-pastel-cream focus:outline-none text-pastel-brown font-medium">
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-pastel-brown">
                <thead class="bg-pastel-creamSoft/80 font-display text-[10px] sm:text-[11px] font-bold text-pastel-brown uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-3 sm:px-4">Varian</th>
                        <th class="py-3 px-3 sm:px-4">Kategori</th>
                        <th class="py-3 px-3 sm:px-4">Nama Menu & Porsi</th>
                        <th class="py-3 px-3 sm:px-4">Harga Jual</th>
                        <th class="py-3 px-3 sm:px-4">Modal (HPP)</th>
                        <th class="py-3 px-3 sm:px-4 text-emerald-700">Margin/pcs</th>
                        <th class="py-3 px-3 sm:px-4 text-center">Status</th>
                        <th class="py-3 px-3 sm:px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="menuTableBody" class="divide-y divide-pastel-cream/60">
                    <!-- Dynamic menu rows loaded via JS -->
                </tbody>
            </table>
        </div>
    </div>

</main>


<!-- MODAL TAMBAH / EDIT MENU (Mobile Touch Responsive) -->
<div id="menuModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-end sm:items-center justify-center p-0 sm:p-4">
    <div class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-2xl shadow-2xl border border-pastel-peach/40 overflow-hidden animate-in fade-in slide-in-from-bottom-6 sm:zoom-in duration-200 max-h-[90vh] flex flex-col">
        
        <div class="bg-pastel-creamSoft p-4 border-b border-pastel-cream flex items-center justify-between">
            <h3 class="font-display font-bold text-base text-pastel-brown" id="modalTitle">
                Tambah Menu Baru
            </h3>
            <button onclick="closeMenuModal()" class="text-pastel-brownLight hover:text-pastel-brown p-1.5 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="menuForm" onsubmit="saveMenuForm(event)" class="p-4 sm:p-5 space-y-3.5 overflow-y-auto">
            <input type="hidden" id="menuId" value="0">

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-pastel-brown mb-1">Varian Utama</label>
                    <select id="formVariant" class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-pastel-cream text-pastel-brown font-bold focus:outline-none">
                        <option value="mini">🥟 Dimsum Mini</option>
                        <option value="besar">🥟 Dimsum Besar</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-pastel-brown mb-1">Kategori</label>
                    <select id="formCategory" class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-pastel-cream text-pastel-brown font-bold focus:outline-none">
                        <option value="Mentai / Mayo Cheese">Mentai / Mayo Cheese</option>
                        <option value="Dimsum Lava">Dimsum Lava</option>
                        <option value="Dimsum Original">Dimsum Original</option>
                        <option value="Dimsum Bakar">Dimsum Bakar</option>
                        <option value="Party Box Mix">Party Box Mix</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-pastel-brown mb-1">Nama Menu</label>
                <input type="text" id="formName" required placeholder="Contoh: Small Box Mentai" class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-pastel-cream text-pastel-brown font-semibold focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-pastel-brown mb-1">Keterangan Porsi / Isi</label>
                <input type="text" id="formPortion" placeholder="Contoh: isi 4 pcs" class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-pastel-cream text-pastel-brown font-medium focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-pastel-brown mb-1">Harga Jual (Rp)</label>
                    <input type="number" id="formPrice" required placeholder="10000" class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-pastel-cream text-pastel-brown font-bold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-pastel-brown mb-1">Modal HPP (Rp)</label>
                    <input type="number" id="formCost" required placeholder="6000" class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-pastel-cream text-pastel-brown font-bold focus:outline-none">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 bg-pastel-coral hover:bg-pastel-coralDark text-white rounded-xl font-display font-bold text-sm shadow-xs transition-all active:scale-98">
                    Simpan Menu
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    let menus = [];

    document.addEventListener('DOMContentLoaded', () => {
        loadMenus();
    });

    async function loadMenus() {
        try {
            const res = await fetch('api/pos.php?action=get_menus');
            const result = await res.json();
            if(result.status === 'success') {
                menus = result.data;
                renderMenuTable();
            }
        } catch (e) {
            console.error('Error loading menus:', e);
        }
    }

    function renderMenuTable() {
        const tbody = document.getElementById('menuTableBody');
        const variantVal = document.getElementById('variantFilter').value;
        const categoryVal = document.getElementById('categoryFilter').value;
        const searchVal = document.getElementById('menuSearchInput').value.toLowerCase().trim();

        const filtered = menus.filter(m => {
            const matchVariant = (variantVal === 'all') || (m.variant === variantVal);
            const matchCategory = (categoryVal === 'all') || (m.category === categoryVal);
            const matchSearch = m.name.toLowerCase().includes(searchVal);
            return matchVariant && matchCategory && matchSearch;
        });

        if(filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="py-12 text-center text-pastel-brownLight/60 font-medium">
                        Menu tidak ditemukan.
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = filtered.map(m => {
            const margin = parseInt(m.price) - parseInt(m.cost);
            return `
                <tr class="hover:bg-pastel-creamSoft/30 transition-colors">
                    <td class="py-3 px-3 sm:px-4">
                        <span class="text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-0.5 rounded-md ${m.variant === 'mini' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800'}">
                            ${m.variant.toUpperCase()}
                        </span>
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-semibold text-pastel-brownLight text-[11px] sm:text-xs">
                        ${m.category}
                    </td>
                    <td class="py-3 px-3 sm:px-4 min-w-[140px]">
                        <span class="font-bold text-pastel-brown block text-xs">${m.name}</span>
                        ${m.portion ? `<span class="text-[10px] text-pastel-brownLight">${m.portion}</span>` : ''}
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-display font-extrabold text-pastel-coralDark text-xs sm:text-sm whitespace-nowrap">
                        Rp ${parseInt(m.price).toLocaleString('id-ID')}
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-display font-bold text-pastel-brownLight text-xs whitespace-nowrap">
                        Rp ${parseInt(m.cost).toLocaleString('id-ID')}
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-display font-bold text-emerald-600 text-xs whitespace-nowrap">
                        Rp ${margin.toLocaleString('id-ID')}
                    </td>
                    <td class="py-3 px-3 sm:px-4 text-center">
                        <button onclick="toggleAvailability(${m.id})" class="px-2 py-0.5 rounded-full text-[10px] font-bold ${m.is_available == 1 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'}">
                            ${m.is_available == 1 ? 'Tersedia' : 'Habis'}
                        </button>
                    </td>
                    <td class="py-3 px-3 sm:px-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <button onclick="editMenu(${m.id})" title="Edit Menu" class="p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition-colors active:scale-95">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button onclick="deleteMenu(${m.id})" title="Hapus Menu" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors active:scale-95">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        lucide.createIcons();
    }

    function openMenuModal(menuData = null) {
        const form = document.getElementById('menuForm');
        form.reset();

        if(menuData) {
            document.getElementById('modalTitle').innerText = 'Edit Menu';
            document.getElementById('menuId').value = menuData.id;
            document.getElementById('formVariant').value = menuData.variant;
            document.getElementById('formCategory').value = menuData.category;
            document.getElementById('formName').value = menuData.name;
            document.getElementById('formPortion').value = menuData.portion || '';
            document.getElementById('formPrice').value = menuData.price;
            document.getElementById('formCost').value = menuData.cost;
        } else {
            document.getElementById('modalTitle').innerText = 'Tambah Menu Baru';
            document.getElementById('menuId').value = 0;
        }

        document.getElementById('menuModal').classList.remove('hidden');
        document.getElementById('menuModal').classList.add('flex');
    }

    function closeMenuModal() {
        document.getElementById('menuModal').classList.add('hidden');
        document.getElementById('menuModal').classList.remove('flex');
    }

    function editMenu(id) {
        const item = menus.find(m => m.id === id);
        if(item) {
            openMenuModal(item);
        }
    }

    async function saveMenuForm(e) {
        e.preventDefault();

        const payload = {
            id: parseInt(document.getElementById('menuId').value) || 0,
            variant: document.getElementById('formVariant').value,
            category: document.getElementById('formCategory').value,
            name: document.getElementById('formName').value,
            portion: document.getElementById('formPortion').value,
            price: parseInt(document.getElementById('formPrice').value) || 0,
            cost: parseInt(document.getElementById('formCost').value) || 0
        };

        try {
            const res = await fetch('api/menu_crud.php?action=save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const result = await res.json();
            if(result.status === 'success') {
                closeMenuModal();
                showToast(result.message, 'success');
                loadMenus();
            } else {
                showToast('Gagal menyimpan menu: ' + result.message, 'error');
            }
        } catch (err) {
            console.error('Save Menu Error:', err);
            showToast('Terjadi kesalahan saat menyimpan menu', 'error');
        }
    }

    async function toggleAvailability(id) {
        try {
            const res = await fetch('api/menu_crud.php?action=toggle_availability', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });

            const result = await res.json();
            if(result.status === 'success') {
                showToast('Status stok berhasil diubah', 'success');
                loadMenus();
            }
        } catch (e) {
            console.error('Toggle Availability Error:', e);
        }
    }

    async function deleteMenu(id) {
        const isConfirmed = await customConfirm({
            title: 'Hapus Menu',
            message: 'Apakah Anda yakin ingin menghapus menu ini dari daftar?',
            icon: '🗑️',
            buttonText: 'Ya, Hapus Menu',
            buttonClass: 'bg-rose-500 hover:bg-rose-600'
        });

        if(!isConfirmed) return;

        try {
            const res = await fetch('api/menu_crud.php?action=delete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });

            const result = await res.json();
            if(result.status === 'success') {
                showToast('Menu berhasil dihapus', 'success');
                loadMenus();
            } else {
                showToast('Gagal menghapus menu: ' + result.message, 'error');
            }
        } catch (e) {
            console.error('Delete Menu Error:', e);
            showToast('Terjadi kesalahan saat menghapus menu', 'error');
        }
    }

    async function resetToDefaults() {
        const isConfirmed = await customConfirm({
            title: 'Reset Menu Default',
            message: 'Apakah Anda yakin ingin mengembalikan daftar menu ke data original Cippy Dimsum (Mini & Besar)?',
            icon: '🔄',
            buttonText: 'Ya, Reset Menu',
            buttonClass: 'bg-amber-500 hover:bg-amber-600'
        });

        if(!isConfirmed) return;

        try {
            const res = await fetch('api/menu_crud.php?action=reset_defaults');
            const result = await res.json();
            if(result.status === 'success') {
                showToast(result.message, 'success');
                loadMenus();
            } else {
                showToast('Gagal reset menu: ' + result.message, 'error');
            }
        } catch (e) {
            console.error('Reset Defaults Error:', e);
            showToast('Terjadi kesalahan saat reset menu', 'error');
        }
    }
</script>

</body>
</html>
