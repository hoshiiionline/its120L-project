<?php
$title = "Thank You";
include "../includes/header.php";

$referenceNumber = $_SESSION['refNo'] ?? null;
$_SESSION = array();  
session_unset();      
session_destroy();    
?>

<link rel="stylesheet" href="../css/returningCustomer.css">
<style>
    .options {
        display: flex;
        flex-direction: row;
        width: 100%;
        background: white;
        text-align: center;
        justify-content: center;
        gap: 1em;
        margin-bottom: 1em;
    }

    .options a, label{
        width: auto;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin: 0.5em;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, text-decoration 0.3s ease-in-out, color 0.3s ease;
        color: white;
    }

    .options a:hover {
        transform: scale(1.15);
    }

    .options a:hover + label {
        color: #425d8a;
    }
</style>
</head>
<body class="background1">
<div class="container" style="border-radius: 2em">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>THANK YOU</h2>
    <h3 style="padding-top: 1em; margin-bottom: 1em">Your booking request has been received. A confirmation email with your booking details will be sent to your inbox shortly. <br/> <br /> If you have any questions, feel free to contact us.</h3>

    <div class="options">
        <div>
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=banahawcircle@gmail.com&su=REFERENCE%20NUMBER:<?php echo urlencode($referenceNumber); ?>&body=Name:%0AEmail%20Address:%0APhone%20Number:%0AReference%20Number:<?php echo urlencode($referenceNumber); ?>">
                <img src="../assets/mail.png" alt="Mail Icon" style="width: 8em; height: 8em;">
            </a>
            <label>Send Us an Email</label>
        </div>
        <div>
            <a href="https://wa.me/639623588767?text=Name:%0AEmail%20Address:%0APhone%20Number:%0AReference%20Number:<?php echo urlencode($referenceNumber); ?>">
                <img src="../assets/whatsapp.png" alt="WhatsApp Icon" style="width: 8em; height: 8em;">
            </a>
            <label>Chat on WhatsApp</label>
        </div>
        <div>
            <a href="https://m.me/banahawcirclenatureretreat?ref=Name%3A%0AEmail%20Address%3A%0APhone%20Number%3A%0AReference%20Number%3A">
                <img src="../assets/facebook.png" alt="WhatsApp Icon" style="width: 8em; height: 8em;">
            </a>
            <label>Chat on Facebook</label>
        </div>
    </div>


    <h3 style="font-weight: 500; padding-top: 1em;">Reference Number: <?php echo $referenceNumber?></h3>
    <br> 
    <h3 style="margin: 0; padding: 0; font-size: 1.5em;"><a class="back" href="https://banahawcircle.com/">Continue to Banahaw Circle</a></h3>
</div>
<?php include "../includes/footer.php"; ?>
