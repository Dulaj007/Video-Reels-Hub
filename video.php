<?php
include 'db.php';

$video = null; // Initialize $video

if (isset($_GET['title'])) {
    $title = urldecode($_GET['title']);
    $stmt = $conn->prepare("SELECT * FROM videos WHERE title = ?");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();
    $video = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $video ? htmlspecialchars($video['title']) : "Video Not Found"; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <img src="assets/logo.svg" alt="Logo">
        <h1 class="site-title"><a href="index.php">SiteDomain.com</a></h1>
    </div>

    <!-- Reels Section -->
    <div >
        <?php if ($video): ?>
            <h1 class="video-title"><?php echo htmlspecialchars($video['title']); ?></h1><br>
            <div class="video-show"><?php echo $video['video_url'];  ?></div>
            <div class="Download-btn">
              <a href="<?php echo htmlspecialchars($video['download_url']); ?>" class="download-button" target="_blank">Download</a>
            </div>
        <?php else: ?>
            <h1 class="video-title">Oops! The video you're looking for is no longer available. 😢</h1>
           
            
        <?php endif; ?>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <a href="contactus.php">Contact Us</a> |
        <a href="dmca.php">DMCA</a> |
        <a href="terms.php">Terms of Service</a>
        <p>&copy; 2025 SiteDomain.com. All rights reserved.</p>
    </div>
</body>
</html>
