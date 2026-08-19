<?php
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto p-3 sm:p-6 lg:p-8 space-y-4 sm:space-y-6 pb-24 sm:pb-8">

    <!-- Top Header & Filter Controls -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-pastel-peach/30 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="font-display font-bold text-lg sm:text-xl text-pastel-brown flex items-center gap-2">
                <i data-lucide="line-chart" class="w-5 h-5 sm:w-6 sm:h-6 text-pastel-coral"></i>
                <span>Rekap Keuntungan & Penjualan</span>
            </h2>
            <p class="text-[11px] sm:text-xs text-pastel-brownLight mt-1">Pantau omset, total modal, dan keuntungan bersih secara real-time berdasarkan jam transaksi.</p>
        </div>

        <!-- Date Range Filter Form -->
        <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2 w-full md:w-auto">
            <div class="flex items-center justify-between bg-pastel-creamSoft/60 p-2 rounded-xl border border-pastel-cream text-xs">
                <input type="date" id="startDate" onchange="loadReports()" class="bg-transparent text-pastel-brown font-bold focus:outline-none px-1 text-xs">
                <span class="text-pastel-brownLight mx-1 text-xs font-semibold">s/d</span>
                <input type="date" id="endDate" onchange="loadReports()" class="bg-transparent text-pastel-brown font-bold focus:outline-none px-1 text-xs">
            </div>

            <select id="paymentFilter" onchange="loadReports()" class="px-3 py-2 bg-white text-xs font-bold text-pastel-brown rounded-xl border border-pastel-cream focus:outline-none">
                <option value="all">Semua Metode Bayar</option>
                <option value="Tunai">Tunai (Cash)</option>
                <option value="QRIS">QRIS</option>
                <option value="Transfer">Transfer Bank</option>
                <option value="Debit">Debit / EDC</option>
            </select>

            <!-- Quick Export Buttons -->
            <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center">
                <button onclick="exportToExcel()" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white rounded-xl font-bold text-xs shadow-xs transition-all flex items-center justify-center gap-1.5">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span>Excel</span>
                </button>

                <button onclick="exportToPDF()" class="px-3 py-2 bg-rose-500 hover:bg-rose-600 active:scale-95 text-white rounded-xl font-bold text-xs shadow-xs transition-all flex items-center justify-center gap-1.5">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span>PDF</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Printable & Exportable Content Container -->
    <div id="reportExportArea" class="space-y-4 sm:space-y-6">

        <!-- 4 Stat Summary Cards (2x2 on Mobile, 4x1 on Desktop) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            
            <!-- Omset Card -->
            <div class="bg-gradient-to-br from-amber-50 to-white p-3.5 sm:p-4 rounded-2xl border border-amber-200 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="p-2.5 sm:p-3 bg-amber-100 text-amber-800 rounded-xl">
                    <i data-lucide="wallet" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-medium text-amber-800/80">Total Omset</p>
                    <h3 class="font-display font-extrabold text-sm sm:text-xl text-amber-900 truncate" id="statOmset">Rp 0</h3>
                </div>
            </div>

            <!-- Modal Card -->
            <div class="bg-gradient-to-br from-stone-50 to-white p-3.5 sm:p-4 rounded-2xl border border-stone-200 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="p-2.5 sm:p-3 bg-stone-200 text-stone-700 rounded-xl">
                    <i data-lucide="box" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-medium text-stone-600">Total Modal</p>
                    <h3 class="font-display font-extrabold text-sm sm:text-xl text-stone-800 truncate" id="statModal">Rp 0</h3>
                </div>
            </div>

            <!-- Keuntungan / Profit Card -->
            <div class="bg-gradient-to-br from-emerald-50 to-white p-3.5 sm:p-4 rounded-2xl border border-emerald-200 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="p-2.5 sm:p-3 bg-emerald-100 text-emerald-700 rounded-xl">
                    <i data-lucide="trending-up" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-medium text-emerald-800">Profit (Untung)</p>
                    <h3 class="font-display font-extrabold text-sm sm:text-xl text-emerald-700 truncate" id="statProfit">Rp 0</h3>
                </div>
            </div>

            <!-- Transaksi Count Card -->
            <div class="bg-gradient-to-br from-rose-50 to-white p-3.5 sm:p-4 rounded-2xl border border-rose-200 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="p-2.5 sm:p-3 bg-rose-100 text-rose-700 rounded-xl">
                    <i data-lucide="shopping-bag" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-medium text-rose-800">Jumlah Transaksi</p>
                    <h3 class="font-display font-extrabold text-sm sm:text-xl text-rose-900" id="statCount">0</h3>
                </div>
            </div>

        </div>

        <!-- Payment Breakdown Badges -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-4 border border-pastel-peach/30 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h4 class="font-display font-bold text-[11px] sm:text-xs text-pastel-brown uppercase tracking-wider">Penerimaan Bayar:</h4>
            <div class="flex flex-wrap items-center gap-2 text-xs" id="paymentBreakdownContainer">
                <!-- Dynamic payment breakdown badges -->
            </div>
        </div>

        <!-- Transaction Logs Table -->
        <div class="bg-white rounded-2xl border border-pastel-peach/30 shadow-xs overflow-hidden">
            <div class="p-3.5 sm:p-4 bg-pastel-creamSoft/40 border-b border-pastel-cream flex items-center justify-between">
                <h3 class="font-display font-bold text-xs sm:text-sm text-pastel-brown flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-pastel-orange"></i>
                    <span>Log Detail Transaksi (Jam Masuk)</span>
                </h3>
                <span class="text-[11px] text-pastel-brownLight font-medium" id="logDateLabel">--</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-pastel-brown">
                    <thead class="bg-pastel-creamSoft/80 font-display text-[10px] sm:text-[11px] font-bold text-pastel-brown uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-3 sm:px-4">Waktu (Jam)</th>
                            <th class="py-3 px-3 sm:px-4">Kode / ID</th>
                            <th class="py-3 px-3 sm:px-4">Menu & Detail Item</th>
                            <th class="py-3 px-3 sm:px-4">Bayar</th>
                            <th class="py-3 px-3 sm:px-4">Total Omset</th>
                            <th class="py-3 px-3 sm:px-4 text-emerald-700">Profit</th>
                            <th class="py-3 px-3 sm:px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transactionTableBody" class="divide-y divide-pastel-cream/60">
                        <!-- Dynamic transaction rows loaded via JS -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</main>

