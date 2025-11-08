<?php
$email = $_SESSION['email'] ?? null;

if (!$email) {
    echo "<p class='text-danger'>User not logged in.</p>";
    return;
}

$updateMsg = "";

// Menangani pembaruan profil
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $updatedData = [
        "full_name" => $_POST['full_name'] ?? '',
        "phone" => $_POST['phone'] ?? '',
        "address" => $_POST['address'] ?? '',
        "postcode" => $_POST['postcode'] ?? ''
    ];

    $success = $db->update("customers", $updatedData, ["email" => $email]);
    $updateMsg = $success ? "Profile updated successfully." : "Failed to update profile.";
}

// Mengambil data customer
$customerData = $db->getRows("customers", ["where" => ["email" => $email]]);
$customer = $customerData[0] ?? null;

if (!$customer) {
    echo "<p class='text-danger'>Customer data not found.</p>";
    return;
}
?>

<!-- Profile -->
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-4 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <!-- Logo -->
                <div class="profile-image" style="width: 300px; height: 300px; overflow: hidden;">
                    <img src="images/Logo.png" style="width: 100%; height: 100%;">
                </div>
                <!-- Full Name -->
                <span class="font-weight-bold mt-2"><?= htmlspecialchars($customer['full_name']) ?></span>
                <!-- Email -->
                <span class="text-black-50"><?= htmlspecialchars($customer['email']) ?></span>
                <!-- Join Date -->
                <span class="text-muted mt-2">Member since:
                    <?= date("F j, Y", strtotime($customer['created_at'])) ?></span>
                <!-- Logout Button -->
                <button class="btn btn-lg text-white btn-hover mt-4" type="button"
                    onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>

        <!-- Data Profile yang bisa ditambahkan -->
        <div class="col-md-8 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>

                <?php if ($updateMsg): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($updateMsg) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="col-md-12">
                        <label class="labels">Full Name</label>
                        <input type="text" class="form-control" name="full_name"
                            value="<?= htmlspecialchars($customer['full_name']) ?>" required>
                    </div>

                    <div class="col-md-12">
                        <label class="labels">Mobile Number</label>
                        <input type="text" class="form-control" name="phone"
                            value="<?= htmlspecialchars($customer['phone']) ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="labels">Address</label>
                        <input type="text" class="form-control" name="address"
                            value="<?= htmlspecialchars($customer['address']) ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="labels">Postcode</label>
                        <input type="text" class="form-control" name="postcode"
                            value="<?= htmlspecialchars($customer['postcode']) ?>">
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <div class="d-flex gap-3">
                            <button class="btn btn-lg text-white btn-hover" name="update_profile" type="submit">Update
                                Profile</button>
                            <button class="btn btn-lg text-white btn-hover" type="button" onclick="window.location.href='redirectAdmin.php'">Administrator</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>