<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loginError = $_SESSION['loginError']   ?? '';
$oldEmail   = $_SESSION['old_email']    ?? '';

unset($_SESSION['loginError'], $_SESSION['old_email']);
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mt-5">
            <h1>Login</h1>

            <hr>
            <!-- Error message -->
            <p id="error-message" style="color:red;">
                <?php if (!empty($loginError))
                    echo htmlspecialchars($loginError); ?>
            </p>
            <form id="form" action="index.php" method="POST">
                <input type="hidden" name="page" value="si">

                <!-- Email -->
                <label for="email-input"><b>Email</b></label>
                <input type="text" placeholder="Enter email" name="email" id="email-input" required class="form-control" value="<?= htmlspecialchars($oldEmail) ?>">

                <!-- Password -->
                <label for="password-input"><b>Password</b></label>
                <input type="password" placeholder="Enter password" name="password" id="password-input" required class="form-control">

                <!-- Login -->
                <button type="submit" class="registerbtn">Login</button>
            </form>

            <!-- Link Sign Up -->
            <div class="container signin">
                <p>Don't have an account? <br> <a href="../ProyekUASPW2/signup">Sign Up</a>.</p>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5 align-self-center d-none d-md-block">
            <img src="images/wirly.png" width="500px" alt="Lotus Flowers">
        </div>
    </div>
</div>