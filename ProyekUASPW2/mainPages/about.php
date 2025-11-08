<?php
// Ambil data artist
$artists = $db->getRows("artists", [
    "select" => "artist_id, display_name, bio, display_image"
]);

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

<?php if ($artists): ?>
<div class="container mt-0">
    <!-- About Us Section -->
    <div class="row">
        <div class="col-md-3 align-self-end text-dark font">
            <div class="light p-4 ml-2 mr-2">
                <h1 class="mb-3 mt-3">About Us</h1>
                <p style="font-size: 20px; font-family: Poppins;">
                    Artist Marketplace started from a passion project of our founder, <strong>Jennifer Budi Muljono</strong>,
                    who found beauty in the fleeting and vivid imagination of humans. We aim to nurture a platform that helps
                    artist explore their minds by <strong>supporting their businesses</strong>.
                </p>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-8 mt-5">
            <img src="images/Pokemon.png" width="850px" height="541px" alt="Group Picture of Eeveelutions">
        </div>
    </div>
</div>

<!-- Artist Cards -->
<div style="background-color: rgb(110, 160, 133);">
    <div class="container">
        <div class="row align-items-center mt-5">
            <?php foreach ($artists as $artist): ?>
                <div class="col-xl-4 d-flex justify-content-center mt-4">
                    <div class="card dark text-light p-3" style="width: 20rem;">
                        <div class="card-body text-center">
                            <form action="index.php" method="get">
                                <input type="hidden" name="page" value="ad">
                                <input type="hidden" name="artist_id" value="<?= htmlspecialchars($artist['artist_id']) ?>">
                                <a href="/ProyekUASPW2/artist/<?= $artist['artist_id'] ?>/<?= slugify($artist['display_name']) ?>"
                                   class="btn btn-lg text-white btn-hover">
                                   <?= htmlspecialchars($artist['display_name']) ?>
                                </a>
                            </form>
                        </div>
                        <div class="image-container">
                            <img src="../ProyekUASPW2/images/<?= htmlspecialchars($artist['display_image']) ?>"
                                 class="card-img-top" style="height: 300px; width: 300px; object-fit: cover;"
                                 alt="<?= htmlspecialchars($artist['display_name']) ?>">
                            <div class="item__overlay">
                                <div class="container item__body text-dark text-center">
                                    <h3><?= htmlspecialchars($artist['bio']) ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php else: ?>
    <p class="text-center text-white mt-5">No artists found.</p>
<?php endif; ?>

<!-- FAQs Section -->
<div class="background3" style="font-family: Poppins;">
    <div class="container">
        <div class="row">
            <div class="col-md-3 align-self-center mt-5" style="max-width:350px;">
                <div class="card medium mb-3">
                    <h1 class="text-dark p-3">FAQs</h1>
                </div>
                <div class="card medium">
                    <div class="container p-3 d-flex flex-column gap-3 font" style="font-size: 18px;">
                        <div class="card light text-dark p-3 align-self-start font" style="max-width:200px;">
                            <p>How much of the proceeds go to their respective artists?</p>
                        </div>
                        <div class="card light text-dark p-3 align-self-end" style="max-width:220px;">
                            <p>Artist Marketplace doesn’t take any cuts from the sold items our artists make. Every
                                seller pay a set amount of money each month as a fee to keep this platform running.
                                That’s why your support matters!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-3 align-self-end mt-5" style="max-width:350px;">
                <div class="card medium">
                    <div class="container p-3 d-flex flex-column gap-3" style="font-size: 18px;">
                        <div class="card dark text-light p-3 align-self-end" style="max-width:200px;">
                            <p>I’d like to work with a seller, how can I do that?</p>
                        </div>

                        <div class="card dark text-light p-3 align-self-start" style="max-width:190px;">
                            <p>Artist Marketplace doesn’t force our seller to have an exclusivity clause, so if you want
                                to work with them, you can contact them through their respective contacts listed on
                                their pages.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-3 align-self-start mt-5" style="max-width:350px;">
                <div class="row">
                    <div class="card medium">
                        <div class="container p-3  d-flex flex-column gap-3" style="font-size: 18px;">
                            <div class="card light text-dark p-3 align-self-start" style="max-width:200px;">
                                <p>Can I apply to be a seller or sponsor?</p>
                            </div>

                            <div class="card light text-dark p-3 align-self-end" style="max-width:220px;">
                                <p>Artist Marketplace open our application form all year around so you can apply to be
                                    part of our team of artists. As for applying as sponsor, you can email us at 
                                    artistmarketplace@gmail.com!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row p-2"></div>

                <img src="images/Plant.png" class="img-fluid" alt="Answer Lotus">
            </div>
        </div>
    </div>
</div>