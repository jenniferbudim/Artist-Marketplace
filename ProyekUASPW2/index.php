<?php
session_start();
include("backend/dbconnect.php");
$db = new DBController();

$loginError = "";

// Menentukan halaman (dari GET or POST)
$page = $_POST['page'] ?? $_GET['page'] ?? null;

// Menangani logika sign in 
if ($_SERVER["REQUEST_METHOD"] == "POST" && $page === "si" && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userData = $db->getRows("customers", ["where" => ["email" => $email]]);
    $user = $userData[0] ?? null;

    if ($user && md5($password) === $user['password']) {
        $_SESSION['customer_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['has_visited'] = true;

        header("Location: ../ProyekUASPW2/home");
        exit;
    } else {
        $_SESSION['loginError'] = "Invalid email or password.";
        $_SESSION['old_email'] = $email;
        $_SESSION['has_visited'] = false;
        header("Location: ../ProyekUASPW2/signin");
        exit;
    }
}

// Menangani logika sign up
if ($_SERVER["REQUEST_METHOD"] == "POST" && $page === "su" && isset($_POST['fullname'], $_POST['email'], $_POST['password'], $_POST['repeat-password'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat-password'];

    if (empty($fullname) || empty($email) || empty($password) || empty($repeatPassword)) {
        $_SESSION['signupError'] = "Please fill in all fields.";
        header("Location: ../ProyekUASPW2/signup");
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signupError'] = "Invalid email format.";
        header("Location: ../ProyekUASPW2/signup");
        exit;
    } elseif ($password !== $repeatPassword) {
        $_SESSION['signupError'] = "Passwords do not match.";
        header("Location: ../ProyekUASPW2/signup");
        exit;
    } else {
        // Memastikan email sudah ada
        $existingUser = $db->getRows("customers", ["where" => ["email" => $email]]);
        if ($existingUser) {
            $_SESSION['signupError'] = "Email already registered.";
            header("Location: ../ProyekUASPW2/signup");
            exit;
        } else {
            // Masukin user baru
            $inserted = $db->insert("customers", [
                "full_name" => $fullname,
                "email" => $email,
                "password" => md5($password)
            ]);

            if ($inserted) {
                $_SESSION['email'] = $email;
                $_SESSION['has_visited'] = true;

                $user = $db->getRows("customers", ["where" => ["email" => $email]]);
                $_SESSION['customer_id'] = $user[0]['id'] ?? null;

                $_SESSION['signupSuccess'] = "Registration successful. Please sign in.";
                header("Location: ../ProyekUASPW2/signin");
                exit;
            } else {
                $_SESSION['signupError'] = "Something went wrong. Please try again.";
                header("Location: ../ProyekUASPW2/signup");
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include("framework/html_head.html"); ?>
</head>

<body>
    <?php
    // Menentukan nav yang digunakan
    $mod = "";

    // Jika pengguna secara eksplisit menetapkan halaman
    if ($page) {
        $mod = $page;
    } else {
        // Jika belum, defaultnya sign in
        if (!isset($_SESSION['customer_id'])) {
            $mod = "si"; // Sign In
        } else {
            $mod = "h"; // Home
        }
    }

    // nav2.php untuk Sign In dan Sign Up, sisanya memakai nav.php
    if (in_array($mod, ['si', 'su'])) {
        include("framework/nav2.php");
    } else {
        include("framework/nav.php");
    }

    ?>

    <section>
        <?php
        $content = "";

        switch ($mod) {
            // Page Utama
            case "h":
                $content = "mainPages/home.php";
                break;
            case "ab":
                $content = "mainPages/about.php";
                break;
            case "sp":
                $content = "mainPages/spotlight.php";
                break;
            case "sh":
                $content = "mainPages/shop.php";
                break;

            // Page Pendukung
            case "ord":
                $content = "otherPages/order.php";
                break;
            case "si":
                $content = "otherPages/signIn.php";
                break;
            case "su":
                $content = "otherPages/signUp.php";
                break;
            case "wk":
                $content = "otherPages/news.php";
                break;
            case "in":
                $content = "otherPages/item_news.php";
                break;
            case "id":
                $content = "otherPages/jennifer.php";
                break;
            case "pf":
                $content = "otherPages/profile.php";
                break;
            case "ad":
                $content = "otherPages/artist_desc.php";
                break;

            // Default ketika pertama buka adalah Sign In
            default:
                $content = "otherPages/signIn.php";
                break;
        }

        include($content);
        ?>
    </section>
    <?php
    // footer2.php untuk Sign In dan Sign Up, sisanya memakai footer.php
    if (in_array($mod, ['si', 'su'])) {
        include("framework/footer2.php");
    } else {
        include("framework/footer.php");
    }
    ?>
</body>

</html>