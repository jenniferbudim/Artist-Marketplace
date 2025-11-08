$(document).ready(function () {
    // Inisialisasi modal dengan id 'orderModal
    let orderModal = new bootstrap.Modal(document.getElementById('orderModal'));

    // mengklik tombol dengan id addOrderbtn
    $('#addOrderBtn').click(function () {
        // melakukan fungsi untuk
        // reset form
        $('#orderForm')[0].reset();
        // kosongkan form
        $('#itemsTable tbody').html('');
        // kosong order_id
        $('#order_id').val('');
        // aksi diubah menjadi add
        $('#action').val('add');
        // tunjukkan footer modal
        $('.modal-footer').show();
        // tambahkan satu baris item default
        addItemRow();
        // menampilkan modal
        orderModal.show();
    });

    // mengklik tombol dengan id editBtn
    $('.editBtn').click(function () {
        // ambil ID order dari tombol
        const orderId = $(this).data('id');
        // ambil data order dari server
        $.post('get_items.php', { order_id: orderId }, function (data) {
            if (!data.success) {
                alert(data.message || "Failed to retrieve data.");
                return;
            }

            // isi form dengan data order
            $('#order_id').val(data.order_id);
            $('#full_name').val(data.full_name);
            $('#action').val('edit');
            $('#status').val(data.status).change();
            $('#itemsTable tbody').empty();
            $('.modal-footer').show();

            // tambahkan setiap item ke dalam form
            data.items.forEach(item => {
                addItemRow(item);
            });

            // menampilkan modal
            orderModal.show();
        }, 'json');
    });

    // menambah baris item baru ketika tombol "addItemBtn" diklik
    $('#addItemBtn').click(function () {
        addItemRow();
    });

    // fungsi untuk menambahkan baris item baru ke dalam tabel
    function addItemRow(item = {}) {
        let $row = $('<tr>');
        let $productSelect = $('#product-template').clone().removeAttr('id').removeClass('d-none').addClass('form-control input-custom');;
        $productSelect.attr('name', 'product_id[]');

        // jika ada produk yang sudah dipilih sebelumnya
        if (item.product_id) {
            $productSelect.val(item.product_id);
        }

        // input harga satuan
        let $unitPrice = $('<input type="number" class="form-control input-custom" name="unit_price[]" readonly>');
        // input jumlah barang tertentu
        let $quantity = $('<input type="number" class="form-control input-custom" name="quantity[]" min="1" value="' + (item.quantity || 1) + '">');
        // input subtotal
        let $subtotal = $('<input type="number" class="form-control input-custom" name="subtotal[]" readonly>');
        // input tanggal order
        let $date = $('<input type="date" class="form-control input-custom" name="data_order[]" value="' + (item.data_order || new Date().toISOString().split("T")[0]) + '">');
        // tombol untuk menghapus barang tertentu
        let $removeBtn = $('<button type="button" class="btn accent-hover btn-sm text-white">Delete</button>');

        // isi harga & subtotal jika tersedia
        if (item.unit_price && item.quantity) {
            $unitPrice.val(item.unit_price);
            $subtotal.val(item.unit_price * item.quantity);
        }

        // ketika produk dipilih, update harga dan subtotal
        $productSelect.on('change', function () {
            let selected = $(this).find(':selected');
            let price = selected.data('price') || 0;
            $unitPrice.val(price);
            let qty = parseInt($quantity.val()) || 1;
            $subtotal.val(price * qty);
        });

        // ketika kuantitas diubah, update subtotal
        $quantity.on('input', function () {
            let qty = parseInt($(this).val()) || 1;
            let price = parseFloat($unitPrice.val()) || 0;
            $subtotal.val(price * qty);
        });

        // hapus baris ketika tombol delete diklik
        $removeBtn.on('click', function () {
            $row.remove();
        });

        // menambahkan semua elemen ke baris
        $row.append($('<td class="d-block d-sm-table-cell">').append(
            $('<div class="d-sm-none fw-bold small mb-1">Product</div>'), $productSelect
        ));
        $row.append($('<td class="d-block d-sm-table-cell">').append(
            $('<div class="d-sm-none fw-bold small mb-1">Unit Price</div>'), $unitPrice
        ));
        $row.append($('<td class="d-block d-sm-table-cell">').append(
            $('<div class="d-sm-none fw-bold small mb-1">Quantity</div>'), $quantity
        ));
        $row.append($('<td class="d-block d-sm-table-cell">').append(
            $('<div class="d-sm-none fw-bold small mb-1">Subtotal</div>'), $subtotal
        ));
        $row.append($('<td class="d-block d-sm-table-cell">').append(
            $('<div class="d-sm-none fw-bold small mb-1">Order Date</div>'), $date
        ));
        $row.append($('<td class="d-block d-sm-table-cell text-center">').append(
            $removeBtn
        ));

        // menambahkan baris ke tabel
        $('#itemsTable tbody').append($row);

        // trigger change agar harga awal langsung tampil
        $productSelect.trigger('change');
    }

    // ketika form order disubmit
    $('#orderForm').submit(function (e) {
        // mencegah reload halaman
        e.preventDefault();

        const form = $(this);
        // ambil semua data form dalam format URL-encoded
        const formData = form.serialize();

        // kirim data ke server via AJAX
        $.post('write_items.php', formData, function (response) {
            if (response.success) {
                const message = $('#action').val() === 'edit' ? 'Order edit successful.' : 'Order add successful.';

                // mengganti isi modal dengan pesan sukses
                $('.modal-body').html(`
                    <div class="text-center py-5">
                        <h4>${message}</h4>
                        <button class="btn btn-success mt-4" id="modalCloseReload">Close</button>
                    </div>
                `);

                // sembunyikan footer modal
                $('.modal-footer').hide();

                // reload halaman setelah tombol close diklik
                $(document).on('click', '#modalCloseReload', function () {
                    location.reload();
                });

            } else {
                // menampilkan pesan error jika gagal
                $('.modal-body').prepend(`
                    <div class="alert alert-danger">Failed: ${response.message || 'Unknown error'}</div>
                `);
            }
        }, 'json');
    });
});
