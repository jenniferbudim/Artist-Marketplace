<?php
require_once("dbconnect.php");
$db = new DBController();

$data = [
    'title' => $_POST['title'],
    'category' => $_POST['category'],
    'price' => $_POST['price'],
    'stock_qty' => $_POST['stock_qty'],
];

$db->update('products', $data, ['product_id' => $_POST['product_id']]);
header('Location: ../administrator/artists');
exit;
