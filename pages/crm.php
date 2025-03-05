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

<body class="bg-light">
<div class="container-fluid">
  <div class="row">
    <!-- CRM Form -->
    <div class="col-lg-6">
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
              <div class="card-body">
                <h2 class="card-title text-center mb-4">Hotel Booking Form</h2>
                <form action="crm.php" method="POST">
                  <div class="row mb-3">
                    <div class="col">
                      <label for="firstName" class="form-label">First Name</label>
                      <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Tomas" required>
                    </div>
                    <div class="col">
                      <label for="lastName" class="form-label">Last Name</label>
                      <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Mapua" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="tomasmapua@mail.com" required>
                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <!-- Using type "tel" for proper phone input -->
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="1234567890" required>
                  </div>
                  <div class="mb-3">
                    <label for="specialRequests" class="form-label">Special Requests</label>
                    <textarea class="form-control" id="specialRequests" name="specialRequests" rows="3" placeholder="Any additional details..."></textarea>
                  </div>
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit Booking</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Cart Display -->
    <div class="col-lg-6">
      <h2>Your Cart</h2>
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
          <!-- Cart items can be populated here via JavaScript or additional PHP -->
        </tbody>  
      </table>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../scripts/availableRooms.js"></script>
</body>
</html>
