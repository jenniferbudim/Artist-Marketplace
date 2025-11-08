<?php
// jika id news tidak ada
if (!isset($_GET['id'])) {
    echo "News ID not found.";
    exit;
}

$id = intval($_GET['id']);

// Initialize database connection
$db = new DBController();

// Use getRows with JOIN manually constructed (since getRows doesn't support JOIN directly)
$sql = "
    SELECT news.title, news.content, news.image, news.date_updated, admins.admin_name
    FROM news
    JOIN admins ON news.admin_id = admins.admin_id
    WHERE news.id_news = ?
";

$stmt = $db->conn->prepare($sql);
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Display result
if ($row) {
    echo "<div class=\"background2\">";
    echo "<div class=\"container\">"; 

    echo "<div class=\"card light text-dark\" style=\"padding: 20px; margin-bottom: 20px;\">";
    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
    echo "<h5>By " . htmlspecialchars($row['admin_name']) . "</h5>";
    echo "<h5>" . htmlspecialchars($row['date_updated']) . "</h5>";

    echo "<div class=\"fakeimg\" style=\"height:200px; overflow: hidden;\">";
    echo "<img src='../ProyekUASPW2/images/" . htmlspecialchars($row['image']) . "' alt='Gambar' style='height: 100%; object-fit: cover; width: 100%;'>";
    echo "</div>";

    echo "<p style=\"margin-top: 15px;\">" . nl2br(htmlspecialchars($row['content'])) . "</p>";
    echo "</div>";

    echo "</div>"; 
} else {
    echo "<div class=\"container p-4\">";
    echo "<div class=\"alert alert-warning\">News not found.</div>";
    echo "</div>";
}
?>

<!-- Button ke news -->
<div class="d-flex justify-content-center mt-4">
    <button type="button" class="btn btn-lg text-white btn-hover" onclick="window.location.href='../ProyekUASPW2/news'">
        Back
    </button>
</div>

<br>
</div>
