<?php
require '../config/config.php';
$title = "CRM";
include "../includes/header.php";

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get cart and booking details from session
$cart = $_SESSION['cart'] ?? [];

// Retrieve booking dates and pax from session
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
$pax = $_SESSION['pax'];

// Reference number generation with daily counter
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

// Create DatePeriod for the booking interval
$start = new DateTime($startDate);
$end = new DateTime($endDate);
$interval = new DateInterval('P1D');
$period = new DatePeriod($start, $interval, $end->modify('+1 day'));

// Load holidays from the local JSON file
$holidaysFile = '../config/holidays.json';
$holidays = [];
if (file_exists($holidaysFile)) {
    $holidaysData = file_get_contents($holidaysFile);
    $holidaysArray = json_decode($holidaysData, true);
    if (is_array($holidaysArray)) {
        foreach ($holidaysArray as $holiday) {
            if (isset($holiday['date'])) {
                $holidays[] = $holiday['date'];
            }
        }
    }
}

// Count weekdays, weekends, and holidays based on the period
$weekdayCount = 0;
$weekendCount = 0;
$holidayCount = 0;
foreach ($period as $date) {
    $dateStr = $date->format('Y-m-d');
    if (in_array($dateStr, $holidays)) {
        $holidayCount++;
    } else if (in_array($date->format('N'), [6, 7])) {
        $weekendCount++;
    } else {
        $weekdayCount++;
    }
}
$_SESSION['weekday'] = $weekdayCount;
$_SESSION['weekend'] = $weekendCount;

// Get form values for pre-population (initialize as empty)
$firstName = "";
$lastName = "";
$email = "";
$phone = "";
$specialRequests = "";
$dietaryPreference = "";

// Check if a returning customer email exists in session and pre-populate fields accordingly
if (isset($_SESSION['returningEmail'])) {
    $returningEmail = $_SESSION['returningEmail'];
    $stmt = $conn->prepare("SELECT * FROM customer WHERE emailAddress = ?");
    $stmt->bind_param("s", $returningEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $firstName         = $row['firstName'] ?? "";
        $lastName          = $row['lastName'] ?? "";
        $email             = $row['emailAddress'] ?? "";
        $phone             = $row['mobileNo'] ?? "";
        $specialRequests   = $row['allergyList'] ?? "";
        $dietaryPreference = $row['mealPreference'] ?? "";
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use POST values if submitted; these will override the pre-populated values.
    $firstName         = $_POST['firstName'] ?? '';
    $lastName          = $_POST['lastName'] ?? '';
    $email             = $_POST['email'] ?? '';
    $phone             = $_POST['phone'] ?? '';
    $specialRequests   = $_POST['specialRequests'] ?? '';
    $dietaryPreference = $_POST['dietaryPreference'] ?? '';

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($dietaryPreference) && !empty($specialRequests)) {
        // Check if the customer already exists based on the email
        $stmt = $conn->prepare("SELECT customerID FROM customer WHERE emailAddress = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $customerID = null;
        if ($result && $result->num_rows > 0) {
            // Customer exists: update the record
            $row = $result->fetch_assoc();
            $customerID = $row['customerID'];
            $stmt->close();
            $stmt = $conn->prepare("UPDATE customer SET firstName = ?, lastName = ?, mobileNo = ?, allergyList = ?, mealPreference = ? WHERE emailAddress = ?");
            $stmt->bind_param("ssssss", $firstName, $lastName, $phone, $specialRequests, $dietaryPreference, $email);
            $stmt->execute();
            $stmt->close();
        } else {
            // Customer does not exist: insert a new record
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO customer (firstName, lastName, emailAddress, mobileNo, allergyList, mealPreference) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $specialRequests, $dietaryPreference);
            $stmt->execute();
            // Get the inserted customer ID
            $customerID = $conn->insert_id;
            $stmt->close();
        }
        
        // Set the session variable for returning email for future use
        $_SESSION['returningEmail'] = $email;
        
        // Store reference number and redirect to thank you page
        $_SESSION['refNo'] = $referenceNumber;
        header('Location: thankYouPage.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Please fill in all required fields.</div>";
    }

    // Booking insert: now use $customerID if it exists
    if ($customerID) {
        foreach ($cart as $item) {
            $pricingID = $item['pricingID'];
            $stmt = $conn->prepare("INSERT INTO booking (referenceNo, customerID, pricingID, dateReservedStart, dateReservedEnd, additionalRequests) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siisss", $referenceNumber, $customerID, $pricingID, $startDate, $endDate, $specialRequests);
            $stmt->execute();
            $stmt->close();
        }
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
      <form method="POST" id = "crmForm">
        <div class="form">
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" placeholder="John" required value="<?php echo htmlspecialchars($firstName); ?>">
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" placeholder="Doe" required value="<?php echo htmlspecialchars($lastName); ?>">
          </div>
        </div>
        <div class="form2">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="johndoe@email.com" required value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="form2">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" placeholder="1234567890" required value="<?php echo htmlspecialchars($phone); ?>">
        </div>
        <div class="form3">
          <label for="dietaryPreference" style="text-align: left;">Dietary Preference</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="dietaryPreference" id="dietaryPreference1" value="regular" <?php if($dietaryPreference == "regular") echo "checked"; ?>>
            <label class="form-check-label" for="dietaryPreference1">Regular</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="dietaryPreference" id="dietaryPreference2" value="vegetarian" <?php if($dietaryPreference == "vegetarian") echo "checked"; ?>>
            <label class="form-check-label" for="dietaryPreference2">Vegetarian</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="dietaryPreference" id="dietaryPreference3" value="others" <?php if($dietaryPreference == "others") echo "checked"; ?>>
            <label class="form-check-label" for="dietaryPreference3">Others</label>
          </div>
        </div>
        <div class="form2">
          <label for="specialRequests">Special Requests</label>
          <textarea id="specialRequests" name="specialRequests" rows="3" placeholder="Any additional details... (i.e. Allergies, etc.)"><?php echo htmlspecialchars($specialRequests); ?></textarea>
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
          <?php echo "<a class='back' href='../pages/availableRooms.php?start-date=" . urlencode($startDate) . "&end-date=" . urlencode($endDate) . "&pax=" . urlencode($pax) . "'>< Back</a>"; ?>
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
const holidayCount = <?php echo json_encode($holidayCount); ?>;
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
  const weekdayRate = record.pricingRateRoom * 1;
  const weekendRate = record.pricingRateRoom * 1.015;
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
  document.getElementById('grandTotal').innerText = "₱" + perPax.toFixed(2)*pax;
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
<script>
// Confirmation before form submission
document.getElementById("crmForm").addEventListener("submit", function(e) {
    var confirmationMessage = "";
    <?php if(isset($_SESSION['returningEmail'])): ?>
        confirmationMessage = "You are an existing user. Are you sure you want to update your record with these details?";
    <?php else: ?>
        confirmationMessage = "Are you sure all your details are correct?";
    <?php endif; ?>
    if (!confirm(confirmationMessage)) {
         e.preventDefault();
    }
});
</script>
<?php include "../includes/footer.php"; ?>
