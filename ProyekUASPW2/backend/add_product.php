<?php
require_once("dbconnect.php");
$db = new DBController();

$data = [
  'artist_id'    => $_POST['artist_id'],
  'title'        => $_POST['title'],
  'category'     => $_POST['category'],
  'product_image' => $_POST['product_image'],
  'product_desc' => $_POST['product_desc'],
  'price'        => $_POST['price'],
  'stock_qty'    => $_POST['stock_qty'],
  'created_at'   => date('Y-m-d H:i:s')
];

$db->insert('products', $data);

header('Location: ../administrator/artists');
exit;
