<?php $mod = $mod ?? ''; ?>

<nav class="navbar navbar-expand-lg text-white p-4 medium font">
  <div
    class="container-fluid d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">

    <!-- Logo dan Brand Name -->
    <div class="navbar-brand d-flex align-items-center mb-3 mb-lg-0">
      <a href="../ProyekUASPW2/profile">
        <img src="images/Logo.png" alt="Logo" class="me-2" style="width:50px">
      </a> 
      <a href="../ProyekUASPW2/home" class="text-white text-decoration-none">
        <span>Artist Marketplace</span>
      </a>
    </div>

    <!-- Navbar Links (untuk Desktop) -->
    <div class="collapse navbar-collapse d-none d-lg-flex justify-content-center" style="font-family: Poppins;"
      id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0 gap-3">
        <li class="nav-item">
          <a class="nav-link <?php echo $mod === 'h' ? 'active-nav' : ''; ?>" href="../ProyekUASPW2/home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $mod === 'ab' ? 'active-nav' : ''; ?>" href="../ProyekUASPW2/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $mod === 'sp' ? 'active-nav' : ''; ?>"
            href="../ProyekUASPW2/spotlight">Spotlight</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $mod === 'sh' ? 'active-nav' : ''; ?>" href="../ProyekUASPW2/shop">Shop</a>
        </li>
      </ul>
    </div>

    <!-- Contact and Cart (untuk Desktop) -->
    <div class="d-none d-lg-flex align-items-center gap-3">
      <button class="btn btn-link nav-link p-2" data-bs-toggle="modal" data-bs-target="#contactModal"
        title="Contact Developer" style="width: 50px; height: 50px;">
        <i class="fa-solid fa-envelope-open" style="font-size: 32px;"></i>
      </button>
      <a class="nav-link" href="../ProyekUASPW2/order">
        <img src="images/Basket.png" width="50" height="50" onmouseover="this.src='images/BasketHover.png';"
          onmouseout="this.src='images/Basket.png';" alt="Cart">
      </a>
    </div>

    <!-- Contact + Dropdown + Cart (untuk Mobile)-->
    <div class="d-lg-none d-flex align-items-center justify-content-between w-100 mt-3">
      <!-- Contact Icon -->
      <button class="btn btn-link nav-link p-0" data-bs-toggle="modal" data-bs-target="#contactModal"
        title="Contact Developer">
        <i class="fa-solid fa-envelope-open fa-lg"></i>
      </button>

      <!-- Hamburger Dropdown -->
      <div class="nav-item dropdown">
        <a class="nav-link p-0" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-bars fa-lg"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="../ProyekUASPW2/home">Home</a></li>
          <li><a class="dropdown-item" href="../ProyekUASPW2/about">About</a></li>
          <li><a class="dropdown-item" href="../ProyekUASPW2/spotlight">Spotlight</a></li>
          <li><a class="dropdown-item" href="../ProyekUASPW2/shop">Shop</a></li>
        </ul>
      </div>

      <!-- Cart Icon -->
      <a class="nav-link p-0" href="../ProyekUASPW2/order" title="Cart">
        <img src="images/Basket.png" width="30" height="30" onmouseover="this.src='images/BasketHover.png';"
          onmouseout="this.src='images/Basket.png';" alt="Cart">
      </a>
    </div>
  </div>
</nav>

<!-- Modal Contact Us-->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-light">
      <!-- Modal Header -->
      <div class="modal-header dark">
        <h5 class="modal-title text-white" id="contactModalLabel">Contact Us</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal Body -->
      <form id="formContact">
        <div class="modal-body">
          <!-- Field Email-->
          <div class="mb-3" id="emailGroup">
            <label for="userEmail" class="form-label">Your Email</label>
            <input type="email" class="form-control input-custom" name="email" id="userEmail" required>
          </div>
          <!-- Field Message -->
          <div class="mb-3" id="messageGroup">
            <label for="userMessage" class="form-label">Message</label>
            <textarea class="form-control input-custom" name="message" id="userMessage" rows="4" required></textarea>
          </div>
          <!--Pesan Sukses atau Error-->
          <div id="formContact-dynamic-content" class="text-center mt-2"></div>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
          <!-- Button Send -->
          <button type="submit" id="btnSend" class="btn medium button-text-color">Send</button>
          <!-- Button Cancel -->
          <button type="button" id="btnCancel" class="btn accent button-text-color"
            data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
      <div class="modal-footer d-none" id="formCloseFooter">
        <button type="button" class="btn accent button-text-color" id="btnCloseFinal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Ketika form dengan ID #formContact disubmit
  $("#formContact").submit(function (event) {
    // Mencegah reload halaman
    event.preventDefault();
    // Disable tombol send agar tidak diklik dua kali
    $('#btnSend').prop('disabled', true);
    // Sembunyikan footer modal, tetapi tidak sembunyikan formCloseFooter
    $('#formContact .modal-footer').not('#formCloseFooter').hide();
    // Ambil semua data input dari form sebagai query string
    const formData = $(this).serialize();

    // Kirim data form ke contact_us.php menggunakan metode POST
    $.ajax({
      type: 'POST',
      url: 'contact_us.php',
      data: formData,
      dataType: 'json'
    }).done(function (data) {
      // Sembunyikan input grup email dan pesan 
      $('#emailGroup, #messageGroup').hide();
      // Pesan sukses dan error
      if (data.success) {
        $('#formContact-dynamic-content').html('<h6 class="text-dark">' + data.msg + '</h6>');
      } else {
        $('#formContact-dynamic-content').html('<h6 class="text-danger">' + data.msg + '</h6>');
      }
      // Tampilkan footer untuk tombol "Close"
      $('#formCloseFooter').removeClass('d-none');

      // Ketika tombol close akhir diklik
      $('#btnCloseFinal').click(function () {
        // tutup modal
        $('#contactModal').modal('hide');
        // reload halaman
        location.reload();
      });
    });
  });

  // Ketika modal dengan ID #contactModal ditutup
  $('#contactModal').on('hidden.bs.modal', function () {
    // reset field form
    $('#formContact')[0].reset();
    // menampilkan kembali yang disembuyikan
    $('#emailGroup, #messageGroup').show();
    // mengosongkan pesan sukses atau error
    $('#formContact-dynamic-content').html('');
    // sembunyikan tombol close akhir 
    $('#formCloseFooter').addClass('d-none');
    // menampilkan footer awal
    $('.modal-footer').show();
    // mengaktifkan button send
    $('#btnSend').prop('disabled', false);
  });
</script>