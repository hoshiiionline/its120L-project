<?php
$title = "CRM";
include "../includes/header.php";
$cart = $_SESSION['cart'] ?? [];

$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
$pax = $_SESSION['pax'];

// reference No generation
date_default_timezone_set('UTC');
$today = date('Y_m_d');
$fileName = '../config/counter_' . $today . '.txt';
$file = fopen($fileName, 'c+');
if (!$file) {
    die("Unable to open counter file.");
}
if (!flock($file, LOCK_EX)) {
    die("Unable to lock counter file.");
}
$counter = 0;
$fileSize = filesize($fileName);
if ($fileSize > 0) {
    $data = fread($file, $fileSize);
    $counter = (int)trim($data);
}
$counter++;
rewind($file);
ftruncate($file, 0);
fwrite($file, $counter);
fflush($file);
flock($file, LOCK_UN);
fclose($file);
$formattedCounter = sprintf("%04d", $counter);
$referenceNumber = $today . '.' . $formattedCounter;

$start = new DateTime($startDate);
$end = new DateTime($endDate);
$interval = new DateInterval('P1D');
$period = new DatePeriod($start, $interval, $end->modify('+1 day'));

$weekdayCount = 0;
$weekendCount = 0;

foreach ($period as $date) {
  if (in_array($date->format('N'), [6, 7])) {
    $weekendCount++;
  } else {
    $weekdayCount++;
  }
}

$_SESSION['weekday'] = $weekdayCount;
$_SESSION['weekend'] = $weekendCount;

