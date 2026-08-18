<?php
// api/pos.php - Handle POS transactions, fetching menus, and getting transaction logs

header('Content-Type: application/json');
require_once __DIR__ . '/../db/db_connect.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'get_menus':
        getMenus($pdo);
        break;
    case 'checkout':
        processCheckout($pdo);
        break;
    case 'get_transactions':
        getTransactions($pdo);
        break;
    case 'get_today_summary':
        getTodaySummary($pdo);
        break;
    case 'void_transaction':
        voidTransaction($pdo);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

function getMenus($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM menu ORDER BY variant ASC, category ASC, price ASC");
        $menus = $stmt->fetchAll();
        echo json_encode(['status' => 'success', 'data' => $menus]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function processCheckout($pdo) {
    try {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || empty($input['items'])) {
            echo json_encode(['status' => 'error', 'message' => 'Keranjang kosong!']);
            return;
        }

        $items = $input['items'];
        $paymentMethod = $input['payment_method'] ?? 'Tunai';
        $cashGiven = intval($input['cash_given'] ?? 0);
        $customerNote = trim($input['customer_note'] ?? '');

        // Calculate totals
        $totalAmount = 0;
        $totalCost = 0;

        foreach ($items as $item) {
            $qty = intval($item['quantity']);
            $price = intval($item['price']);
            $cost = intval($item['cost']);

            $totalAmount += ($price * $qty);
            $totalCost += ($cost * $qty);
        }

        $profit = $totalAmount - $totalCost;
        $changeAmount = ($paymentMethod === 'Tunai') ? max(0, $cashGiven - $totalAmount) : 0;

        // Generate Transaction Code (e.g., CIPPY-20260818-1001)
        $dateStr = date('Ymd');
        $timeStr = date('H:i:s');
        
        $stmtCount = $pdo->query("SELECT COUNT(*) as cnt FROM transactions WHERE DATE(created_at) = DATE('now')");
        $todayCount = $stmtCount->fetch()['cnt'] + 1;
        $transactionCode = 'CIPPY-' . $dateStr . '-' . str_pad($todayCount, 4, '0', STR_PAD_LEFT);

        $pdo->beginTransaction();

        $stmtTx = $pdo->prepare("INSERT INTO transactions 
            (transaction_code, total_amount, total_cost, profit, payment_method, cash_given, change_amount, customer_note, created_at) 
            VALUES (:code, :amount, :cost, :profit, :method, :cash, :change, :note, CURRENT_TIMESTAMP)");

        $stmtTx->execute([
            ':code' => $transactionCode,
            ':amount' => $totalAmount,
            ':cost' => $totalCost,
            ':profit' => $profit,
            ':method' => $paymentMethod,
            ':cash' => $cashGiven,
            ':change' => $changeAmount,
            ':note' => $customerNote
        ]);

        $transactionId = $pdo->lastInsertId();

        $stmtItem = $pdo->prepare("INSERT INTO transaction_items 
            (transaction_id, menu_id, menu_name, variant, portion, price, cost, quantity, subtotal, subtotal_cost, item_note) 
            VALUES (:tx_id, :menu_id, :menu_name, :variant, :portion, :price, :cost, :quantity, :subtotal, :subtotal_cost, :item_note)");

        foreach ($items as $item) {
            $qty = intval($item['quantity']);
            $price = intval($item['price']);
            $cost = intval($item['cost']);
            $subtotal = $price * $qty;
            $subtotalCost = $cost * $qty;

            $stmtItem->execute([
                ':tx_id' => $transactionId,
                ':menu_id' => $item['id'] ?? null,
                ':menu_name' => $item['name'],
                ':variant' => $item['variant'],
                ':portion' => $item['portion'] ?? '',
                ':price' => $price,
                ':cost' => $cost,
                ':quantity' => $qty,
                ':subtotal' => $subtotal,
                ':subtotal_cost' => $subtotalCost,
                ':item_note' => $item['note'] ?? ''
            ]);
        }

        $pdo->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Transaksi berhasil disimpan!',
            'data' => [
                'id' => $transactionId,
                'transaction_code' => $transactionCode,
                'total_amount' => $totalAmount,
                'total_cost' => $totalCost,
                'profit' => $profit,
                'payment_method' => $paymentMethod,
                'cash_given' => $cashGiven,
                'change_amount' => $changeAmount,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function getTransactions($pdo) {
    try {
        $startDate = $_GET['start_date'] ?? date('Y-m-d');
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        $paymentMethod = $_GET['payment_method'] ?? 'all';

        $query = "SELECT t.*, strftime('%Y-%m-%d %H:%M:%S', t.created_at, 'localtime') as formatted_time 
                  FROM transactions t 
                  WHERE DATE(t.created_at, 'localtime') BETWEEN :start_date AND :end_date";
        $params = [
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ];

        if ($paymentMethod !== 'all' && !empty($paymentMethod)) {
            $query .= " AND t.payment_method = :payment_method";
            $params[':payment_method'] = $paymentMethod;
        }

        $query .= " ORDER BY t.created_at DESC";

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $transactions = $stmt->fetchAll();

        // Attach items to each transaction
        $stmtItem = $pdo->prepare("SELECT * FROM transaction_items WHERE transaction_id = :tx_id");

        foreach ($transactions as &$tx) {
            $stmtItem->execute([':tx_id' => $tx['id']]);
            $tx['items'] = $stmtItem->fetchAll();
        }

        echo json_encode(['status' => 'success', 'data' => $transactions]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function getTodaySummary($pdo) {
    try {
        $today = date('Y-m-d');
        
        $stmt = $pdo->prepare("SELECT 
            COUNT(*) as total_transactions,
            COALESCE(SUM(total_amount), 0) as total_omset,
            COALESCE(SUM(total_cost), 0) as total_modal,
            COALESCE(SUM(profit), 0) as total_profit
            FROM transactions 
            WHERE DATE(created_at, 'localtime') = :today");
        $stmt->execute([':today' => $today]);
        $summary = $stmt->fetch();

        // Payment method breakdown
        $stmtPay = $pdo->prepare("SELECT payment_method, COUNT(*) as count, SUM(total_amount) as total 
            FROM transactions 
            WHERE DATE(created_at, 'localtime') = :today 
            GROUP BY payment_method");
        $stmtPay->execute([':today' => $today]);
        $payments = $stmtPay->fetchAll();

        echo json_encode([
            'status' => 'success',
            'data' => [
                'summary' => $summary,
                'payments' => $payments
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function voidTransaction($pdo) {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $txId = intval($input['id'] ?? 0);

        if (!$txId) {
            echo json_encode(['status' => 'error', 'message' => 'ID Transaksi tidak valid']);
            return;
        }

        $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = :id");
        $stmt->execute([':id' => $txId]);

        echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil dibatalkan']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
