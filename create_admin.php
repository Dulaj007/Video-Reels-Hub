<?php
include 'db.php';

// Hash the admin password for security
$hashed_password = password_hash('adminREEL09%', PASSWORD_DEFAULT);

// Insert the admin user into the database
$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

$username = 'admin'; // Assign the username
$stmt->execute();

echo "Admin user created!";
?>
