<?php
$title = "Thank You";
include "../includes/header.php";

$referenceNumber = $_SESSION['refNo'] ?? null;
session_unset();
session_destroy();
?>

<link rel="stylesheet" href="../css/returningCustomer.css">

</head>
<body class="background1">
<div class="container" style="border-radius: 2em">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>THANK YOU</h2>
    <h3 style="padding-top: 1em">Your booking request has been received. A confirmation email with your booking details will be sent to your inbox shortly. If you have any questions, feel free to contact us.</h3>
    <h3 style="font-weight: 500;">Reference Number: <?php echo $referenceNumber?></h3>
    <h3 style="margin: 0; padding: 0; font-size: 1.5em;"><a class="back" href="https://banahawcircle.com/">Continue to Banahaw Circle</a></h3>
</div>
<?php include "../includes/footer.php"; ?>
