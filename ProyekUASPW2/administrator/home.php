<?php
// jika admin_name tidak ada, bawa ke halaman sign in
if (empty($_SESSION['admin_name'])) {
  header('Location: ../administrator/signin');
  exit;
}

// mengambil nama admin dari session login
$adminUsername = $_SESSION['admin_name'];

// mengambil data dari contact_us
$messages = $db->getRows("contact_us", [
  "select" => "email, message"
]);
?>

<div class="background3">
  <div class="container">
    <div class="mt-2 mb-2">
      <br>
      <h4 class="text-white">Welcome, Admin <?= htmlspecialchars($adminUsername) ?></h4>
    </div>
    <br>
    <div class="mt-5">
      <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-4 d-flex flex-column align-items-start gap-3">
          <!-- Carousel Gambar -->
          <div id="carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../images/KitchenCrop.png" class="carousel-image" alt="Cozy Kitchen">
              </div>
              <div class="carousel-item">
                <img src="../images/Pokemon.png" class="carousel-image" alt="Pokemon">
              </div>
              <div class="carousel-item">
                <img src="../images/timunmas.png" class="carousel-image" alt="Mountain in Indonesia">
              </div>
              <div class="carousel-item">
                <img src="../images/vibrant.png" class="carousel-image" alt="Vibrant and Lush View">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

          <!-- SHow Orders + Show Artists + Adjust News Button -->
          <div class="d-flex flex-column gap-2">
            <button type="button" class="btn btn-lg text-white btn-hover"
              onclick="window.location.href='../administrator/items'">Show Orders</button>
            <button type="button" class="btn btn-lg text-white btn-hover"
              onclick="window.location.href='../administrator/artists'">Show Artists</button>
            <button type="button" class="btn btn-lg text-white btn-hover"
              onclick="window.location.href='../administrator/see-news'">Adjust News</button>
          </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-8">
          <!-- Logout -->
          <div class="container d-flex justify-content-end">
            <button type="button" class="btn btn-lg text-white btn-hover"
              onclick="window.location.href='logout.php'">Logout</button>
          </div>

          <br>

          <h4 class="mb-4">Contact Messages</h4>

          <!-- Tabel Contact Us -->
          <div class="table-responsive">
            <table class="table table-bordered table-success">
              <thead>
                <tr>
                  <th>Email</th>
                  <th>Message</th>
                </tr>
              </thead>
              <tbody class="table table-light">
                <?php if (!empty($messages)): ?>
                  <?php foreach ($messages as $msg): ?>
                    <tr>
                      <td><?= htmlspecialchars($msg['email']) ?></td>
                      <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="2" class="text-center">No messages found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
  <br>
</div>