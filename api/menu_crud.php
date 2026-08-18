<?php
// api/menu_crud.php - Handle CRUD for Menu Items & resetting defaults

header('Content-Type: application/json');
require_once __DIR__ . '/../db/db_connect.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'save':
        saveMenu($pdo);
        break;
    case 'delete':
        deleteMenu($pdo);
        break;
    case 'toggle_availability':
        toggleAvailability($pdo);
        break;
    case 'reset_defaults':
        resetDefaults($pdo);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

function saveMenu($pdo) {
    try {
        $input = json_decode(file_get_contents('php://input'), true);

        $id = intval($input['id'] ?? 0);
        $variant = trim($input['variant'] ?? 'mini');
        $category = trim($input['category'] ?? 'Mentai / Mayo Cheese');
        $name = trim($input['name'] ?? '');
        $portion = trim($input['portion'] ?? '');
        $price = intval($input['price'] ?? 0);
        $cost = intval($input['cost'] ?? 0);

        if (empty($name) || $price <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Nama menu dan harga jual wajib diisi']);
            return;
        }

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE menu SET variant = :variant, category = :category, name = :name, portion = :portion, price = :price, cost = :cost WHERE id = :id");
            $stmt->execute([
                ':variant' => $variant,
                ':category' => $category,
                ':name' => $name,
                ':portion' => $portion,
                ':price' => $price,
                ':cost' => $cost,
                ':id' => $id
            ]);
            $msg = 'Menu berhasil diperbarui';
        } else {
            $stmt = $pdo->prepare("INSERT INTO menu (variant, category, name, portion, price, cost) VALUES (:variant, :category, :name, :portion, :price, :cost)");
            $stmt->execute([
                ':variant' => $variant,
                ':category' => $category,
                ':name' => $name,
                ':portion' => $portion,
                ':price' => $price,
                ':cost' => $cost
            ]);
            $msg = 'Menu baru berhasil ditambahkan';
        }

        echo json_encode(['status' => 'success', 'message' => $msg]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function deleteMenu($pdo) {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['id'] ?? 0);

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID Menu tidak valid']);
            return;
        }

        $stmt = $pdo->prepare("DELETE FROM menu WHERE id = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['status' => 'success', 'message' => 'Menu berhasil dihapus']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function toggleAvailability($pdo) {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['id'] ?? 0);

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID Menu tidak valid']);
            return;
        }

        $stmt = $pdo->prepare("UPDATE menu SET is_available = CASE WHEN is_available = 1 THEN 0 ELSE 1 END WHERE id = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['status' => 'success', 'message' => 'Status stok berhasil diubah']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function resetDefaults($pdo) {
    try {
        $pdo->exec("DELETE FROM menu");
        seedDefaultMenus($pdo);
        echo json_encode(['status' => 'success', 'message' => 'Menu berhasil di-reset ke data default Cippy Dimsum (Mini & Besar)!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
