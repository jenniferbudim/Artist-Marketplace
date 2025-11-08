<?php
// Fungsi untuk mengubah teks menjadi slug (URL friendly)
function slugify($text)
{
    // Ganti semua karakter non-huruf dan non-angka dengan tanda hubung (-)
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // Ubah karakter spesial (misalnya é, ü) menjadi karakter ASCII yang setara (e, u)
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // Hapus semua karakter yang bukan huruf, angka, atau tanda hubung
    $text = preg_replace('~[^-\w]+~', '', $text);

    // Hapus tanda hubung di awal dan akhir string
    $text = trim($text, '-');

    // Ganti beberapa tanda hubung berurutan dengan satu tanda hubung
    $text = preg_replace('~-+~', '-', $text);

    // Ubah semua huruf menjadi huruf kecil
    return strtolower($text);
}
?>

<!-- Judul -->
<div class="dark">
    <div class="container p-5">
        <h1 class="text-white text-center" style="font-size: 60px;">Creative News!</h1>
    </div>
</div>

<div class="container mb-5">
    <?php
    // Ambil berita berdasarkan yang terbaru
    $news = $db->getRows("news", [
        "select" => "id_news, title, image",
        "order_by" => "id_news DESC"
    ]);

    if ($news):
        // Dapatkan berita terbaru
        $featured = array_shift($news); ?>

        <!-- Featured News Card -->
        <div class="row justify-content-center mt-5">
            <div class="col-xl-10">
                <div class="card dark text-light p-4 featured-card">
                    <div class="row g-0 align-items-stretch">
                        <!-- Kolom Image -->
                        <div class="col-md-6">
                            <div class="h-100" style="overflow: hidden;">
                                <img src="../ProyekUASPW2/images/<?= htmlspecialchars($featured['image']) ?>" alt="Gambar"
                                    style="width:100%; height:100%; max-height:400px; object-fit:cover; display:block;">
                            </div>
                        </div>
                        <!-- Kolom Title -->
                        <div class="col-md-6">
                            <div class="card-body light text-center h-100 d-flex justify-content-center align-items-center">
                                <h2 class="card-title mb-0">
                                    <a href="news/<?= $featured['id_news'] ?>/<?= slugify($featured['title']) ?>">
                                        <?= htmlspecialchars($featured['title']) ?>
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Card Biasa -->
        <?php
        $counter = 0;
        foreach ($news as $row):
            if ($counter % 3 === 0): ?>
                <div class="row align-items-center mt-4">
                <?php endif; ?>

                <div class="col-xl-4 d-flex justify-content-center mt-4">
                    <div class="card dark text-light p-3" style="width: 30rem;">
                        <div style="width: 100%; height: 200px; overflow: hidden;">
                            <img src="../ProyekUASPW2/images/<?= htmlspecialchars($row['image']) ?>" alt="Gambar"
                                style="width:100%; height:100%; object-fit:cover; display:block;">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <a href="news/<?= $row['id_news'] ?>/<?= slugify($row['title']) ?>">
                                    <?= htmlspecialchars($row['title']) ?>
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>

                <?php
                $counter++;
                if ($counter % 3 === 0): ?>
                </div>
            <?php endif;
        endforeach;

        if ($counter % 3 !== 0): ?>
        </div>
    <?php endif;
    else:
        echo "<p class='text-center text-white mt-5'>There is no news.</p>";
    endif;
    ?>
</div>

<style>
    .text-white-hover {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .text-white-hover:hover {
        color: rgb(4, 45, 45);
    }

    .card-body {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-title a {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        color: white;
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .card-title a:hover {
        color: rgb(4, 45, 45);
    }

    .featured-card .card-body {
        height: auto;
        padding-top: 20px;
    }

    .featured-card .card-title a {
        font-size: 2rem;
        -webkit-line-clamp: 3;
    }
</style>