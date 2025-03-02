<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HotelBookingDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
//maxine: removed null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>