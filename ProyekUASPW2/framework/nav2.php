<nav class="navbar navbar-expand-lg text-white p-4 medium font">
  <div class="container-fluid d-flex justify-content-between align-items-center">

    <!-- Left: Logo and Brand Name -->
    <div class="d-flex align-items-center">
      <img src="images/Logo.png" alt="Logo" class="me-2" style="width:50px">
      <span class="navbar-brand mb-0">Artist Marketplace</span>
    </div>

    <!-- Right: Contact Icon -->
    <button class="btn btn-link nav-link p-0" data-bs-toggle="modal" data-bs-target="#contactModal"
      title="Contact Developer" style="width: 50px; height: 50px;">
      <i class="fa-solid fa-envelope-open" style="font-size: 32px;"></i>
    </button>

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