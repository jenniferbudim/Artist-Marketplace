<?php
require_once 'backend/dbconnect.php';
$db = new DBController();

// Sanitasi dan validasi artist_id
$artist_id = isset($_GET['artist_id']) ? intval($_GET['artist_id']) : 0;

if ($artist_id <= 0) {
    echo "<p>Invalid artist.</p>";
    exit;
}

// Ambil detail artis menggunakan getRows()
$artist = $db->getRows("artists", [
    "where" => ["artist_id" => $artist_id]
]);

if (!$artist) {
    echo "<p>Artist not found.</p>";
    exit;
}
$artist = $artist[0]; // getRows returns an array

// Ambil produk dari artis yang sama menggunakan getRows()
$products = $db->getRows("products p JOIN artists a ON p.artist_id = a.artist_id", [
    "select" => "p.product_id, p.title, p.price, p.product_desc, p.product_image, a.display_name, a.display_image",
    "where" => ["p.artist_id" => $artist_id]
]);
?>


<div class="background2">
    <div class="container">
        <br>
        <!-- Menampilkan nama artist -->
        <h1 class="text-center text-white"><?= htmlspecialchars($artist['display_name']) ?></h1>
        <br>
        <!-- Menampilkan display image artist -->
        <div class="d-flex justify-content-center">
            <img src="../ProyekUASPW2/images/<?= htmlspecialchars($artist['display_image']) ?>"
                class="card-img-top mb-3" style="height: 300px; width: 300px; object-fit: cover; border-radius: 10px;"
                alt="<?= htmlspecialchars($artist['display_name']) ?>">
        </div>
        <br>
        <!-- Menampilkan bio artist -->
        <h5 class="text-center text-medium"><?= nl2br(htmlspecialchars($artist['bio'])) ?></h5>

        <!-- Menampilkan produk-produk artist -->
        <div class="row mt-4">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 d-flex justify-content-center mb-4">
                    <div class="card p-3 w-100 medium">
                        <div class="image-container">
                            <img src="images/<?= htmlspecialchars($product['product_image']) ?>" class="card-img-top"
                                style="max-height: 250px; object-fit: contain;"
                                alt="<?= htmlspecialchars($product['title']) ?>">
                            <div class="item__overlay">
                                <div class="item__body text-center">
                                    <h5>More Information</h5>
                                    <p style="padding: 0 15px; word-wrap: break-word; text-align: center;">
                                        <?= nl2br(htmlspecialchars($product['product_desc'])) ?>
                                    </p>
                                    <p><strong>By:</strong> <?= htmlspecialchars($product['display_name']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h4><?= htmlspecialchars($product['title']) ?></h4>
                            <p><span class="price"><?= htmlspecialchars($product['price']) ?></span>$</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Button ke shop -->
    <div class="p-3 d-flex justify-content-center">
        <button type="button" class="btn btn-lg text-white btn-hover"
            onclick="window.location.href='../ProyekUASPW2/shop'">Shop</button>
    </div>
    <br>
</div>