<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
}

include_once "../config/config.php";

$stmt = $conn->prepare("
    SELECT booking.bookingID, room.roomType, customer.firstName, customer.lastName, 
           booking.dateReservedStart, booking.dateReservedEnd
    FROM booking
    INNER JOIN pricing ON booking.pricingID = pricing.pricingID
    INNER JOIN occupancy ON pricing.occupancyID = occupancy.occupancyID
    INNER JOIN room ON room.roomID = pricing.roomID
    INNER JOIN customer ON booking.customerID = customer.customerID
    WHERE status = 'APPROVED';
");

$stmt->execute();
$result = $stmt->get_result();

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        "id" => $row["bookingID"],
        "title" => $row["roomType"] . " - " . $row["firstName"] . " " . $row["lastName"],
        "start" => date("Y-m-d", strtotime($row["dateReservedStart"])),
        "end" => date("Y-m-d", strtotime($row["dateReservedEnd"])),
    ];
}

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    echo json_encode($events);
}

$conn->close();
?>
