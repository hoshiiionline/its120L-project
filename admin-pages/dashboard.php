<?php

$title = "Admin Dashboard";
include "../includes/header.php";
?>

<link rel="stylesheet" href="../css/availableRooms.css">
<body class="background1">
<div class="wrap">
  <div class="row1">
    <!-- Left Container: Available Rooms -->
    <div class="col-lg-8 container left-container">
      <h2>Pending Bookings</h2>
      <div class="scrollable-content">
        <table id="pending-booking" class="table table-striped">
          <thead>
            <tr>
              <th>Room</th>
              <th>Occupancy Type</th>
              <th>Dates</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    
    <div class="col-lg-4 container right-container">
      <h2>Approved Bookings</h2>
      <div class="scrollable-content">
        <table id="approved-booking" class="table table-striped">
          <thead>
            <tr>
              <th>Room</th>
              <th>Occupancy Type</th>
              <th>Dates</th>
              <th>Price</th>
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

<?php
echo '<script src="../admin-scripts/admin-dashboard.js"></script>';

include "../includes/footer.php"; 
?>
