<div class="container p-4">
    <div class="row"> 
        <div class="col-md-6 mt-5">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <!-- Pesan error -->
            <p id="error-message" class="text-danger">
                <?php
                if (isset($_SESSION['signupError'])) {
                    echo htmlspecialchars($_SESSION['signupError']);
                    unset($_SESSION['signupError']);
                }
                ?>
            </p>

            <form id="form" action="index.php" method="POST">
                <input type="hidden" name="page" value="su">

                <!-- Full Name -->
                <label for="fullname-input"><b>Full Name</b></label>
                <input type="text" placeholder="Enter full name" name="fullname" id="fullname-input"
                       class="form-control mb-2" required>

                <!-- Email -->
                <label for="email-input"><b>Email</b></label>
                <input type="text" placeholder="Enter email" name="email" id="email-input"
                       class="form-control mb-2" required>

                <!-- Password -->
                <label for="password-input"><b>Password</b></label>
                <input type="password" placeholder="Enter password" name="password" id="password-input"
                       class="form-control mb-2" required>

                <!-- Repeat Password -->
                <label for="repeat-password-input"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat password" name="repeat-password" id="repeat-password-input"
                       class="form-control mb-3" required>

                <!-- Register -->
                <button type="submit" class="registerbtn">Register</button>
            </form>

            <!-- Link Sign In -->
            <div class="container signin mt-3">
                <p>Already have an account? <br> <a href="../ProyekUASPW2/signin">Sign In</a>.</p>
            </div>
        </div>

        <!-- Image section -->
        <div class="col-md-1"></div>
        <div class="col-md-5 align-self-center d-none d-md-block">
            <img src="images/background.png" width="500px" alt="Lotus Flowers">
        </div>
    </div>
</div>
