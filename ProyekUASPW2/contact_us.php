<?php
include('backend/dbconnect.php');

header('Content-Type: application/json');

// Menyiapkan array untuk respons
$response = array();

// Mengecek apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DBController();

    // Mengambil data email dan message dari form, atau kosong jika tidak ada
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Mengecek apakah email dan message tidak kosong
    if (!empty($email) && !empty($message)) {
        // Menyiapkan data untuk disisipkan
        $insertData = [
            'email' => $email,
            'message' => $message
        ];

        // Memanggil fungsi insert dari DBController
        $success = $db->insert('contact_us', $insertData);

        if ($success) {
            $response['success'] = true;
            $response['msg'] = "Message sent successfully!";
        } else {
            $response['success'] = false;
            $response['msg'] = "Failed to send message.";
        }
    } else {
        $response['success'] = false;
        $response['msg'] = "Please fill in all fields.";
    }
} else {
    $response['success'] = false;
    $response['msg'] = "Invalid request.";
}

echo json_encode($response);
?>
