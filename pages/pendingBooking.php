<?php
$title = "My Dashboard";
include "../includes/header.php";
$referenceNumber = $_SESSION['refNoCheck'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="../admin-css/pendingBooking.css">

<body class="background1">
<div class="wrap">
  <div class="row1">
    
    <!-- Left Container: Pending Bookings -->
    <div class="col-lg-7 container left-container">
      <h2>Pending Bookings</h2>
      <div class="scrollable-content">
        <table id="pending-booking" class="table table-striped">
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
      <!-- Back Button Aligned to the Left -->
      <div class="col-lg-12" style="text-align: left;">
        <button class="btn btn-secondary" onclick="window.history.back()">
          <i class="fas fa-arrow-left"></i> Back
        </button>
      </div>
    </div>
    
    <!-- Right Container: Detailed Information -->
    <div class="col-lg-4 container mid-container">
      <h2>Detailed Information</h2>
      <div class="scrollable-content">
        <table id="customer-info" class="table table-striped" style="display:none;">
          <tr>
              <th>Desc.</th>
              <th>Info.</th>
          </tr>
          <tr>
              <td>Name</td>
              <td>Please Select a Record</td>
          </tr>
          <tr>
              <td>Email</td>
              <td>Please Select a Record</td>
          </tr>
          <tr>
              <td>Mobile No.</td>
              <td>Please Select a Record</td>
          </tr>
          <tbody>
          </tbody>  
        </table>
        <h4>Room Information</h4>
        <table id="room-info" class="table table-striped">
          <tr>
              <th>Desc.</th>
              <th>Info.</th>
          </tr>
          <tr>
              <td>Room Type</td>
              <td>Please Select a Record</td>
          </tr>
          <tr>
              <td>Date</td>
              <td>Please Select a Record</td>
          </tr>
          <tr>
              <td>Pax</td>
              <td>Please Select a Record</td>
          </tr>
          <tr>
              <td>Status</td>
              <td>Please Select a Record</td>
          </tr>
          <tr>
              <td>Price</td>
              <td>Please Select a Record</td>
          </tr>
          <tbody>
          </tbody>  
        </table>
        <h4>Pricing Information</h4>
        <table id="priceBreakdown">
        <thead>
          <tr>
            <th colspan="4" id="room-type" style="text-align: center;"></th>
          </tr>
          <tr>
            <th>Category</th>
            <th>Days</th>
            <th>Rate</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Weekday</td>
            <td id="weekday-count"></td>
            <td id="weekday-rate"></td>
            <td id="weekday-subtotal"></td>
          </tr>
          <tr>
            <td>Weekend</td>
            <td id="weekend-count"></td>
            <td id="weekend-rate"></td>
            <td id="weekend-subtotal"></td>
          </tr>
          <tr>
            <td>Holiday</td>
            <td id="holiday-count"></td>
            <td id="holiday-rate"></td>
            <td id="holiday-subtotal"></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" style="text-align: right;">Est. TOTAL:</td>
            <td id="total-price"></td>
          </tr>
        </tfoot>
      </table>
      </div>
    </div>
  </div>
</div>

<?php
echo '<script src="../client-scripts/pendingBooking.js"></script>';
include "../includes/footer.php"; 
?>
