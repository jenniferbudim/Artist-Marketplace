<?php
$adminUsername = $_SESSION['admin_name'];

// Table join agar bisa display admin_name di setiap item news 
$tableWithJoin = "
    news n
    JOIN admins a ON n.admin_id = a.admin_id
";

// Field yang digunakan
$selectFields = "
    n.id_news,
    n.title,
    n.image,
    n.content,
    a.admin_name,
    n.date_updated
";

// Fetch semua row news  
$newsList = $db->getRows(
    $tableWithJoin,
    [
        "select" => $selectFields,
    ]
);
?>

<div class="background1 py-4">
    <div class="container">
        <h2 class="mb-4">News List</h2>

        <!-- Button Add News -->
        <div class="mb-3">
            <a href="/ProyekUASPW2/administrator/add-news" class="btn dark text-white btn-hover">
                Add News
            </a>
        </div>

        <!-- Tabel news-->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 15%;">Image</th>
                        <th style="width: 40%;">Content</th>
                        <th style="width: 10%;">Admin</th>
                        <th style="width: 10%;">Updated</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    <?php if (!empty($newsList)): ?>
                        <?php foreach ($newsList as $news): ?>
                            <tr>
                                <td><?= htmlspecialchars($news['id_news']) ?></td>
                                <td><?= htmlspecialchars($news['title']) ?></td>
                                <td>
                                    <?php if (!empty($news['image'])): ?>
                                        <img src="../images/<?= htmlspecialchars($news['image']) ?>" alt="News Image"
                                            class="news-image" />
                                    <?php else: ?>
                                        No image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="content-preview">
                                        <?php
                                        // Generate a 200-character snippet
                                        $snippet = substr($news['content'], 0, 200);
                                        if (strlen($news['content']) > 200) {
                                            $snippet .= '...';
                                        }
                                        ?>
                                        <div class="short-content">
                                            <?= nl2br(htmlspecialchars($snippet)) ?>
                                        </div>
                                        <div class="full-content">
                                            <?= nl2br(htmlspecialchars($news['content'])) ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($news['admin_name']) ?></td>
                                <td><?= htmlspecialchars($news['date_updated']) ?></td>
                                <!-- Button Edit -->
                                <td>
                                    <a href="/ProyekUASPW2/administrator/adjust-news/<?= urlencode($news['id_news']) ?>"
                                        class="btn accent-hover text-white btn-sm" title="Edit this news entry">
                                        Edit
                                        </>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                No news entries found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Button Kembali ke Dashboard -->
<div class="container mb-4 d-flex justify-content-center">
    <button type="button" class="btn btn-lg text-white btn-hover"
        onclick="window.location.href='../administrator/home'">
        Back to Dashboard
    </button>
</div>

<script>
    document.querySelectorAll('.content-preview').forEach((preview) => {
        preview.addEventListener('click', () => {
            preview.classList.toggle('expanded');
        });

        // Tingkatkan dukungan tap mobile
        let lastTap = 0;
        preview.addEventListener('touchend', (e) => {
            const now = new Date().getTime();
            if (now - lastTap <= 300) {
                preview.classList.toggle('expanded');
                e.preventDefault();
            }
            lastTap = now;
        });
    });
</script>

<style>
    .news-image {
        max-width: 100px;
        height: auto;
    }

    .content-preview {
        overflow: hidden;
        cursor: pointer;
        transition: max-height 0.4s ease;
        max-height: 100px;
        position: relative;
    }

    .content-preview.expanded {
        max-height: 1000px;
    }

    .short-content,
    .full-content {
        transition: opacity 0.3s ease;
    }

    .content-preview.expanded .short-content {
        display: none;
    }

    .content-preview:not(.expanded) .full-content {
        display: none;
    }

    .content-preview:hover {
        background-color: #f9f9f9;
    }

    @media (hover: none) {
        .content-preview:hover {
            background-color: transparent;
        }
    }
</style>