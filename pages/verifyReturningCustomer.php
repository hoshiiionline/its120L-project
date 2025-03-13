<?php
require '../config/config.php';
$title = "Returning Customer";

if(isset($_GET['signal'])){
    $signal = $_GET['signal'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[0-9]{10}$/', $mobile)) {
        $query = "SELECT * FROM customers WHERE email = '$email' AND mobile = '$mobile'";
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
include "../includes/header.php";
?>

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
            <button type="submit">Submit</button>
        </div>

    </form>
    </form>
    <div style="text-align:left"><a class="back" href="returningCustomer.php">< Back</a></div>
</div>
<div class="footer">© 2025 Banahaw Circle Nature Retreat</div>
<?php include "../includes/footer.php"; ?>