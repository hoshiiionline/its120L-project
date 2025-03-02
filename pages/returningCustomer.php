<?php
require '../config/config.php';

if(isset($_GET['signal'])){
    $signal = $_GET['signal'];
    if($signal == 'guest'){
        header('Location: ../pages/packages.php');
    } else if ($signal == 'returning'){
        header('Location: ../pages/verifyReturningCustomer.php');
    } else {
        echo "Invalid signal!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Selection</title>
    <link rel="stylesheet" href="../css/returningCustomer.css">

</head>
<body class="background1">
<div class="container">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>BOOK A ROOM</h2>
    <h3>Reconnect with nature and spirit—book your stay with us for a rejuvenating retreat of healing, reflection, and inspiration.</h3>
    <div class="options">
        <div class="option-container">
            <a href="../pages/returningCustomer.php?signal=returning">
                <div class="label">Returning Guest</div>
            </a>
        </div>
        <div class="option-container">
            <a href="../pages/returningCustomer.php?signal=guest">
                <div class="label">New Guest</div>
            </a>
        </div>
    </div>
    <div style="text-align:left"><a class="back" href="https://banahawcircle.com/">< Back</a></div>
</div>
<div class="footer">© 2025 Banahaw Circle Nature Retreat</div>
</body>
</html>
