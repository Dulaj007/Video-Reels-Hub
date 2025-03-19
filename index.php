<!DOCTYPE html>
<html>
<head>
    <title>SiteDomain.com</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <img src="assets/logo.svg" alt="Logo">
        <h1 class="site-title"><a href="index.php">SiteDomain.com</a></h1>
    </div>

    <!-- Reels Section -->
    <div class="reels-title">
        <img src="assets/videosicon.svg" alt="Videos Icon">
        <span>Reels</span>
    </div>

    <!-- Video Grid -->
    <div class="grid" id="video-container">
        <?php
        include 'db.php';
        $videos = $conn->query("SELECT * FROM videos ORDER BY id DESC LIMIT 10");
        while ($row = $videos->fetch_assoc()): ?>
            <a class="card" href="video.php?title=<?php echo urlencode($row['title']); ?>" target="_blank">
                <div class="logo">
                    <img src="assets/logo.svg" alt="Logo">
                </div>
                <img src="<?php echo $row['thumbnail']; ?>" alt="Thumbnail">
            </a>
        <?php endwhile; ?>
    </div>

    <!-- Load More Button -->
  
    <div class="Download-btn">
   
        <button id="load-more-btn" class="see-button">See More</button>
    </div>    

    <!-- Footer Section -->
    <div class="footer">
        <a href="contactus.php">Contact Us</a> |
        <a href="dmca.php">DMCA</a> |
        <a href="terms.php">Terms of Service</a>
        <p>&copy; 2025 SiteDomain.com. All rights reserved.</p>
    </div>

    <!-- AJAX Script for Loading More Videos -->
    <script>
        $(document).ready(function() {
            var offset = 10; // Start loading from the 11th video
            $("#load-more-btn").click(function() {
                $.ajax({
                    url: "load_more_videos.php",
                    type: "GET",
                    data: { offset: offset },
                    success: function(response) {
                        if (response.trim() !== "") {
                            $("#video-container").append(response);
                            offset += 6; // Increase the offset by 6
                        } else {
                            $("#load-more-btn").hide(); // Hide button if no more videos
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>
