<?php
// db/db_connect.php - SQLite PDO Database Connection & Auto Seed for Cippy Dimsum POS

date_default_timezone_set('Asia/Jakarta');

// Support Vercel serverless environment (/tmp directory) or local Laragon (__DIR__)
$isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL') || (strpos(__DIR__, '/var/task') !== false);

if ($isVercel) {
    $dbDir = '/tmp';
} else {
    $dbDir = __DIR__;
}

if (!file_exists($dbDir)) {
    @mkdir($dbDir, 0777, true);
}

$dbPath = $dbDir . '/database.sqlite';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Enable PRAGMA foreign keys
    $pdo->exec('PRAGMA foreign_keys = ON;');

    // 1. Table Menu
    $pdo->exec("CREATE TABLE IF NOT EXISTS menu (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        variant TEXT NOT NULL, -- 'mini' or 'besar'
        category TEXT NOT NULL, -- 'Mentai / Mayo Cheese', 'Dimsum Lava', 'Dimsum Original', 'Dimsum Bakar', 'Party Box Mix'
        name TEXT NOT NULL,
        portion TEXT DEFAULT '',
        price INTEGER NOT NULL,
        cost INTEGER NOT NULL DEFAULT 0, -- Harga Modal
        is_available INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Table Transactions
    $pdo->exec("CREATE TABLE IF NOT EXISTS transactions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        transaction_code TEXT UNIQUE NOT NULL,
        total_amount INTEGER NOT NULL,
        total_cost INTEGER NOT NULL DEFAULT 0,
        profit INTEGER NOT NULL DEFAULT 0,
        payment_method TEXT NOT NULL, -- 'Tunai', 'QRIS', 'Transfer', 'Debit'
        cash_given INTEGER DEFAULT 0,
        change_amount INTEGER DEFAULT 0,
        customer_note TEXT DEFAULT '',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 3. Table Transaction Items
    $pdo->exec("CREATE TABLE IF NOT EXISTS transaction_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        transaction_id INTEGER NOT NULL,
        menu_id INTEGER,
        menu_name TEXT NOT NULL,
        variant TEXT NOT NULL,
        portion TEXT DEFAULT '',
        price INTEGER NOT NULL,
        cost INTEGER NOT NULL DEFAULT 0,
        quantity INTEGER NOT NULL,
        subtotal INTEGER NOT NULL,
        subtotal_cost INTEGER NOT NULL DEFAULT 0,
        item_note TEXT DEFAULT '',
        FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE
    )");

    // Check if menu is empty, auto seed default Cippy Dimsum menus
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM menu");
    $rowCount = $stmt->fetch()['count'];

    if ($rowCount == 0) {
        seedDefaultMenus($pdo);
    }

} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}

