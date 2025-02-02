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
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Select a package:</h2>
        <div class="options">
            <div class="option-container">
                <a href="../pages/packages.php?signal=nature">
                    <img class="option" src="../assets/nature-villa-stay-package.png" alt="Nature Villa Stay Package">
                    <div class="label">Nature Villa Stay Package</div>
                </a>
            </div>
            <div class="option-container">
                <a href="../pages/packages.php?signal=art">
                    <img class="option" src="../assets/art-house-stay-package.png" alt="Art House Stay Package">
                    <div class="label">Art House Stay Package</div>
                </a>
            </div>
            <div class="option-container">
                <a href="../pages/packages.php?signal=tour">
                    <img class="option" src="../assets/tour-package.png" alt="Tour Package">
                    <div class="label">Tour Package</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>