<?php
session_start();
include("../backend/dbconnect.php");
$db = new DBController();

$loginError = "";
$oldUsername  = "";

// Menangani submit form sign in admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_name'], $_POST['password'])) {
    $admin_name = $_POST['admin_name'];
    $password = $_POST['password'];

    $adminData = $db->getRows("admins", ["where" => ["admin_name" => $admin_name]]);
    $admin = $adminData[0] ?? null;

    if ($admin && md5($password) === $admin['password']) {
        session_unset();
        session_destroy();
        session_start();

        $_SESSION['admin_name'] = $admin['admin_name'];
        $_SESSION['admin_id'] = $admin['id'];

        header("Location: ../administrator/home");
        exit;
    } else {
        $loginError = "Invalid username or password.";
        $oldUsername = $admin_name;
    }
}

// Menangani submit form sign up admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['page']) && $_POST['page'] === "su") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat-password'];
    $referralCode = trim($_POST['referral_code']);
    $expectedReferralCode = "Ar2025";

    if (empty($username) || empty($email) || empty($password) || empty($referralCode)) {
        $_SESSION['signupError'] = "All fields are required.";
        header("Location: ../administrator/signup");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signupError'] = "Invalid email format.";
        header("Location: ../administrator/signup");
        exit;
    }

    if ($password !== $repeatPassword) {
        $_SESSION['signupError'] = "Passwords do not match.";
        header("Location: ../administrator/signup");
        exit;
    }

    if ($referralCode !== $expectedReferralCode) {
        $_SESSION['signupError'] = "Invalid referral code.";
        header("Location: ../administrator/signup");
        exit;
    }

    if ($db->getRows("admins", ["where" => ["admin_name" => $username]])) {
        $_SESSION['signupError'] = "Username already taken.";
        header("Location: ../administrator/signup");
        exit;
    }

    if ($db->getRows("admins", ["where" => ["email" => $email]])) {
        $_SESSION['signupError'] = "Email already registered.";
        header("Location: ../administrator/signup");
        exit;
    }

    $success = $db->insert("admins", [
        "admin_name" => $username,
        "email" => $email,
        "password" => md5($password)
    ]);

    if ($success) {
        $_SESSION['admin_name'] = $username;
        $_SESSION['admin_id'] = $db->conn->lastInsertId();
        header("Location: ../administrator/signin");
        exit;
    } else {
        $_SESSION['signupError'] = "Registration failed. Please try again.";
        header("Location: ../administrator/signup");
        exit;
    }
}

// Tentukan halaman mana yang akan ditampilkan
$mod = isset($_GET['page']) ? $_GET['page'] : (isset($_SESSION['admin_id']) ? "h" : "si");

switch ($mod) {
    case "h": $content = "home.php"; break;
    case "gi": $content = "items.php"; break;
    case "c" : $content = "content.php"; break;
    case "si": $content = "adminLogin.php"; break;
    case "su": $content = "adminSignUp.php"; break;
    case "sn": $content = "see_news.php"; break;
    case "an": $content = "add_news.php"; break;
    default: $content = "home.php"; break;
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include("html_head.html"); ?>
</head>
<body>
    <?php include("nav.php"); ?>
    <section>
        <?php include($content); ?>
    </section>
    <?php include("footer.php"); ?>
</body>
</html>