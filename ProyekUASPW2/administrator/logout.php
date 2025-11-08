<?php
session_start();
unset($_SESSION['admin_name']);
session_unset();
session_destroy();
header("Location: ../"); 
exit;
?>
