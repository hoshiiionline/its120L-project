<?php
require '../config/config.php';
$title = "Admin Login";

// Uncomment and run this once to insert an admin, then comment out again if needed.
/*
$adminEmail = 'banahawcircle';
$adminPassword = password_hash('admin', PASSWORD_DEFAULT);

$query = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $adminEmail, $adminPassword);
$stmt->execute();

$adminEmail = 'root';
$adminPassword = password_hash('root', PASSWORD_DEFAULT);

$query = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $adminEmail, $adminPassword);
$stmt->execute();

*/
include "../includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the admin exists using MySQLi placeholders
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Fetch the result as an associative array
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        // Only start session if one isn't already active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['adminID'] = $admin['adminID'];
        $_SESSION['username'] = $admin['username'];
        header("Location: pendingBooking.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/verifyReturningCustomer.css">
    </head>
    <body class="background1">
        <div class="container">
            <div><img src="../assets/logoflat.png" width="30%"></div>
            <h2>ADMIN LOGIN</h2>
            <h3>Please Enter Credentials</h3>
                <div class="tooltip">?
                    <span class="tooltiptext">Tooltip text</span>
                </div>
            <br>
            <?php 
            // Display error message if login fails
            if (isset($error)) { 
                echo "<p style='color:red;'>$error</p>"; 
            } 
            ?>
            <form action="adminLogin.php" method="POST">
                <div class="form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
        <div class="footer">Â© 2025 Banahaw Circle Nature Retreat</div>
        <?php include "../includes/footer.php"; ?>
    </body>
</html>