<?php
//require '../config/config.php';
$title = "Returning Customer";
include '../includes/header.php';
$signal = "";


if (isset($_GET['signal'])) {
    $signal = $_GET['signal'];
    $_SESSION['refNo'] = $signal;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    if ($_SESSION['refNo'] == 'checkOrder') {
        $referenceNumber = $_POST['refNo'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM booking WHERE referenceNo = '$referenceNumber'";
            $result = mysqli_query($conn, $query);
    
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['refNo'] = "";    
                $_SESSION['refNoCheck'] = $referenceNumber;
                header('Location: pendingBooking.php');
            } else {
                echo "Customer not found";
            }
        } else {
            echo "Invalid email or mobile number";
        }

    } else {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM customer WHERE emailAddress = '$email' AND mobileNo = '$mobile'";
            $result = mysqli_query($conn, $query);
    
            if (mysqli_num_rows($result) > 0) {
                header('Location: availabilityRoom.php');
            } else {
                echo "Customer not found";
            }
        } else {
            echo "Invalid email or mobile number";
        }
    }

}
include "../includes/header.php";
?>

<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Selection</title>
        Bootstrap CSS
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    -->
    <link rel="stylesheet" href="../css/verifyReturningCustomer.css">
</head>
<body class="background1">
<div class="container">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>RETURNING GUEST</h2>
    <h3>Please Enter Details</h3>
		<div class="tooltip">?
  		<span class="tooltiptext">Tooltip text</span>
		</div>
    <br>
    <form action="verifyReturningCustomer.php" method="post">
        <div class="form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" class="form-control" id="mobile" name="mobile" required>
            </div>
            <?php if($signal == "checkOrder") {
                echo '            <div class="form-group">
                <label for="mobile">Reference Number</label>
                <input type="text" class="form-control" id="refNo" name="refNo" required>
            </div>';
            }?>

            <button type="submit">Submit</button>
        </div>

    </form>
    </form>
    <div style="text-align:left"><a class="back" href="returningCustomer.php">< Back</a></div>
</div>
<div class="footer">© 2025 Banahaw Circle Nature Retreat</div>
<?php include "../includes/footer.php"; ?>