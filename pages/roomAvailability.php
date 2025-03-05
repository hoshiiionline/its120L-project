<?php
$title = "Room Availability";
include "../includes/header.php";
$signal = $_SESSION['package'];
echo $signal;
?>

<label for="Check-In">Check-In:</label>
<input type="date" id="start-date" name="start-date">

<label for="Check-Out">Check-Out:</label>
<input type="date" id="end-date" name="end-date">

<label for="pax">No. of Pax:</label>
<input type="number" id="pax" name="pax" min="1" required>

<button id="query-btn">Submit</button>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Get today's date in YYYY-MM-DD format
    let today = new Date();
    today.setDate(today.getDate() + 1); // Prevent selecting today
    let minDate = today.toISOString().split("T")[0];

    // Set the min attribute for check-in and check-out dates
    let startDateInput = document.getElementById("start-date");
    let endDateInput = document.getElementById("end-date");

    startDateInput.min = minDate;

    startDateInput.addEventListener("change", function () {
        let selectedCheckIn = new Date(startDateInput.value);
        selectedCheckIn.setDate(selectedCheckIn.getDate() + 1); // Ensure checkout is after check-in
        endDateInput.min = selectedCheckIn.toISOString().split("T")[0];
    });
});

document.getElementById("query-btn").addEventListener("click", function () {
    let startDate = document.getElementById("start-date").value;
    let endDate = document.getElementById("end-date").value;

    if (!endDate) {
        alert("Please select a date before submitting.");
        return;
    }

    // Redirect with query parameters (GET method)
    window.location.href = "availableRooms.php?start-date=" + encodeURIComponent(startDate) + "&end-date=" + encodeURIComponent(endDate);
});
</script>

<?php
include "../includes/footer.php"
?>
