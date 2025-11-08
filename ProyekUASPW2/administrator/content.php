<?php
require_once("../backend/dbconnect.php");
$db = new DBController();

// ambil data dari tabel artists
$artists = $db->getRows("artists", [
    "select" => "artist_id, display_name, bio, joined_at",
    "order_by" => "joined_at ASC"
]);

$categories = ['Art Print', 'Novel', 'Photocard', 'Keychain', 'Jewelry'];
?>

<div class="background3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h3 class="text-white">Artist Catalog</h3>
            
            <!-- Button Tambah Artist -->
            <button class="btn btn-hover" data-bs-toggle="modal" data-bs-target="#addArtistModal">
                Add Artist
            </button>
        </div>

        <?php if (!$artists): ?>
            <div class="alert alert-warning">No artist found.</div>
        <?php else: ?>
            <?php foreach ($artists as $artist): ?>
                <!-- Card Artist -->
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Display Name-->
                        <h5 class="card-title"><?= htmlspecialchars($artist['display_name']) ?></h5>
                        <!-- Tanggal Join -->
                        <h6 class="card-subtitle mb-2 text-muted">
                            Joined: <?= date('d M Y', strtotime($artist['joined_at'])) ?>
                        </h6>
                        <!-- Bio Artist -->
                        <p class="card-text hello"><?= nl2br(htmlspecialchars($artist['bio'])) ?></p>

                        <!-- Button Add Product -->
                        <button class="btn accent-hover btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal"
                            data-artist-id="<?= $artist['artist_id'] ?>"
                            data-artist-name="<?= htmlspecialchars($artist['display_name'], ENT_QUOTES) ?>">
                            Add Product
                        </button>

                        <?php
                        // Ambil product setiap artist
                        $products = $db->getRows("products", [
                            "select" => "product_id, title, category, price, stock_qty",
                            "where" => ["artist_id" => $artist['artist_id']],
                            "order_by" => "created_at DESC"
                        ]);
                        ?>

                        <?php if ($products): ?>
                            <!-- Tabel Product -->
                            <h6 class="mt-4">Products</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-success">
                                        <tr>
                                            <th style="width: 40%;">Title</th>
                                            <th style="width: 20%;">Category</th>
                                            <th style="width: 15%;">Price</th>
                                            <th style="width: 10%;">Stock</th>
                                            <th style="width: 15%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-light">
                                        <?php foreach ($products as $prod): ?>
                                            <tr>
                                                <!-- Title -->
                                                <td><?= htmlspecialchars($prod['title']) ?></td>
                                                <!-- Kategori -->
                                                <td><?= htmlspecialchars($prod['category']) ?></td>
                                                <!-- Harga -->
                                                <td><?= number_format($prod['price'], 2) ?></td>
                                                <!-- Jumlah Stok-->
                                                <td><?= $prod['stock_qty'] === null ? '∞' : $prod['stock_qty'] ?></td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-hover" data-bs-toggle="modal"
                                                        data-bs-target="#editProductModal" data-product-id="<?= $prod['product_id'] ?>"
                                                        data-title="<?= htmlspecialchars($prod['title'], ENT_QUOTES) ?>"
                                                        data-category="<?= htmlspecialchars($prod['category'], ENT_QUOTES) ?>"
                                                        data-price="<?= $prod['price'] ?>" data-stock="<?= $prod['stock_qty'] ?>">
                                                        Edit
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <form action="../backend/delete_product.php" method="post" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                        <input type="hidden" name="product_id" value="<?= $prod['product_id'] ?>">
                                                        <button type="submit" class="btn btn-sm accent-hover">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mt-4">No products yet.</p>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- Button Kembali ke Dashboard -->
        <button type="button" class="btn btn-lg text-white btn-hover"
            onclick="window.location.href='../administrator/home'">
            Back to Dashboard
        </button>
        <br>
    </div>
</div>

<!-- Add Artist Modal -->
<div class="modal fade" id="addArtistModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="../backend/add_artist.php" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header dark">
                <h5 class="modal-title text-white">Add New Artist</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body light">
                <div class="mb-3">
                    <label>Display Name</label>
                    <input type="text" name="display_name" class="form-control input-custom" required>
                </div>
                <div class="mb-3">
                    <label>Image</label>
                    <input type="text" name="display_image" class="form-control input-custom">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control input-custom" required>
                </div>
                <div class="mb-3">
                    <label>Bio</label>
                    <textarea name="bio" class="form-control input-custom" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer light">
                <button type="submit" class="btn btn-hover input-custom">Save Artist</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="../backend/add_product.php" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header dark">
                <h5 class="modal-title text-white">
                    Add Product for <span id="modalArtistName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body light">
                <input type="hidden" name="artist_id" id="modalArtistId">
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control input-custom" required>
                </div>
                <div class="mb-3">
                    <label>Category</label>
                    <select name="category" class="form-control input-custom" required>
                        <option value="" disabled selected>— Select Category —</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>">
                                <?= htmlspecialchars($cat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Product Image</label>
                    <input type="text" name="product_image" class="form-control input-custom">
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="product_desc" class="form-control input-custom" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label>Price</label>
                    <input type="number" name="price" step="0.01" class="form-control input-custom">
                </div>
                <div class="mb-3">
                    <label>Stock Quantity</label>
                    <input type="number" name="stock_qty" class="form-control input-custom">
                </div>
            </div>
            <div class="modal-footer light">
                <button type="submit" class="btn btn-hover">Save Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="../backend/edit_product.php" method="post" class="modal-content">
            <div class="modal-header dark">
                <h5 class="modal-title text-white">Edit Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body light">
                <input type="hidden" name="product_id" id="editProductId">
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" id="editTitle" class="form-control input-custom" required>
                </div>
                <div class="mb-3">
                    <label>Category</label>
                    <select name="category" id="editCategory" class="form-control input-custom" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" id="editPrice" class="form-control input-custom">
                </div>
                <div class="mb-3">
                    <label>Stock Quantity</label>
                    <input type="number" name="stock_qty" id="editStock" class="form-control input-custom">
                </div>
            </div>
            <div class="modal-footer light">
                <button type="submit" class="btn btn-hover">Update Product</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('addProductModal').addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        this.querySelector('#modalArtistId').value = btn.dataset.artistId;
        this.querySelector('#modalArtistName').textContent = btn.dataset.artistName;
    });

    const editProductModal = document.getElementById('editProductModal');
    editProductModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        this.querySelector('#editProductId').value = button.getAttribute('data-product-id');
        this.querySelector('#editTitle').value = button.getAttribute('data-title');
        this.querySelector('#editCategory').value = button.getAttribute('data-category');
        this.querySelector('#editPrice').value = button.getAttribute('data-price');
        this.querySelector('#editStock').value = button.getAttribute('data-stock');
    });
</script>