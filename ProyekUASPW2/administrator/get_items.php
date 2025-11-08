<?php
require_once("../backend/dbconnect.php");
header('Content-Type: application/json');

$db = new DBController();

$order_id = $_POST['order_id'] ?? null;

if (!$order_id) {
    echo json_encode(['success' => false, 'message' => 'Order ID tidak ditemukan']);
    exit;
}

// Ambil order and data customer
$order = $db->getRows('orders o 
    JOIN customers c ON c.customer_id = o.customer_id', [
    'select' => 'o.order_id, o.customer_id, c.full_name, o.status',
    'where' => ['o.order_id' => $order_id]
]);

if (!$order || count($order) === 0) {
    echo json_encode(['success' => false, 'message' => 'Order tidak ditemukan']);
    exit;
}

// Dapatkan satu baris
$order = $order[0]; 

// Ambil order items
$items = $db->getRows('order_items oi 
    JOIN products p ON p.product_id = oi.product_id', [
    'select' => 'oi.order_item_id, oi.product_id, oi.quantity, oi.data_order, p.price AS unit_price',
    'where' => ['oi.order_id' => $order_id]
]);

$response = [
    'success' => true,
    'order_id' => $order['order_id'],
    'customer_id' => $order['customer_id'],
    'full_name' => $order['full_name'],
    'status' => $order['status'],
    'items' => $items ?: []
];

echo json_encode($response);