<script>
    let reportData = [];

    document.addEventListener('DOMContentLoaded', () => {
        // Default dates to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('startDate').value = today;
        document.getElementById('endDate').value = today;

        loadReports();
    });

    async function loadReports() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const payment = document.getElementById('paymentFilter').value;

        document.getElementById('logDateLabel').innerText = `${startDate} s/d ${endDate}`;

        try {
            const res = await fetch(`api/pos.php?action=get_transactions&start_date=${startDate}&end_date=${endDate}&payment_method=${payment}`);
            const result = await res.json();

            if (result.status === 'success') {
                // 1. Data utama diambil LANGSUNG dari Cloud Database (Supabase)
                let dbData = result.data || [];

                // 2. Jika database mengembalikan data, gunakan data database tersebut
                if (dbData.length > 0) {
                    reportData = dbData;
                } else {
                    // Cadangan jika perangkat sedang offline / database kosong
                    let localBackup = JSON.parse(localStorage.getItem('cippy_tx_history') || '[]');
                    let filteredLocal = localBackup.filter(tx => {
                        const txDate = (tx.created_at || '').split(' ')[0];
                        const matchDate = (!startDate || txDate >= startDate) && (!endDate || txDate <= endDate);
                        const matchPayment = (payment === 'all') || (tx.payment_method === payment);
                        return matchDate && matchPayment;
                    });
                    reportData = filteredLocal;
                }

                // Urutkan transaksi dari yang paling baru
                reportData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                renderReportStats(reportData);
                renderReportTable(reportData);
            }
        } catch (e) {
            console.error('Error loading reports from database:', e);
        }
    }

    function renderReportStats(data) {
        let totalOmset = 0;
        let totalModal = 0;
        let totalProfit = 0;
        let paymentBreakdown = {
            'Tunai': 0,
            'QRIS': 0,
            'Transfer': 0,
            'Debit': 0
        };

        data.forEach(tx => {
            totalOmset += parseInt(tx.total_amount);
            totalModal += parseInt(tx.total_cost);
            totalProfit += parseInt(tx.profit);

            const method = tx.payment_method;
            if(paymentBreakdown[method] !== undefined) {
                paymentBreakdown[method] += parseInt(tx.total_amount);
            } else {
                paymentBreakdown[method] = parseInt(tx.total_amount);
            }
        });

        document.getElementById('statOmset').innerText = `Rp ${totalOmset.toLocaleString('id-ID')}`;
        document.getElementById('statModal').innerText = `Rp ${totalModal.toLocaleString('id-ID')}`;
        document.getElementById('statProfit').innerText = `Rp ${totalProfit.toLocaleString('id-ID')}`;
        document.getElementById('statCount').innerText = data.length;

        // Render payment breakdown badges
        const container = document.getElementById('paymentBreakdownContainer');
        container.innerHTML = Object.keys(paymentBreakdown).map(k => `
            <div class="px-2.5 py-1 rounded-xl bg-pastel-creamSoft border border-pastel-cream font-medium flex items-center gap-1">
                <span class="font-bold text-pastel-brown text-[11px]">${k}:</span>
                <span class="font-display font-extrabold text-pastel-coralDark text-xs">Rp ${paymentBreakdown[k].toLocaleString('id-ID')}</span>
            </div>
        `).join('');
    }

    function renderReportTable(data) {
        const tbody = document.getElementById('transactionTableBody');

        if(data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-12 text-center text-pastel-brownLight/60 font-medium">
                        Tidak ada transaksi ditemukan pada tanggal ini.
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = data.map(tx => {
            const timeStr = tx.formatted_time || tx.created_at;
            const itemsHtml = tx.items.map(i => `
                <div class="text-[11px]">
                    <span class="font-bold">${i.menu_name}</span>
                    <span class="text-pastel-brownLight">(${i.variant}) x${i.quantity} @ Rp ${parseInt(i.price).toLocaleString('id-ID')}</span>
                    ${i.item_note ? `<span class="text-[10px] text-pastel-coralDark italic"> [Catatan: ${i.item_note}]</span>` : ''}
                </div>
            `).join('');

            return `
                <tr class="hover:bg-pastel-creamSoft/30 transition-colors">
                    <td class="py-3 px-3 sm:px-4 font-mono font-bold text-pastel-brown whitespace-nowrap text-[11px]">
                        ${timeStr}
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-mono font-semibold text-[11px] text-pastel-coralDark whitespace-nowrap">
                        ${tx.transaction_code}
                    </td>
                    <td class="py-3 px-3 sm:px-4 min-w-[180px]">
                        <div class="space-y-0.5">
                            ${itemsHtml}
                        </div>
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-bold text-xs whitespace-nowrap">
                        <span class="px-2 py-0.5 rounded-md bg-pastel-creamSoft text-pastel-brown border border-pastel-cream text-[10px]">
                            ${tx.payment_method}
                        </span>
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-display font-bold text-xs sm:text-sm text-pastel-brown whitespace-nowrap">
                        Rp ${parseInt(tx.total_amount).toLocaleString('id-ID')}
                    </td>
                    <td class="py-3 px-3 sm:px-4 font-display font-extrabold text-xs sm:text-sm text-emerald-600 whitespace-nowrap">
                        Rp ${parseInt(tx.profit).toLocaleString('id-ID')}
                    </td>
                    <td class="py-3 px-3 sm:px-4 text-center">
                        <button onclick="voidTx(${tx.id}, '${tx.transaction_code}')" title="Batalkan Transaksi" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors active:scale-95">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');

        lucide.createIcons();
    }

    async function voidTx(txId, txCode) {
        const isConfirmed = await customConfirm({
            title: 'Batalkan Transaksi',
            message: 'Apakah Anda yakin ingin membatalkan transaksi ini?',
            icon: '🗑️',
            buttonText: 'Ya, Batalkan',
            buttonClass: 'bg-rose-500 hover:bg-rose-600'
        });

        if(!isConfirmed) return;

        try {
            const res = await fetch('api/pos.php?action=void_transaction', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: txId, transaction_code: txCode })
            });

            const result = await res.json();
            if(result.status === 'success') {
                // 1. Remove from LocalStorage backup by BOTH id and transaction_code
                try {
                    let localBackup = JSON.parse(localStorage.getItem('cippy_tx_history') || '[]');
                    localBackup = localBackup.filter(t => (t.id != txId && t.transaction_code !== txCode));
                    localStorage.setItem('cippy_tx_history', JSON.stringify(localBackup));
                } catch(err) {}

                // 2. Instantly update in-memory reportData & re-render UI immediately without page refresh!
                reportData = reportData.filter(t => (t.id != txId && t.transaction_code !== txCode));
                renderReportStats(reportData);
                renderReportTable(reportData);

                showToast('Transaksi berhasil dibatalkan!', 'success');
            } else {
                showToast('Gagal membatalkan transaksi: ' + result.message, 'error');
            }
        } catch (e) {
            console.error('Void Tx Error:', e);
            showToast('Terjadi kesalahan saat membatalkan transaksi', 'error');
        }
    }

    function exportToExcel() {
        if(reportData.length === 0) {
            showToast('Tidak ada data transaksi untuk diexport!', 'warning');
            return;
        }

        const excelRows = [];
        reportData.forEach(tx => {
            const timeStr = tx.formatted_time || tx.created_at;
            tx.items.forEach(item => {
                excelRows.push({
                    'Waktu Transaksi': timeStr,
                    'Kode Transaksi': tx.transaction_code,
                    'Nama Menu': item.menu_name,
                    'Varian': item.variant,
                    'Porsi': item.portion,
                    'Qty': item.quantity,
                    'Harga Satuan (Rp)': item.price,
                    'Subtotal Omset (Rp)': item.subtotal,
                    'Subtotal Modal (Rp)': item.subtotal_cost,
                    'Untung / Profit (Rp)': item.subtotal - item.subtotal_cost,
                    'Metode Bayar': tx.payment_method,
                    'Catatan Pesanan': tx.customer_note || item.item_note || '-'
                });
            });
        });

        const worksheet = XLSX.utils.json_to_sheet(excelRows);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Rekap Penjualan");

        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        XLSX.writeFile(workbook, `Rekap_CippyDimsum_${startDate}_sd_${endDate}.xlsx`);
        showToast('Laporan Excel berhasil diunduh! 📊', 'success');
    }

    function exportToPDF() {
        if(reportData.length === 0) {
            showToast('Tidak ada data transaksi untuk diexport!', 'warning');
            return;
        }

        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const printTime = new Date().toLocaleString('id-ID', { timeZone: 'Asia/Jakarta' }) + ' WIB';

        showToast('Membuat Laporan PDF Format Inventory... 📄', 'warning');

        // 1. Calculate Totals
        let grandOmset = 0;
        let grandModal = 0;
        let grandProfit = 0;
        let grandQty = 0;

        // 2. Aggregate Inventory Item Sales
        const itemSummaryMap = new Map();

        reportData.forEach(tx => {
            grandOmset += parseInt(tx.total_amount);
            grandModal += parseInt(tx.total_cost);
            grandProfit += parseInt(tx.profit);

            (tx.items || []).forEach(item => {
                const qty = intval(item.quantity);
                const subOmset = intval(item.subtotal);
                const subModal = intval(item.subtotal_cost) || (intval(item.cost) * qty);
                const subProfit = subOmset - subModal;

                grandQty += qty;

                const key = (item.variant || '') + ' - ' + item.menu_name;
                if (!itemSummaryMap.has(key)) {
                    itemSummaryMap.set(key, {
                        variant: item.variant || 'mini',
                        name: item.menu_name,
                        portion: item.portion || '',
                        price: intval(item.price),
                        cost: intval(item.cost),
                        totalQty: 0,
                        totalOmset: 0,
                        totalModal: 0,
                        totalProfit: 0
                    });
                }
                const record = itemSummaryMap.get(key);
                record.totalQty += qty;
                record.totalOmset += subOmset;
                record.totalModal += subModal;
                record.totalProfit += subProfit;
            });
        });

        function intval(v) { return parseInt(v) || 0; }

        // Build Inventory Summary Rows
        let inventoryRowsHtml = '';
        let rowNo = 1;
        itemSummaryMap.forEach((item) => {
            inventoryRowsHtml += `
                <tr style="border-bottom: 1px solid #eee; font-size: 11px;">
                    <td style="padding: 6px; text-align: center;">${rowNo++}</td>
                    <td style="padding: 6px;"><span style="background: #fff3d6; padding: 2px 6px; border-radius: 4px; font-weight: bold; text-transform: uppercase;">${item.variant}</span></td>
                    <td style="padding: 6px; font-weight: bold;">${item.name}</td>
                    <td style="padding: 6px; color: #666;">${item.portion}</td>
                    <td style="padding: 6px; text-align: center; font-weight: bold; font-size: 12px; color: #d97706;">${item.totalQty} porsi</td>
                    <td style="padding: 6px; text-align: right;">Rp ${item.totalOmset.toLocaleString('id-ID')}</td>
                    <td style="padding: 6px; text-align: right; color: #555;">Rp ${item.totalModal.toLocaleString('id-ID')}</td>
                    <td style="padding: 6px; text-align: right; font-weight: bold; color: #059669;">Rp ${item.totalProfit.toLocaleString('id-ID')}</td>
                </tr>
            `;
        });

        // Build Transaction Log Rows
        let txRowsHtml = reportData.slice(0, 30).map((tx, idx) => {
            const itemsStr = (tx.items || []).map(i => `${i.menu_name} (x${i.quantity})`).join(', ');
            return `
                <tr style="border-bottom: 1px solid #eee; font-size: 10px;">
                    <td style="padding: 5px; text-align: center;">${idx + 1}</td>
                    <td style="padding: 5px; font-family: monospace; font-weight: bold;">${tx.formatted_time || tx.created_at}</td>
                    <td style="padding: 5px; font-family: monospace; color: #e67382; font-weight: bold;">${tx.transaction_code}</td>
                    <td style="padding: 5px;">${itemsStr}</td>
                    <td style="padding: 5px; font-weight: bold;">${tx.payment_method}</td>
                    <td style="padding: 5px; text-align: right; font-weight: bold;">Rp ${intval(tx.total_amount).toLocaleString('id-ID')}</td>
                    <td style="padding: 5px; text-align: right; font-weight: bold; color: #059669;">Rp ${intval(tx.profit).toLocaleString('id-ID')}</td>
                </tr>
            `;
        }).join('');

        // Create PDF Template Element
        const pdfContainer = document.createElement('div');
        pdfContainer.style.padding = '20px';
        pdfContainer.style.fontFamily = "'Plus Jakarta Sans', sans-serif";
        pdfContainer.style.color = '#4A3728';
        pdfContainer.style.backgroundColor = '#ffffff';

        pdfContainer.innerHTML = `
            <!-- HEADER LETTERHEAD -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 3px double #FFBFA9; padding-bottom: 12px; margin-bottom: 15px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; background: #FF9EAA; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: white;">
                        🥟
                    </div>
                    <div>
                        <h1 style="font-size: 20px; font-weight: 800; margin: 0; color: #4A3728;">CIPPY DIMSUM</h1>
                        <p style="font-size: 11px; margin: 2px 0 0 0; color: #7A6250;">Laporasi Rekapitulasi Stok Inventory & Keuntungan Penjualan</p>
                    </div>
                </div>
                <div style="text-align: right; font-size: 11px; color: #666;">
                    <p style="margin: 0; font-weight: bold;">PERIODE LAPORAN:</p>
                    <p style="margin: 2px 0 0 0; font-size: 12px; font-weight: 800; color: #E67382;">${startDate} s/d ${endDate}</p>
                    <p style="margin: 4px 0 0 0; font-size: 10px; color: #888;">Dicetak pada: ${printTime}</p>
                </div>
            </div>

            <!-- EXECUTIVE SUMMARY CARDS -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 18px;">
                <div style="background: #fffdf9; border: 1px solid #ffe5ad; padding: 10px; border-radius: 8px; text-align: center;">
                    <span style="font-size: 10px; color: #7a6250; font-weight: bold; text-transform: uppercase;">Total Omset</span>
                    <h3 style="font-size: 15px; font-weight: 800; color: #4a3728; margin: 4px 0 0 0;">Rp ${grandOmset.toLocaleString('id-ID')}</h3>
                </div>
                <div style="background: #fcfcfc; border: 1px solid #e5e5e5; padding: 10px; border-radius: 8px; text-align: center;">
                    <span style="font-size: 10px; color: #666; font-weight: bold; text-transform: uppercase;">Total Modal</span>
                    <h3 style="font-size: 15px; font-weight: 800; color: #555; margin: 4px 0 0 0;">Rp ${grandModal.toLocaleString('id-ID')}</h3>
                </div>
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px; border-radius: 8px; text-align: center;">
                    <span style="font-size: 10px; color: #166534; font-weight: bold; text-transform: uppercase;">Keuntungan Bersih</span>
                    <h3 style="font-size: 15px; font-weight: 800; color: #059669; margin: 4px 0 0 0;">Rp ${grandProfit.toLocaleString('id-ID')}</h3>
                </div>
                <div style="background: #fff1f2; border: 1px solid #fecdd3; padding: 10px; border-radius: 8px; text-align: center;">
                    <span style="font-size: 10px; color: #9f1239; font-weight: bold; text-transform: uppercase;">Total Stok Terjual</span>
                    <h3 style="font-size: 15px; font-weight: 800; color: #e67382; margin: 4px 0 0 0;">${grandQty} porsi (${reportData.length} Tx)</h3>
                </div>
            </div>

            <!-- TABLE 1: INVENTORY STOCK RECAP -->
            <div style="margin-bottom: 18px;">
                <h3 style="font-size: 13px; font-weight: 800; color: #4a3728; margin: 0 0 8px 0; display: flex; align-items: center; gap: 6px;">
                    📦 REKAPITULASI STOK INVENTORY TERJUAL PER MENU
                </h3>
                <table style="width: 100%; border-collapse: collapse; background: #ffffff; border: 1px solid #ffe5ad;">
                    <thead>
                        <tr style="background: #ffe5ad; font-size: 10px; text-transform: uppercase; color: #4a3728;">
                            <th style="padding: 6px; text-align: center;">No</th>
                            <th style="padding: 6px; text-align: left;">Varian</th>
                            <th style="padding: 6px; text-align: left;">Nama Menu</th>
                            <th style="padding: 6px; text-align: left;">Porsi</th>
                            <th style="padding: 6px; text-align: center;">Stok Terjual</th>
                            <th style="padding: 6px; text-align: right;">Total Omset</th>
                            <th style="padding: 6px; text-align: right;">Total Modal</th>
                            <th style="padding: 6px; text-align: right;">Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${inventoryRowsHtml}
                    </tbody>
                </table>
            </div>

            <!-- TABLE 2: LOG TRANSAKSI -->
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 13px; font-weight: 800; color: #4a3728; margin: 0 0 8px 0;">
                    🕒 DETAIL LOG TRANSAKSI PENJUALAN
                </h3>
                <table style="width: 100%; border-collapse: collapse; background: #ffffff; border: 1px solid #ddd;">
                    <thead>
                        <tr style="background: #f5f5f5; font-size: 10px; text-transform: uppercase; color: #444;">
                            <th style="padding: 5px; text-align: center;">No</th>
                            <th style="padding: 5px; text-align: left;">Waktu (WIB)</th>
                            <th style="padding: 5px; text-align: left;">Kode Tx</th>
                            <th style="padding: 5px; text-align: left;">Item Terjual</th>
                            <th style="padding: 5px; text-align: left;">Bayar</th>
                            <th style="padding: 5px; text-align: right;">Omset</th>
                            <th style="padding: 5px; text-align: right;">Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${txRowsHtml}
                    </tbody>
                </table>
            </div>

            <!-- FOOTER SIGNATURE SECTION -->
            <div style="display: flex; justify-content: flex-end; margin-top: 30px; font-size: 11px;">
                <div style="text-align: center; width: 200px;">
                    <p style="margin: 0; font-weight: bold;">Jakarta, ${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</p>
                    <p style="margin: 2px 0 0 0; color: #666;">Penanggung Jawab / Owner</p>
                    <div style="height: 50px;"></div>
                    <p style="margin: 0; font-weight: 800; border-top: 1px dashed #aaa; padding-top: 4px; color: #4a3728;">( CIPPY DIMSUM )</p>
                </div>
            </div>
        `;

        const opt = {
            margin:       0.2,
            filename:     `Laporan_Inventory_CippyDimsum_${startDate}_sd_${endDate}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, logging: false },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(pdfContainer).save().then(() => {
            showToast('Laporan Inventory & Keuangan PDF Berhasil Diunduh! 📄', 'success');
        });
    }

</script>

</body>
</html>
