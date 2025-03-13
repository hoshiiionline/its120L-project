<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
}

include_once "../config/config.php";

$bookingID = isset($_GET['bookingID']) ? intval($_GET['bookingID']) : null;

if ($bookingID) {
    $stmt = $conn->prepare("
    SELECT * FROM booking 
    INNER JOIN pricing ON booking.pricingID = pricing.pricingID
    INNER JOIN occupancy ON pricing.occupancyID = occupancy.occupancyID
    INNER JOIN room on room.roomID = pricing.roomID
    INNER JOIN customer on booking.customerID = customer.customerID
    WHERE bookingID = ? AND status = 'PENDING'
    ");
    $stmt->bind_param("i", $bookingID);
} else {
    $stmt = $conn->prepare("SELECT * FROM booking WHERE status = 'PENDING'");
}

$stmt->execute();
$result = $stmt->get_result();
$data = $bookingID ? $result->fetch_assoc() : $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data);
$stmt->close();
$conn->close();
?>
