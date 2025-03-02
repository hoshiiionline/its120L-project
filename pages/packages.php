<?php
if(isset($_GET['signal'])){
    $signal = $_GET['signal'];

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Selection</title>
    <link rel="stylesheet" href="../css/packages.css">
</head>
<body class="background1">
<div class="container">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>SELECT A PACKAGE</h2>
    <div class="options">
        <a href="../pages/packages.php?signal=nature">
            <div class="option-container" style="background-image: url(../assets/naturevilla.png);">
                <div class="label">Nature Villa<br>Stay Packages</div>
            </div>
        </a>
        <a href="../pages/packages.php?signal=art">
            <div class="option-container" style="background-image: url(../assets/arthouse.png);">
                <div class="label">Art House<br>Stay Packages</div>
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
<div class="footer">© 2025 Banahaw Circle Nature Retreat</div>
</body>
</html>