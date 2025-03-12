<?php

$title = "Admin Dashboard";
include "../includes/header.php";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="../css/availableRooms.css">

<body class="background1">
<div class="wrap">
  <div class="row1">
    <div class="col-lg-1 container left-container d-flex align-items-center justify-content-center">
      <i class="fas fa-arrow-left fa-3x"></i> 
    </div>

    <!-- Left Container: Available Rooms -->
    <div class="col-lg-6 container mid-container">
      <h2>Pending Bookings</h2>
      <div class="scrollable-content">
        <table id="approved-booking" class="table table-striped">
          <thead>
            <tr>
              <th>Room</th>
              <th>Occ. Type</th>
              <th>Dates</th>
              <th>Client</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    
    <div class="col-lg-5 container right-container">
      <h2>Calendar</h2>
      <div id='calendar'></div>
    </div>

  </div>
</div>

<?php
//echo '<script src="../admin-scripts/admin-dashboard.js"></script>';
echo '<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>';
echo '<script src="../admin-scripts/approvedBooking.js"></script>';

include "../includes/footer.php"; 
?>
