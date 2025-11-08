<?php
require_once("dbconnect.php");
$db = new DBController();

if (isset($_POST['product_id'])) {
    $db->delete('products', ['product_id' => $_POST['product_id']]);
}

header('Location: ../administrator/artists');
exit;
