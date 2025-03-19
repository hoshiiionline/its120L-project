<?php
$title = "Package Selection";
include "../includes/header.php";
if(isset($_GET['signal'])){
   	$signal = $_GET['signal'];
		 $_SESSION['package'] = $signal;
		 echo $_SESSION['package'];
		 header('Location: ../pages/roomAvailability.php');
		 } else {
				 $_SESSION['package'] = 'invalid';
		 }
include "../includes/header.php";
?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->	
    <title>Package Selection</title>
    <link rel="stylesheet" href="../css/packages.css">
</head>
<body class="background1">
<div class="container">
    <div><img src="../assets/logoflat.png" width="30%"></div>
    <h2>SELECT A PACKAGE</h2>
    <div class="options">
        <a href="../pages/packages.php?signal=package">
            <div class="option-container" style="background-image: url(../assets/naturevilla.png);">
                <div class="label">Room Packages</div>
            </div>
        </a>
        <a href="../pages/packages.php?signal=room">
            <div class="option-container" style="background-image: url(../assets/arthouse.png);">
                <div class="label">Room Only</div>
            </div>
        </a>
    </div>
      <!-- A button to trigger the modal -->
  <button id="diffButton">What's the difference?</button>

<!-- Modal Overlay -->
<div id="diffModal" class="modal-overlay">
  <!-- Modal Box -->
  <div class="modal-box">
    <!-- Close Button -->
    <button class="close-btn" id="closeModal">&times;</button>
    
    <h2>ROOM PACKAGES VS. ROOM ONLY</h2>    
    <table>
      <thead>
        <tr>
          <th>Feature</th>
          <th>Room Packages</th>
          <th>Room Only</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>Room Rate</td>
            <td>Higher rate - inclusion of meals</td>
            <td>Lower base rate - accommodation only</td>
        </tr>
        <tr>
          <td>Meals</td>
          <td>All 3 meals included at a discounted rate; to be discussed after booking request</td>
          <td>Not included; guests must purchase meals separately onsite</td>
        </tr>
        <tr>
            <td>Overall Value</td>
            <td>Best for guests who want flexibility in choosing their food</td>
            <td>Ideal for guests who seek a hassle-free experience and savings in food package</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
    <div style="text-align:left"><a class="back" href="../pages/returningCustomer.php">< Back</a></div>
</div>
<script>
    const diffButton = document.getElementById('diffButton');
    const diffModal = document.getElementById('diffModal');
    const closeModal = document.getElementById('closeModal');

    // Show the modal
    diffButton.addEventListener('click', () => {
      diffModal.style.display = 'block';
    });

    // Hide the modal when close button is clicked
    closeModal.addEventListener('click', () => {
      diffModal.style.display = 'none';
    });

    // Hide the modal if user clicks outside the modal box
    window.addEventListener('click', (e) => {
      if (e.target === diffModal) {
        diffModal.style.display = 'none';
      }
    });
  </script>
<?php include "../includes/footer.php"; ?>