if (isset($_GET["start-date"], $_GET["end-date"])) {
  $startDate = $_GET["start-date"];
  $endDate   = $_GET["end-date"];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $firstName       = $_POST['firstName'] ?? '';
  $lastName        = $_POST['lastName'] ?? '';
  $email           = $_POST['email'] ?? '';
  $phone           = $_POST['phone'] ?? '';
  $specialRequests = $_POST['specialRequests'] ?? '';
  $dietaryPreference = $_POST['dietaryPreference'] ?? '';

  if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($dietaryPreference)) {
    $stmt = $conn->prepare("INSERT INTO customer (firstName, lastName, emailAddress, mobileNo, mealPreference) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $dietaryPreference);
    if ($stmt->execute()) {
      echo "<div class='alert alert-success'>Yess successfully submitted!</div>";
    } else {
      echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
  } else {
    echo "<div class='alert alert-danger'>Please fill in all required fields.</div>";
  }

  $stmt = $conn->prepare("SELECT customerID FROM customer WHERE emailAddress = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $customerID = $result->fetch_assoc()['customerID'];
  //echo "<div class='alert alert-success'>Here is my $customerID</div>";
  $stmt->close();

  foreach ($cart as $item) {
    $pricingID = $item['pricingID'];
    $pricingRateRoom = $item['pricingRateRoom']; // Room rate

    // Calculate totals
    $weekdayRate = $pricingRateRoom * 1;
    $weekendRate = $pricingRateRoom * 1.015;
    $holidayRate = $pricingRateRoom * 1.02;

    $weekdaySubtotal = $weekdayRate * $weekdayCount;
    $weekendSubtotal = $weekendRate * $weekendCount;
    $holidaySubtotal = 0;

    $total = ($weekdaySubtotal + $weekendSubtotal + $holidaySubtotal) * $pax;

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO booking (referenceNo, customerID, pricingID, dateReservedStart, dateReservedEnd, pax, additionalRequests, estPricingTotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siissisd", $referenceNumber, $customerID, $pricingID, $startDate, $endDate, $pax, $specialRequests, $total);
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
      <form method="POST">
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
        <div class="form3">
          <label for="dietaryPreference" style="text-align: left;">Dietary Preference</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="dietaryPreference" id="dietaryPreference1" value="regular">
            <label class="form-check-label" for="inlineRadio1">Regular</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="dietaryPreference" id="dietaryPreference2" value="vegetarian">
            <label class="form-check-label" for="inlineRadio2">Vegetarian</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="dietaryPreference" id="dietaryPreference3" value="others">
            <label class="form-check-label" for="dietaryPreference">Others</label>
          </div>
        </div>
        <div class="form2">
          <label for="specialRequests">Special Requests</label>
          <textarea id="specialRequests" name="specialRequests" rows="3" placeholder="Any additional details... (i.e. Allergies, etc.)"></textarea>
        </div>
        <div class="form2">
          <input type="checkbox" id="dataPrivacy" name="dataPrivacy" required>
          <label for="dataPrivacy">
             I hereby acknowledge that I have read and understood the full details of the 
            <a href="dataPrivacyNotice.php" target="_blank">data privacy policy</a>.
          </label>
        </div>
        <div class="form2">
          <button id="query-btn" class="submit">Submit</button>
        </div>
        <div style="text-align:left">
          <?php echo "<a class='back' href='../pages/availableRooms.php?start-date=". urlencode(string: $startDate) . "&end-date=" . urlencode($endDate) . "&pax=".urlencode($pax)."'>< Back</a>"; ?>
        </div>
      </form>
    </div>


    <div class="col-lg-6 container">
      <h2>Your Cart</h2>
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
            <td colspan="3" style="text-align: right;">TOTAL:</td>
            <td id="total-price"></td>
          </tr>
        </tfoot>
      </table>
      
      <div>
        <button id="prevBtn" class="carousel-button">Previous</button>
        <button id="nextBtn" class="carousel-button">Next</button>
      </div>
      
      <div id="roomTotalsContainer">
        <table id="roomTotalsTable">
          <thead>
            <tr>
              <th>Room</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody id="roomTotalsBody">
          </tbody>
        </table>
      </div>
      
      <div id="perPaxContainer" style="margin-top: 10px;">
        <h3>Est. Price per Pax: <span id="perPax"></span></h3>
      </div>

      <div id="grandTotalContainer" style="margin-top: 10px;">
        <h3>Est. Grand Total: <span id="grandTotal"></span></h3>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../scripts/availableRooms.js"></script>

<script>
const cartData = <?php echo json_encode($cart); ?>;
const pax = <?php echo json_encode($_SESSION['pax'] ?? 1); ?>;
const weekdayCount = <?php echo json_encode($_SESSION['weekday'] ?? 2); ?>;
const weekendCount = <?php echo json_encode($_SESSION['weekend'] ?? 1); ?>;
const holidayCount = 1; 

let currentIndex = 0;

function updateTable() {
  if (cartData.length === 0) {
    document.getElementById("room-type").innerText = "No records in cart";
    return;
  }
  
  const record = cartData[currentIndex];
  
  if (!record.roomType || !record.pricingRateRoom) {
    document.getElementById("room-type").innerText = "Invalid record format.";
    return;
  }
  
  const weekdayRate    = record.pricingRateRoom * 1;
  const weekendRate    = record.pricingRateRoom * 1.015;
  const weekdaySubtotal = weekdayRate * weekdayCount;
  const weekendSubtotal = weekendRate * weekendCount;
  const holidaySubtotal = record.pricingRateRoom * 1.02 * holidayCount;
  const total = weekdaySubtotal + weekendSubtotal + holidaySubtotal;
  
  document.getElementById("room-type").innerText = record.roomType;
  document.getElementById("weekday-count").innerText = weekdayCount;
  document.getElementById("weekday-rate").innerText = "₱" + weekdayRate.toFixed(2);
  document.getElementById("weekday-subtotal").innerText = "₱" + weekdaySubtotal.toFixed(2);
  
  document.getElementById("weekend-count").innerText = weekendCount;
  document.getElementById("weekend-rate").innerText = "₱" + weekendRate.toFixed(2);
  document.getElementById("weekend-subtotal").innerText = "₱" + weekendSubtotal.toFixed(2);
  
  document.getElementById("holiday-count").innerText = holidayCount;
  document.getElementById("holiday-rate").innerText = "₱" + (record.pricingRateRoom * 1.02).toFixed(2);
  document.getElementById("holiday-subtotal").innerText = "₱" + holidaySubtotal.toFixed(2);
  
  document.getElementById("total-price").innerText = "₱" + total.toFixed(2);
}

function updateRoomTotals() {
  let perPax = 0;
  const tbody = document.getElementById('roomTotalsBody');
  tbody.innerHTML = ''; 
  
  cartData.forEach(record => {
    if (!record.roomType || !record.pricingRateRoom) return;
    const wSubtotal = record.pricingRateRoom * 1 * weekdayCount;
    const weSubtotal = record.pricingRateRoom * 1.015 * weekendCount;
    const hSubtotal = record.pricingRateRoom * 1.02 * holidayCount;
    const roomTotal = wSubtotal + weSubtotal + hSubtotal;
    perPax += roomTotal;
    
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${record.roomType}</td><td>₱${roomTotal.toFixed(2)}</td>`;
    tbody.appendChild(tr);
  });
  document.getElementById('perPax').innerText = "₱" + perPax.toFixed(2);
  document.getElementById('grandTotal').innerText = "₱" + (perPax.toFixed(2)*pax).toFixed(2);
}

document.getElementById("prevBtn").addEventListener("click", function() {
  if (currentIndex > 0) {
    currentIndex--;
    updateTable();
  }
});

document.getElementById("nextBtn").addEventListener("click", function() {
  if (currentIndex < cartData.length - 1) {
    currentIndex++;
    updateTable();
  }
});

updateTable();
updateRoomTotals();
</script>
<?php include "../includes/footer.php"; ?>
