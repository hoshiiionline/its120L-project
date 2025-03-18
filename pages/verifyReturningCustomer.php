<?php
require '../config/config.php';
$title = "Returning Customer";
$errorMessage = "";

include "../includes/header.php";

if(isset($_GET['signal'])){
    $signal = $_GET['signal'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    // Uncomment these lines for debugging if needed
    echo $email;
    echo $mobile;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Using a prepared statement for better security and consistency
        $stmt = $conn->prepare("SELECT * FROM customer WHERE emailAddress = ? AND mobileNo = ?");
        $stmt->bind_param("ss", $email, $mobile);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $_SESSION['returningEmail'] = $email;
            header('Location: roomAvailability.php');
        } else {
            $errorMessage = "Customer not found";
        }
        $stmt->close();
    } else {
        $errorMessage = "Invalid email or mobile number";
    }
}
?>

<link rel="stylesheet" href="../css/verifyReturningCustomer.css">
<style>
    /* Red error div styling */
    .error-message {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 10px;
        margin: 20px auto;
        text-align: center;
        width: 80%;
        max-width: 400px;
        border-radius: 5px;
    }
</style>
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
    
    <!-- Display error message if it exists -->
    <?php if ($errorMessage != ""): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    
    <form action="verifyReturningCustomer.php" method="POST">
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
    <div style="text-align:left"><a class="back" href="returningCustomer.php">< Back</a></div>
</div>
<div class="footer">© 2025 Banahaw Circle Nature Retreat</div>
<?php include "../includes/footer.php"; ?>
