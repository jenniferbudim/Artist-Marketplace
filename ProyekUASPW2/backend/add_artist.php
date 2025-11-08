<?php
require_once("dbconnect.php");
$db = new DBController();

// prepare data
$data = [
  'display_name' => $_POST['display_name'],
  'display_image' => $_POST['display_image'],
  'email'        => $_POST['email'],
  'bio'          => $_POST['bio'],
  'joined_at'    => date('Y-m-d H:i:s')
];

// use insert()
$db->insert('artists', $data);

// redirect back
header('Location: ../administrator/artists');
exit;
