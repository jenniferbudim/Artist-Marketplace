<?php
require_once("backend/dbconnect.php");
$db = new DBController();
$conn = $db->conn;

session_start();

// Untuk respons JSON atau pengalihan
header('Content-Type: application/json');

// Dapatkan data formulir
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$postcode = trim($_POST['postcode'] ?? '');
$product_ids = $_POST['product_id'] ?? [];
$quantities = $_POST['quantity'] ?? [];
$order_dates = $_POST['data_order'] ?? [];

if (empty($full_name) || empty($email) || count($product_ids) === 0) {
    echo json_encode(['success' => false, 'message' => 'Incomplete customer or order data.']);
    exit;
}

try {
    $conn->beginTransaction();

    // Temukan atau masukkan pelanggan
    $stmt = $conn->prepare("SELECT customer_id FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($customer) {
        $customer_id = $customer['customer_id'];
        // Perbarui alamat/kode pos jika berubah
        $updateCustomer = $conn->prepare("UPDATE customers SET full_name = ?, address = ?, postcode = ? WHERE customer_id = ?");
        $updateCustomer->execute([$full_name, $address, $postcode, $customer_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (full_name, email, address, postcode) VALUES (?, ?, ?, ?)");
        $stmt->execute([$full_name, $email, $address, $postcode]);
        $customer_id = $conn->lastInsertId();
    }

    // Buat pesanan baru
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, status) VALUES (?, 'Pending')");
    $stmt->execute([$customer_id]);
    $order_id = $conn->lastInsertId();

    // Menyiapkan statement untuk item dan penyesuaian stok
    $insertItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, data_order) VALUES (?, ?, ?, ?)");
    $stockDeduct = $conn->prepare("UPDATE products SET stock_qty = stock_qty - ? WHERE product_id = ?");

    // Masukkan item pesanan dan kurangi stok
    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $quantity = (int)$quantities[$i];
        $date = $order_dates[$i] ?? date('Y-m-d');

        if (!empty($product_id) && $quantity > 0) {
            // Insert item order
            $insertItem->execute([$order_id, $product_id, $quantity, $date]);
            // Kurangin stok
            $stockDeduct->execute([$quantity, $product_id]);
        }
    }

    $conn->commit();

    // Clear cart session
    unset($_SESSION['cart']);

    // Redirect to home
    header("Location: ../ProyekUASPW2/home");
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => 'Order failed: ' . $e->getMessage()]);
    exit;
}