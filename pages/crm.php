<?php
$title = "CRM";
$cart = $_SESSION['cart'] ?? [];
include "../includes/header.php";

date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Use the same key ("phone") consistently
  $firstName       = $_POST['firstName'] ?? '';
  $lastName        = $_POST['lastName'] ?? '';
  $email           = $_POST['email'] ?? '';
  $phone           = $_POST['phone'] ?? '';
  $specialRequests = $_POST['specialRequests'] ?? '';

  if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone)) {
    // making new customer record
    $stmt = $conn->prepare("INSERT INTO customer (firstName, lastName, emailAddress, mobileNo) VALUES (?, ?, ?, ?)");
    // Bind parameters: "ssssss" means 6 string parameters.
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $phone);

    // Execute the statement
    if ($stmt->execute()) {
      echo "<div class='alert alert-success'>Booking successfully submitted!</div>";
    } else {
      echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
  } else {
    echo "<div class='alert alert-danger'>Please fill in all required fields.</div>";
  }

  // insert booking record
  $stmt = $conn->prepare("SELECT customerID FROM customer WHERE emailAddress = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $customerID = $result->fetch_assoc()['customerID'];
  $stmt->close();

  foreach ($cart as $item) {
    $pricingID = $item['pricingID'];
    $stmt = $conn->prepare("INSERT INTO booking (customerID, pricingID, bookingDate, paymentMethod) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $customerID, $pricingID, $today, $specialRequests);
    $stmt->execute();
    $stmt->close();
  }
}
?>

<link rel="stylesheet" href="../css/crm.css">
<body class="background1">
<div class="wrap">
  <div class="row1">
    <!-- CRM Form -->
      <div class="container">
          <h2>Hotel Booking Form</h2>
          <form action="crm.php" method="POST">
          <div class="form">
              <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" id="firstName" name="firstName" placeholder="Tomas" required>
              </div>
              <div class="form-group">
                  <label for="lastName">Last Name</label>
                  <input type="text" id="lastName" name="lastName" placeholder="Mapua" required>
              </div>
          </div>

          <div class="form2">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" placeholder="tomasmapua@mail.com" required>
          </div>

          <div class="form2">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" placeholder="1234567890" required>
          </div>

          <div class="form2">
              <label for="specialRequests">Special Requests</label>
              <textarea id="specialRequests" name="specialRequests" rows="3" placeholder="Any additional details..."></textarea>
          </div>
          <div class="form2">
              <button id="query-btn" class="submit">Submit</button>
          </div>
          <div style="text-align:left"><a class="back" href="../pages/availableRooms.php">< Back</a></div>
          </form>
      </div>
    <!-- Cart Display -->
    <div class="col-lg-6 container right-container">
      <h2>Your Cart</h2>
      <div class="scrollable-content">
        <table id="in-cart" class="table table-striped">
          <thead>
            <tr>
              <th>Room</th>
              <th>Type</th>
              <th>Occupancy Type</th>
              <th>Max Pax</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>  
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../scripts/availableRooms.js"></script>
</body>
</html>
