<?php
require_once("../backend/dbconnect.php");
$db = new DBController();
$conn = $db->conn;

header('Content-Type: application/json');

// Response sukses dan gagal
define('SUCCESS', ['success' => true, 'message' => 'Order berhasil disimpan.']);
define('FAIL', ['success' => false, 'message' => '']);

// Mengambil data dari POST request
$action = $_POST['action'] ?? '';
$order_id = $_POST['order_id'] ?? null;
$full_name = trim($_POST['full_name'] ?? '');
$status = $_POST['status'] ?? 'Paid';

// Data array item order
$product_ids = $_POST['product_id'] ?? [];
$quantities = $_POST['quantity'] ?? [];
$order_dates = $_POST['data_order'] ?? [];
$order_item_ids = $_POST['order_item_id'] ?? [];

try {
    // Validasi input awal
    if (empty($full_name) || count($product_ids) === 0) {
        throw new Exception("Nama customer dan minimal 1 item produk harus diisi.");
    }

    // Memulai transaksi database
    $conn->beginTransaction();

    // Handle customer
    $customer = $db->getRows("customers", ["where" => ["full_name" => $full_name]]);
    if ($customer) {
        $customer_id = $customer[0]['customer_id'];
    } else {
        $db->insert("customers", ["full_name" => $full_name]);
        $customer_id = $conn->lastInsertId();
    }

    // Logika untuk create/edit order
    if ($action === 'edit' && $order_id) {
        // Ambil data item lama dari order
        $old_items = [];
        $results = $db->runRawQuery("SELECT order_item_id, product_id, quantity FROM order_items WHERE order_id = ?", [$order_id]);
        foreach ($results as $oi) {
            $old_items[$oi['order_item_id']] = ['product' => $oi['product_id'], 'qty' => $oi['quantity']];
        }

        // Update order dengan customer dan status baru
        $db->update("orders", [
            "customer_id" => $customer_id,
            "status" => $status
        ], ["order_id" => $order_id]);
    } else {
        // Insert order baru
        $db->insert("orders", [
            "customer_id" => $customer_id,
            "status" => $status
        ]);
        $order_id = $conn->lastInsertId();
        $old_items = [];
    }

    // Untuk melacak item yang di-update/insert
    $updated_ids = [];
    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $quantity = (int)$quantities[$i];
        $data_order = $order_dates[$i] ?? date('Y-m-d');
        $order_item_id = $order_item_ids[$i] ?? null;

        // Skip item kosong atau tidak valid
        if (empty($product_id) || $quantity <= 0) continue;

        if ($order_item_id) {
            // Jika item sudah ada, update quantity dan cek selisih stock
            $old_qty = $old_items[$order_item_id]['qty'] ?? 0;
            $diff = $quantity - $old_qty;
            if ($diff > 0) {
                // Jika jumlah bertambah, kurangi stock
                $db->runRawQuery("UPDATE products SET stock_qty = stock_qty - ? WHERE product_id = ?", [$diff, $product_id]);
            } elseif ($diff < 0) {
                // Jika jumlah berkurang, kembalikan stock
                $db->runRawQuery("UPDATE products SET stock_qty = stock_qty + ? WHERE product_id = ?", [abs($diff), $old_items[$order_item_id]['product']]);
            }

            // Update item order
            $db->update("order_items", [
                "product_id" => $product_id,
                "quantity" => $quantity,
                "data_order" => $data_order
            ], ["order_item_id" => $order_item_id]);
            $updated_ids[] = $order_item_id;
        } else {
            // Jika item baru, insert ke database
            $db->insert("order_items", [
                "order_id" => $order_id,
                "product_id" => $product_id,
                "quantity" => $quantity,
                "data_order" => $data_order
            ]);
            $new_id = $conn->lastInsertId();
            $db->runRawQuery("UPDATE products SET stock_qty = stock_qty - ? WHERE product_id = ?", [$quantity, $product_id]);
            $updated_ids[] = $new_id;
        }
    }

    // Jika mode edit, hapus item yang tidak ada lagi dan kembalikan stock
    if ($action === 'edit') {
        $to_delete = array_diff(array_keys($old_items), $updated_ids);
        if (!empty($to_delete)) {
            $placeholders = implode(',', array_fill(0, count($to_delete), '?'));

            // Ambil item yang akan dihapus
            $deleted_items = $db->runRawQuery("SELECT order_item_id, product_id, quantity FROM order_items WHERE order_item_id IN ($placeholders)", $to_delete);
            foreach ($deleted_items as $oi) {
                // Kembalikan stock untuk item yang dihapus
                $db->runRawQuery("UPDATE products SET stock_qty = stock_qty + ? WHERE product_id = ?", [$oi['quantity'], $oi['product_id']]);
            }

            // Hapus item dari database
            $stmt = $conn->prepare("DELETE FROM order_items WHERE order_item_id IN ($placeholders)");
            $stmt->execute($to_delete);
        }
    }

    // Commit transaksi jika semua berhasil
    $conn->commit();
    echo json_encode(SUCCESS);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
