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

<h2>Available Rooms</h2>
<table id="available-rooms">
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


<h2>Your Cart</h2>
<table id="in-cart">
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

<button id="checkout">Proceed to Booking</button>

<script src="../scripts/availableRooms.js"></script>

<?php include "../includes/footer.php"; ?>