<?php

$title = "Available Rooms";
include "../includes/header.php";

$cart = $_SESSION['cart'] ?? [];
$availableRooms = [];

if (isset($_GET["start-date"], $_GET["end-date"])){
    $startDate = $_GET["start-date"];
    $endDate = $_GET["end-date"];

    ob_start();
    include "../api/roomAvailability.php";
    $jsonOutput = ob_get_clean();

    $availableRooms = json_decode($jsonOutput, true) ?? [];

    $availableRooms = array_filter($availableRooms, function ($room) use ($cart) {
      return !in_array($room['roomType'], array_column($cart, 'roomType'));
  });
}
?>

<link rel="stylesheet" href="../css/availableRooms.css">
<body class="background1">
<div class="wrap">
  <div class="row1">
    <!-- Left Container: Available Rooms -->
    <div class="col-lg-6 container left-container">
      <h2>Available Rooms</h2>
      <div class="scrollable-content">
        <table id="available-rooms" class="table table-striped">
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
      <div class="fixed-footer">
        <button id="checkout-cart" class="proceed">Proceed to Booking</button>
        <div style="text-align:left">
          <a class="back" href="https://banahawcircle.com/">< Back</a>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="../scripts/availableRooms.js"></script>
<script>
    document.getElementById("checkout-cart").addEventListener("click", function () {
        // Redirect with query parameters (GET method)
        window.location.href = 'crm.php';
    });
</script>
<?php include "../includes/footer.php"; ?>
