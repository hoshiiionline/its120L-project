<?php
session_start();
$title = "Package Selection";
if(isset($_GET['signal'])){
   	$signal = $_GET['signal'];
		 $_SESSION['package'] = $signal;
		 echo $_SESSION['package'];
		 header('Location: ../pages/roomAvailability.php');
		 } else {
				 $_SESSION['package'] = 'invalid';
		 }
//include "../includes/header.php";
?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->	
    <title>Package Selection</title>
    <link rel="stylesheet" href="../css/packages.css">
</head>
<body class="background1">
<div class="container">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>SELECT A PACKAGE</h2>
    <div class="options">
        <a href="../pages/packages.php?signal=package">
            <div class="option-container" style="background-image: url(../assets/naturevilla.png);">
                <div class="label">Room Packages</div>
            </div>
        </a>
        <a href="../pages/packages.php?signal=room">
            <div class="option-container" style="background-image: url(../assets/arthouse.png);">
                <div class="label">Room Only</div>
            </div>
        </a>
        <a href="../pages/packages.php?signal=tour">
            <div class="option-container" style="background-image: url(../assets/tours.png);">
                <div class="label">Tour Packages</div>
            </div>
        </a>
    </div>
    <div style="text-align:left"><a class="back" href="../pages/returningCustomer.php">< Back</a></div>
</div>
<?php include "../includes/footer.php"; ?>