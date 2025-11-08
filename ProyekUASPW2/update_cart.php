<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['remove'])) {
    $removeId = $data['remove'];
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($removeId) {
            return $item['id'] != $removeId;
        });
    }
    echo json_encode(["status" => "removed"]);
    exit;
}

if (is_array($data)) {
    $_SESSION['cart'] = $data;
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
