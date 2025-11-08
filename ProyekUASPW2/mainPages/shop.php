<?php
// Ambil produk dengan nama artist menggunakan JOIN
// Hanya tarik produk dengan stock_qty > 0
$products = $db->runRawQuery(
    "SELECT 
        p.product_id,
        p.title,
        p.price,
        p.product_image,
        p.product_desc,
        p.stock_qty,
        a.display_name
     FROM products p
     LEFT JOIN artists a ON p.artist_id = a.artist_id
     WHERE p.stock_qty > 0"
);
?>

<div class="containershop p-3">
    <!-- Sidebar Cart -->
    <aside class="light p-2">
        <div class="container">
            <h2>Product Basket</h2>
            <ul id="cart"></ul>
            <div id="total">Total Amount: $0</div>
        </div>
    </aside>

    <!-- Product Cards -->
    <main class="light p-2">
        <div class="container">
            <div class="row">
                <?php
                $count = 0;
                foreach ($products as $product):
                    if ((int) $product['stock_qty'] === 0) {
                        continue;
                    }

                    if ($count % 3 === 0 && $count !== 0) {
                        echo '</div><div class="row mt-4">';
                    }
                    ?>
                    <div class="col-md-4 d-flex justify-content-center mb-4">
                        <div class="card p-3 w-100">
                            <div class="image-container">
                                <img src="images/<?= htmlspecialchars($product['product_image']) ?>" class="card-img-top"
                                    style="max-height: 250px; object-fit: contain;"
                                    alt="<?= htmlspecialchars($product['title']) ?>">
                                <div class="item__overlay">
                                    <div class="item__body text-center">
                                        <h5>More Information</h5>
                                        <p class="hello2" style="padding: 0 15px; word-wrap: break-word; text-align: center;">
                                            <?= nl2br(htmlspecialchars($product['product_desc'])) ?>
                                        </p>
                                        <p><strong>By:</strong> <?= htmlspecialchars($product['display_name']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h4><?= htmlspecialchars($product['title']) ?></h4>
                                <p><span class="price"><?= htmlspecialchars($product['price']) ?></span>$</p>
                                <button class="btn btn-hover add-to-cart" data-id="<?= $product['product_id'] ?>"
                                    data-name="<?= htmlspecialchars($product['title']) ?>"
                                    data-price="<?= $product['price'] ?>">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count++;
                endforeach;
                ?>
            </div>
        </div>
    </main>
</div>

<style>
    .card {
        height: 400px;
        background-color: rgb(110, 160, 133);
        color: rgb(4, 45, 45);
        border-radius: 12px;
        overflow: hidden;
    }

    .card .image-container {
        flex: 6;
        position: relative;
    }

    .card .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card .card-body {
        flex: 4;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>