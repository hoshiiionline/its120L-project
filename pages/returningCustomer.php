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
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome! Please select an option:</h2>
        <div class="options">
            <div class="option-container">
                <a href="../pages/returningCustomer.php?signal=returning">
                    <img class="option" src="../assets/returning-customer.png" alt="I'm a Returning Customer">
                    <div class="label">I'm a Returning Customer!</div>
                </a>
            </div>
            <h3>or</h3>
            <div class="option-container">
                <a href="../pages/returningCustomer.php?signal=guest">
                    <img class="option" src="../assets/guest.png" alt="I'm a Guest">
                    <div class="label">I'm a Guest!</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
