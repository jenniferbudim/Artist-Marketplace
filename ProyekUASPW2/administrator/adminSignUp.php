<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mt-5">
            <h1>Admin Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <!-- Display error message -->
            <p id="error-message" class="text-danger">
                <?php
                if (isset($_SESSION['signupError'])) {
                    echo htmlspecialchars($_SESSION['signupError']);
                    unset($_SESSION['signupError']);
                }
                ?>
            </p>

            <!-- Sign-up form -->
            <form id="form" action="index.php" method="POST">
                <input type="hidden" name="page" value="su">

                <!-- Full Name -->
                <label for="username-input"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="username" id="username-input"
                    class="form-control mb-2" required>

                <!-- Email -->
                <label for="email-input"><b>Email</b></label>
                <input type="text" placeholder="Enter email" name="email" id="email-input" class="form-control mb-2"
                    required>

                <!-- Password -->
                <label for="password-input"><b>Password</b></label>
                <input type="password" placeholder="Enter password" name="password" id="password-input"
                    class="form-control mb-2" required>

                <!-- Repeat Password -->
                <label for="repeat-password-input"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat password" name="repeat-password" id="repeat-password-input"
                    class="form-control mb-3" required>

                <!-- Referral Code -->
                <label for="referral-code-input"><b>Referral Code</b></label>
                <input type="text" placeholder="Enter referral code" name="referral_code" id="referral-code-input"
                    class="form-control mb-3" required>

                <!-- Register button -->
                <button type="submit" class="registerbtn btn btn-hover">Register</button>
            </form>

            <!-- Redirect to sign-in -->
            <div class="container signin mt-3">
                <p>Already have an account? <br> <a href="../administrator/signin">Sign In</a>.</p>
            </div>
        </div>

        <!-- Image section -->
        <div class="col-md-1"></div>
        <div class="col-md-5 align-self-center d-none d-md-block">
            <img src="../images/background.png" width="500px" alt="Lotus Flowers">
        </div>
    </div>
</div>