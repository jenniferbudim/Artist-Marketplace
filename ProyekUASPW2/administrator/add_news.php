<?php
// Mengecek apakah sudah login sebagai basis nama pembuat news tersebut
$adminUsername = $_SESSION['admin_name'] ?? '';

// Jika belum login, redirect ke halaman login admin
if (empty($adminUsername)) {
    header("Location: adminLogin.php");
    exit;
}

// Ambil data admin dari database berdasarkan nama admin
$adminRow = $db->getRows(
    "admins",
    [
        "select" => "admin_id",
        "where" => ["admin_name" => $adminUsername]
    ]
);
if (!$adminRow) {
    die("Error: could not find an admin record for '{$adminUsername}'.");
}
// Simpan admin_id untuk digunakan saat insert
$adminId = $adminRow[0]['admin_id'];

// Memperisiapkan mode edit
$isEdit = false;
$idToEdit = null;
$existingTitle = "";
$existingImage = "";
$existingContent = "";

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $isEdit = true;
    $idToEdit = intval($_GET['id']);

    // mengambil data untuk edit news
    $row = $db->getRows(
        "news",
        [
            "select" => "id_news, title, image, content",
            "where" => ["id_news" => $idToEdit]
        ]
    );
    if ($row) {
        $existingTitle = $row[0]['title'];
        $existingImage = $row[0]['image'];
        $existingContent = $row[0]['content'];
    } else {
        die("Error: no news entry found with ID = {$idToEdit}.");
    }
}

// Menangani permintaan POST untuk insert/update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("News form submitted: " . print_r($_POST, true));

    $title = trim($_POST['title'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $hiddenId = isset($_POST['id_news']) ? intval($_POST['id_news']) : null;

    // Validasi input
    if ($title === '' || $content === '') {
        $error = "Title and Content are required.";
    } else {
        if ($hiddenId) {
            // Update mode
            $updateData = [
                "title" => $title,
                "image" => $image,
                "content" => $content
            ];
            $ok = $db->update("news", $updateData, ["id_news" => $hiddenId]);

            if ($ok) {
                header("Location: ../administrator/see-news");
                exit;
            } else {
                $error = "Failed to update news ID {$hiddenId}.";
                error_log("Update failed for ID {$hiddenId}: " . print_r($updateData, true));
            }
        } else {
            // Insert mode
            $insertData = [
                "title" => $title,
                "image" => $image,
                "content" => $content,
                "admin_id" => $adminId
            ];
            $ok = $db->insert("news", $insertData);

            if ($ok) {
                header("Location: ../administrator/see-news");
                exit;
            } else {
                $error = "Failed to insert new news.";
                error_log("Insert failed: " . print_r($insertData, true));
            }
        }
    }
}
?>
 
<div class="container form-container">
    <h3 class="mb-4"><?= $isEdit ? "Edit News Entry" : "Add News Entry" ?></h3>

    <!-- Menampilkan pesan error jika ada -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <!-- Form tambah/edit berita -->
    <form method="POST" action="index.php?page=an<?= $isEdit ? '&id=' . $idToEdit : '' ?>">
        <?php if ($isEdit): ?>
            <!-- Hidden input untuk ID jika mode edit -->
            <input type="hidden" name="id_news" value="<?= htmlspecialchars($idToEdit) ?>" />
        <?php endif; ?>
        
        <!-- Input Judul -->
        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" id="title" name="title" class="form-control"
                value="<?= htmlspecialchars($existingTitle) ?>" required />
        </div>
        
        <!-- Input Nama Gambar -->
        <div class="mb-3">
            <label for="image" class="form-label">
                Image Filename <small class="text-muted">(e.g. news_img.jpg)</small>
            </label>
            <input type="text" id="image" name="image" class="form-control"
                value="<?= htmlspecialchars($existingImage) ?>" placeholder="news_image.jpg" />
        </div>

        <!-- Input Konten -->
        <div class="mb-3">
            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
            <textarea id="content" name="content" class="form-control" rows="5" required
                oninput="autoExpand(this)"><?= htmlspecialchars($existingContent) ?></textarea>
        </div>
        
        <!-- Tombol Submit dan Cancel -->
        <button type="submit" class="btn btn-hover">
            <?= $isEdit ? "Update News" : "Save News" ?>
        </button>
        <a href="../administrator/see-news" class="btn accent-hover ms-2">Cancel</a>
    </form>
</div>

<script>
    function autoExpand(field) {
        // Reset tinggi
        field.style.height = "auto";
        // Sesuaikan tinggi otomatis
        field.style.height = (field.scrollHeight) + "px";
    }

    // Saat dokumen selesai dimuat, expand otomatis textarea
    document.addEventListener("DOMContentLoaded", function () {
        const ta = document.getElementById("content");
        if (ta) {
            ta.style.height = "auto";
            ta.style.height = (ta.scrollHeight) + "px";
        }
    });
</script>

<style>
    .form-container {
        max-width: 700px;
        margin: 2rem auto;
        padding: 1.5rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
    }

    textarea {
        resize: vertical;
    }
</style>