<?php
session_start();
include 'db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Handle Video Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_video'])) {
    $title = $_POST['title'];
    $thumbnail = $_POST['thumbnail'];
    $video_url = $_POST['video_url'];
    $download_url = $_POST['download_url'];

    $stmt = $conn->prepare("INSERT INTO videos (title, thumbnail, video_url, download_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $thumbnail, $video_url,$download_url);
    $stmt->execute();

    header("Location: post_video.php");
    exit();
}

// Handle Video Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_video'])) {
    $title = $_POST['delete_title'];

    // Check if the video exists
    $check_stmt = $conn->prepare("SELECT * FROM videos WHERE title = ?");
    $check_stmt->bind_param("s", $title);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Video exists, proceed to delete
        $delete_stmt = $conn->prepare("DELETE FROM videos WHERE title = ?");
        $delete_stmt->bind_param("s", $title);
        $delete_stmt->execute();

        echo "<script>alert('Video deleted successfully!');</script>";
    } else {
        echo "<script>alert('No video found with that title!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SiteDomain.com - Manage Videos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <img src="assets/logo.svg" alt="Logo">
        <h1 class="site-title"><a href="index.php">SiteDomain.com</a></h1>
    </div>

    <!-- Post Video Section -->
    <div class="Post-vid">
        <h1>Post a New Video</h1>
        <form action="post_video.php" method="POST">
            <input type="text" name="title" placeholder="Video Title" required><br>
            <input type="url" name="thumbnail" placeholder="Thumbnail URL" required><br>
            <input type="text" name="video_url" placeholder="Embedded Video URL (Iframe)" required><br>
            <input type="url" name="download_url" placeholder="Download Link" required><br>
            <button type="submit" name="submit_video">Submit Video</button>
        </form>
    </div>

    <!-- Delete Video Section -->
    <div class="Post-vid">
        <h1>Delete a Video</h1>
        <form action="post_video.php" method="POST">
            <input type="text" name="delete_title" placeholder="Enter Video Title to Delete" required><br>
            <button type="submit" name="delete_video" onclick="return confirm('Are you sure you want to delete this video?');">Delete Video</button>
        </form>
    </div>

    <div class="log-out">
        <a href="admin_logout.php">Logout</a>
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
