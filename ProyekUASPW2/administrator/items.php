<?php
require_once("../backend/dbconnect.php");
$db = new DBController();

// Ambil produk untuk dropdown
$products = $db->getRows("products", [
  'select' => 'product_id, title, price',
  'order_by' => 'title ASC'
]);
?>

<div class="background2">
  <div class="container">
    <br>
    <div class="mb-4">
      <div class="row align-items-start align-items-md-center">
        <div class="col-12 col-md-6 mb-2 mb-md-0">
          <h2 class="text-white m-0">Order List</h2>
        </div>
        <!-- Button Download XML dan Add Order-->
        <div class="col-12 col-md-6 d-flex gap-2 flex-column flex-md-row justify-content-md-end mt-3">
          <a href="download_xml.php" class="btn btn-lg text-white btn-hover">Download XML</a>
          <button class="btn btn-lg text-white btn-hover" id="addOrderBtn">Add Order</button>
        </div>
      </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="table-responsive">
      <table class="table table-success table-bordered">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Order Date</th>
            <th>Subtotal</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Query menggunakan runRawQuery
          $sql = "
          SELECT o.order_id, c.full_name, MAX(oi.data_order) AS data_order,
                 SUM(p.price * oi.quantity) AS subtotal, o.status
          FROM orders o
          JOIN customers c ON c.customer_id = o.customer_id
          JOIN order_items oi ON oi.order_id = o.order_id
          JOIN products p ON p.product_id = oi.product_id
          GROUP BY o.order_id, c.full_name, o.status
          ORDER BY order_id DESC
        ";

          $orders = $db->runRawQuery($sql);

          if ($orders) {
            foreach ($orders as $row) {
              echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['full_name']}</td>
                    <td>{$row['data_order']}</td>
                    <td>{$row['subtotal']}</td>
                    <td>{$row['status']}</td>
                    <td>
                      <button class='btn btn-sm accent-hover editBtn' data-id='{$row['order_id']}'>Edit</button>
                    </td>
                  </tr>";
            }
          } else {
            echo "<tr><td colspan='6' class='text-center'>No orders found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <br>
    <!-- Button Kembali ke Dashboard -->
    <button type="button" class="btn btn-lg text-white btn-hover"
      onclick="window.location.href='../administrator/home'">
      Back to Dashboard
    </button>
  </div>

  <!-- Modal Form Order -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST" id="orderForm">
        <div class="modal-content modal-light">
          <div class="modal-header dark">
            <h5 class="modal-title text-white">Order</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="order_id" id="order_id">
            <input type="hidden" name="action" id="action" value="add">

            <div class="mb-3">
              <label for="full_name" class="form-label">Customer Name</label>
              <input type="text" name="full_name" id="full_name" class="form-control input-custom" required>
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select input-custom" required>
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
                <option value="Shipped">Shipped</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </div>

            <hr>
            <h5>Items</h5>
            <div class="table-responsive">
              <table class="table table-bordered table-success" id="itemsTable">
                <thead>
                  <tr>
                    <th class="d-none d-sm-table-cell">Product</th>
                    <th class="d-none d-sm-table-cell">Unit Price</th>
                    <th class="d-none d-sm-table-cell">Total</th>
                    <th class="d-none d-sm-table-cell">Subtotal</th>
                    <th class="d-none d-sm-table-cell">Order Date</th>
                    <th class="d-none d-sm-table-cell">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Item dimasukkan secara dinamis melalui JS -->
                </tbody>
              </table>
            </div>
            <button type="button" class="btn dark-hover text-white" id="addItemBtn">Add Item</button>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-hover">Save</button>
            <button type="button" class="btn accent-hover" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Product options template -->
  <select class="form-select product-select d-none" id="product-template">
    <option value="">-- Choose Product --</option>
    <?php foreach ($products as $product): ?>
      <option value="<?= $product['product_id'] ?>" data-price="<?= $product['price'] ?>">
        <?= htmlspecialchars($product['title']) ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>
