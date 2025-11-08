<?php
require_once("../backend/dbconnect.php");

$db = new DBController();
$conn = $db->conn;

// Menggunakan prepared statement untuk keamanan
$sql = "
    SELECT 
        o.order_id, 
        c.full_name, 
        MAX(oi.data_order) AS data_order,
        SUM(p.price * oi.quantity) AS subtotal, 
        o.status
    FROM orders o
    JOIN customers c ON c.customer_id = o.customer_id
    JOIN order_items oi ON oi.order_id = o.order_id
    JOIN products p ON p.product_id = oi.product_id
    GROUP BY o.order_id, c.full_name, o.status
    ORDER BY data_order DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inisialisasi XML document
$xml = new DOMDocument("1.0", "UTF-8");
$xml->formatOutput = true;

$root = $xml->createElement("orders");

foreach ($orders as $row) {
    $order = $xml->createElement("order");

    foreach ([
        "order_id" => $row['order_id'],
        "customer_name" => $row['full_name'],
        "order_date" => $row['data_order'],
        "subtotal" => $row['subtotal'],
        "status" => $row['status']
    ] as $tag => $value) {
        $element = $xml->createElement($tag);
        $element->appendChild($xml->createTextNode($value));
        $order->appendChild($element);
    }

    $root->appendChild($order);
}

$xml->appendChild($root);

// Output sebagai unduhan file XML
header("Content-Type: application/xml");
header("Content-Disposition: attachment; filename=orders.xml");
echo $xml->saveXML();
exit;
