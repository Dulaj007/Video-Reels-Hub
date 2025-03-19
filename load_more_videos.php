<?php
include 'db.php';

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$query = $conn->prepare("SELECT * FROM videos ORDER BY id DESC LIMIT 6 OFFSET ?");
$query->bind_param("i", $offset);
$query->execute();
$result = $query->get_result();

while ($row = $result->fetch_assoc()): ?>
    <a class="card" href="video.php?title=<?php echo urlencode($row['title']); ?>" target="_blank">
        <div class="logo">
            <img src="assets/logo.svg" alt="Logo">
        </div>
        <img src="<?php echo $row['thumbnail']; ?>" alt="Thumbnail">
    </a>
<?php endwhile; ?>
