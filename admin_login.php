<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to check if the username exists
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If admin exists, check password
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            // Password is correct, set session
            $_SESSION['admin_logged_in'] = true;
            header("Location: post_video.php");
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SiteDomain.com</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <img src="assets/logo.svg" alt="Logo">
        <h1 class="site-title"><a href="index.php">SiteDomain.com</a></h1>
    </div>

    <!-- Reels Section -->
    <div class="reels-title">
   
        <span>Admin Login</span>
    </div>
    <div class="Post-vid">
    <form method="POST" action="admin_login.php">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">SiteDomain.com</button>
    </form>
    </div>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
</body>
</html>
