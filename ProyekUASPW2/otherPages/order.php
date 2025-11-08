<?php
$email = $_SESSION['email'];

// mengambil data dari database
$rows = $db->getRows('customers', [
  'select' => 'customer_id, full_name, email, address, postcode',
  'where' => ['email' => $email]
]);

$customer = $rows ? $rows[0] : null;
if (!$customer) {
  echo "<p class='text-danger'>Customer data not found.</p>";
  exit;
}
?>

<div class="container my-5">
  <div class="row">
    <!-- Shipping Form -->
    <div class="col-md-7">
      <h3>Shipping Address</h3>
      <form id="checkout-form" action="place_order.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="customer_id" value="<?= htmlspecialchars($customer['customer_id']) ?>">

        <label for="fullname-input"><b>Full Name</b></label>
        <input type="text" id="fullname-input" name="full_name" class="form-control mb-3"
          value="<?= htmlspecialchars($customer['full_name']) ?>" required>

        <label for="email-input"><b>Email</b></label>
        <input type="text" id="email-input" name="email" class="form-control mb-3"
          value="<?= htmlspecialchars($customer['email']) ?>" required>

        <label for="address-input"><b>Address</b></label>
        <input type="text" id="address-input" name="address" class="form-control mb-3"
          value="<?= htmlspecialchars($customer['address']) ?>" required>

        <label for="postcode-input"><b>Zipcode</b></label>
        <input type="text" id="postcode-input" name="postcode" class="form-control mb-3"
          value="<?= htmlspecialchars($customer['postcode']) ?>" required>

        <div class="container dark text-light p-3 mb-4">
          <h5>Upload Proof of Payment</h5>
          <input type="file" name="file" class="form-control">
        </div>

        <button type="submit" class="registerbtn" id="checkout-btn">Checkout</button>
      </form>
    </div>

    <div class="col-md-1">
    </div>

    <!-- Order Summary -->
    <div class="col-md-4">
      <div class="container dark text-light p-3 mb-4">
        <h4>Your Order</h4>
        <div id="cartItemsContainer" class="mb-3"></div>
        <hr>
        <p><strong>Items:</strong> <span id="itemCount">0</span></p>
        <p><strong>Total:</strong> $<span id="totalPrice">0.00</span></p>
      </div>
      <div class="container dark d-flex justify-content-center">
        <img src="images/QR.png" alt="QR for Payment" class="img-fluid" style="height: 350px; width: 350px;">
      </div>
    </div>
  </div>
</div>

<script>
// Mengisi order summary dari sesi (via get_cart.php)
window.addEventListener('DOMContentLoaded', () => {
  fetch('get_cart.php')
    .then(res => res.json())
    .then(cart => {
      let total = 0, count = 0;
      const container = document.getElementById('cartItemsContainer');
      container.innerHTML = '';

      cart.forEach(item => {
        const p = document.createElement('p');
        p.innerHTML = `${item.name} (x${item.count}) — $${(item.price * item.count).toFixed(2)}`;
        container.appendChild(p);
        total += item.price * item.count;
        count += item.count;
      });

      document.getElementById('totalPrice').textContent = total.toFixed(2);
      document.getElementById('itemCount').textContent = count;

      // Disable checkout button jika cart kosong
      const checkoutBtn = document.getElementById('checkout-btn');
      checkoutBtn.disabled = count === 0;
    });
});

// Saat formulir dikirimkan, masukkan item keranjang dari sesi ke input tersembunyi
document.getElementById('checkout-form').addEventListener('submit', function (e) {
  e.preventDefault(); // pause submit

  fetch('get_cart.php')
    .then(res => res.json())
    .then(cart => {
      cart.forEach(item => {
        const pid = document.createElement('input');
        pid.type = 'hidden';
        pid.name = 'product_id[]';
        pid.value = item.id;
        this.appendChild(pid);

        const qty = document.createElement('input');
        qty.type = 'hidden';
        qty.name = 'quantity[]';
        qty.value = item.count;
        this.appendChild(qty);

        const date = document.createElement('input');
        date.type = 'hidden';
        date.name = 'data_order[]';
        date.value = new Date().toISOString().slice(0, 10);
        this.appendChild(date);
      });

      this.submit(); // lanjut submit
    });
});
</script>
