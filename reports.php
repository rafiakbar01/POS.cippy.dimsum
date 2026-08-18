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
            <p class="text-[11px] sm:text-xs text-pastel-brownLight mt-1">Pantau omset, modal HPP, dan keuntungan bersih secara real-time berdasarkan jam transaksi.</p>
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

            <!-- Modal HPP Card -->
            <div class="bg-gradient-to-br from-stone-50 to-white p-3.5 sm:p-4 rounded-2xl border border-stone-200 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="p-2.5 sm:p-3 bg-stone-200 text-stone-700 rounded-xl">
                    <i data-lucide="box" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs font-medium text-stone-600">Modal HPP</p>
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

            let serverData = (result.status === 'success') ? result.data : [];

            // Merge with LocalStorage permanent device backup
            let localBackup = JSON.parse(localStorage.getItem('cippy_tx_history') || '[]');
            
            // Filter local backup by date range & payment method
            let filteredLocal = localBackup.filter(tx => {
                const txDate = (tx.created_at || '').split(' ')[0];
                const matchDate = (!startDate || txDate >= startDate) && (!endDate || txDate <= endDate);
                const matchPayment = (payment === 'all') || (tx.payment_method === payment);
                return matchDate && matchPayment;
            });

            // Combine unique transactions
            const combinedMap = new Map();
            serverData.forEach(tx => combinedMap.set(tx.transaction_code, tx));
            filteredLocal.forEach(tx => {
                if(!combinedMap.has(tx.transaction_code)) {
                    combinedMap.set(tx.transaction_code, tx);
                }
            });

            reportData = Array.from(combinedMap.values());
            // Sort by created_at descending
            reportData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

            renderReportStats(reportData);
            renderReportTable(reportData);

        } catch (e) {
            console.error('Error loading reports:', e);
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
                        <button onclick="voidTx(${tx.id})" title="Batalkan Transaksi" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors active:scale-95">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');

        lucide.createIcons();
    }

    async function voidTx(txId) {
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
                body: JSON.stringify({ id: txId })
            });

            const result = await res.json();
            if(result.status === 'success') {
                // Remove from LocalStorage backup
                try {
                    let localBackup = JSON.parse(localStorage.getItem('cippy_tx_history') || '[]');
                    localBackup = localBackup.filter(t => t.id !== txId);
                    localStorage.setItem('cippy_tx_history', JSON.stringify(localBackup));
                } catch(err) {}

                showToast('Transaksi berhasil dibatalkan', 'success');
                loadReports();
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
                    'Subtotal Modal HPP (Rp)': item.subtotal_cost,
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

        const element = document.getElementById('reportExportArea');
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        showToast('Memproses file PDF... 📄', 'warning');

        const opt = {
            margin:       0.3,
            filename:     `Rekap_CippyDimsum_${startDate}_sd_${endDate}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            showToast('Laporan PDF berhasil diunduh! 📄', 'success');
        });
    }
</script>

</body>
</html>
