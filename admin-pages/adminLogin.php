<?php
require '../config/config.php';
$title = "Admin Login";

include "../includes/header.php";
?>
    <link rel="stylesheet" href="../css/verifyReturningCustomer.css">
</head>
<body class="background1">
<div class="container">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>ADMIN LOGIN</h2>
    <h3>Please Enter Credentials</h3>
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
                <label for="mobile">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </div>

    </form>
    </form>
</div>
<div class="footer">© 2025 Banahaw Circle Nature Retreat</div>
<?php include "../includes/footer.php"; ?>