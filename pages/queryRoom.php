<?php 
require '../config/config.php';

if(isset($_GET['signal'])){
    $signal = $_GET['signal'];
    if($signal == 'guest'){
        header('Location: ../pages/packages.php');
    } else if ($signal == 'returning'){
        header('Location: ../pages/returningCustomer.php');
    } else {
        echo "Invalid signal!";
    }
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
             echo "Customer not found!";
        }
    } else {
        echo "Invalid email or mobile number!";
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
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h2>Please enter your details:</h2>
        <br>
        <form action="verifyReturningCustomer.php" method="post">
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group col-md-6">
                <label for="mobile">Mobile Number:</label>
                <input type="tel" class="form-control" id="mobile" name="mobile" required>
            </div>
            </div>
            <div class="form-group">
            <a href="returningCustomer.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </form>
    </div>
</body>
</html>
