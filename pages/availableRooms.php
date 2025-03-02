<?php
session_start();
session_destroy();
session_start();

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
<br />
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
        <h2>Available Rooms</h2>
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
        <br>
        <button id="checkout">Proceed to Booking</button>
      </div>
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
          </tbody>  
        </table>
      </div>
    </div>
</div>

<script src="../scripts/availableRooms.js"></script>
<script> 
  document.getElementById("checkout").addEventListener("click", function () {

    // Redirect with query parameters (GET method)
    window.location.href = 'crm.php';
});
</script>

<?php include "../includes/footer.php"; ?>