function seedDefaultMenus($pdo) {
    $defaultMenus = [
        // --- CIPPY DIMSUM MINI ---
        // Mentai / Mayo Cheese
        ['variant' => 'mini', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Small Box Mentai/Mayo Cheese', 'portion' => 'isi 4 pcs', 'price' => 10000, 'cost' => 6000],
        ['variant' => 'mini', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Medium Box Mentai/Mayo Cheese', 'portion' => 'isi 6 pcs', 'price' => 15000, 'cost' => 9000],
        ['variant' => 'mini', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Large Box Mentai/Mayo Cheese', 'portion' => 'isi 10 pcs', 'price' => 24000, 'cost' => 14000],
        ['variant' => 'mini', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Extra Large Box Mentai/Mayo Cheese', 'portion' => 'isi 16 pcs', 'price' => 37000, 'cost' => 22000],

        // Dimsum Lava
        ['variant' => 'mini', 'category' => 'Dimsum Lava', 'name' => 'Small Box Dimsum Lava', 'portion' => 'isi 4 pcs', 'price' => 9000, 'cost' => 5500],
        ['variant' => 'mini', 'category' => 'Dimsum Lava', 'name' => 'Medium Box Dimsum Lava', 'portion' => 'isi 6 pcs', 'price' => 14000, 'cost' => 8500],
        ['variant' => 'mini', 'category' => 'Dimsum Lava', 'name' => 'Large Box Dimsum Lava', 'portion' => 'isi 10 pcs', 'price' => 22000, 'cost' => 13000],
        ['variant' => 'mini', 'category' => 'Dimsum Lava', 'name' => 'Extra Large Box Dimsum Lava', 'portion' => 'isi 16 pcs', 'price' => 36000, 'cost' => 21000],

        // Dimsum Original
        ['variant' => 'mini', 'category' => 'Dimsum Original', 'name' => 'Dimsum Ori Mini', 'portion' => 'per pcs (free saus)', 'price' => 2000, 'cost' => 1100],

        // Dimsum Bakar
        ['variant' => 'mini', 'category' => 'Dimsum Bakar', 'name' => 'Dimsum Bakar Ori Mini', 'portion' => 'isi 3 pcs', 'price' => 8000, 'cost' => 4800],
        ['variant' => 'mini', 'category' => 'Dimsum Bakar', 'name' => 'Dimsum Bakar Topping Mini', 'portion' => 'isi 3 pcs (Mentai, Nori, Boncabe)', 'price' => 10000, 'cost' => 6000],

        // Party Box Mix
        ['variant' => 'mini', 'category' => 'Party Box Mix', 'name' => 'Large Party Box Mix Mini', 'portion' => '10 pcs (4 Mentai, 4 Mayo, 2 Lava)', 'price' => 26000, 'cost' => 15000],
        ['variant' => 'mini', 'category' => 'Party Box Mix', 'name' => 'XL Party Box Mix Mini', 'portion' => '16 pcs (4 Mentai, 4 Mayo, 4 Hot, 4 Lava)', 'price' => 44000, 'cost' => 25000],


        // --- CIPPY DIMSUM BESAR (REGULAR / PREMIUM) ---
        // Mentai / Mayo Cheese
        ['variant' => 'besar', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Small Box Mentai/Mayo Cheese', 'portion' => 'isi 4 pcs', 'price' => 18000, 'cost' => 11000],
        ['variant' => 'besar', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Medium Box Mentai/Mayo Cheese', 'portion' => 'isi 6 pcs', 'price' => 26000, 'cost' => 16000],
        ['variant' => 'besar', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Large Box Mentai/Mayo Cheese', 'portion' => 'isi 10 pcs', 'price' => 45000, 'cost' => 27000],
        ['variant' => 'besar', 'category' => 'Mentai / Mayo Cheese', 'name' => 'Extra Large Box Mentai/Mayo Cheese', 'portion' => 'isi 16 pcs', 'price' => 68000, 'cost' => 40000],

        // Dimsum Lava
        ['variant' => 'besar', 'category' => 'Dimsum Lava', 'name' => 'Small Box Dimsum Lava', 'portion' => 'isi 4 pcs', 'price' => 17000, 'cost' => 10500],
        ['variant' => 'besar', 'category' => 'Dimsum Lava', 'name' => 'Medium Box Dimsum Lava', 'portion' => 'isi 6 pcs', 'price' => 25000, 'cost' => 15000],
        ['variant' => 'besar', 'category' => 'Dimsum Lava', 'name' => 'Large Box Dimsum Lava', 'portion' => 'isi 10 pcs', 'price' => 44000, 'cost' => 26000],
        ['variant' => 'besar', 'category' => 'Dimsum Lava', 'name' => 'Extra Large Box Dimsum Lava', 'portion' => 'isi 16 pcs', 'price' => 65000, 'cost' => 39000],

        // Dimsum Original
        ['variant' => 'besar', 'category' => 'Dimsum Original', 'name' => 'Dimsum Ori Besar', 'portion' => 'per pcs (free saus)', 'price' => 4000, 'cost' => 2200],

        // Dimsum Bakar
        ['variant' => 'besar', 'category' => 'Dimsum Bakar', 'name' => 'Dimsum Bakar Ori Besar', 'portion' => 'isi 3 pcs', 'price' => 12000, 'cost' => 7200],
        ['variant' => 'besar', 'category' => 'Dimsum Bakar', 'name' => 'Dimsum Bakar Topping Besar', 'portion' => 'isi 3 pcs (Mentai, Nori, Boncabe)', 'price' => 14000, 'cost' => 8500],

        // Party Box Mix
        ['variant' => 'besar', 'category' => 'Party Box Mix', 'name' => 'Large Party Box Mix Besar', 'portion' => '10 pcs (4 Mentai, 4 Mayo, 2 Lava)', 'price' => 50000, 'cost' => 30000],
        ['variant' => 'besar', 'category' => 'Party Box Mix', 'name' => 'XL Party Box Mix Besar', 'portion' => '16 pcs (4 Mentai, 4 Mayo, 4 Hot, 4 Lava)', 'price' => 75000, 'cost' => 45000],
    ];

    $stmt = $pdo->prepare("INSERT INTO menu (variant, category, name, portion, price, cost) VALUES (:variant, :category, :name, :portion, :price, :cost)");
    foreach ($defaultMenus as $menu) {
        $stmt->execute($menu);
    }
}
