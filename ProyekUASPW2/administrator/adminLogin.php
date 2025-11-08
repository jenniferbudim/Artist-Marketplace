<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mt-5">
            <h1>Admin Login</h1>
            <hr> 
            <?php if (!empty($loginError)): ?>
                <p style="color:red;"><?php echo htmlspecialchars($loginError); ?></p>
            <?php endif; ?>
            <form action="index.php" method="POST">
                <!-- Username -->
                <label for="admin_name"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="admin_name" id="admin_name" required class="form-control" value="<?= isset($oldUsername) ? htmlspecialchars($oldUsername) : ''?>">

                <!-- Password -->
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter password" name="password" id="password" required class="form-control">

                <button type="submit" class="registerbtn btn btn-hover">Login</button>
            </form>

            <div class="container signin">
                <p>Don't have an account? <br> <a href="../administrator/signup">Sign Up</a>.</p>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5 align-self-center d-none d-md-block">
            <img src="../images/wirly.png" width="500px" alt="Lotus Flowers">
        </div>
    </div>
</div>
