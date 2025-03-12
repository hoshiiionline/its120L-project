<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
}

include_once "../config/config.php";

$stmt = $conn->prepare("
    SELECT *
    FROM booking
    INNER JOIN pricing ON booking.pricingID = pricing.pricingID
    INNER JOIN occupancy ON pricing.occupancyID = occupancy.occupancyID
    INNER JOIN room on room.roomID = pricing.roomID
    INNER JOIN customer on booking.customerID = customer.customerID
    WHERE status = 'PENDING';
");

$stmt->execute();
$result = $stmt->get_result();

$availableRooms = $result->fetch_all(MYSQLI_ASSOC);

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    echo json_encode($availableRooms);
}

$conn->close();
?>
