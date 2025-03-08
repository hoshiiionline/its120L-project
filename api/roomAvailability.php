<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
}

include_once "../config/config.php";

if (isset($_GET["start-date"], $_GET["end-date"], $_GET["pax"])) {
    $startDate = $_GET["start-date"];
    $endDate = $_GET["end-date"];
    $noPax = intval($_GET["pax"]);

    if ($startDate >= $endDate) {
        echo json_encode(["error" => "Check-Out date must be after Check-In date"]);
        exit;
    }

    $stmt = $conn->prepare("
        SELECT room.*, pricing.*, occupancy.*
        FROM pricing
        INNER JOIN room ON pricing.roomID = room.roomID
        INNER JOIN occupancy ON pricing.occupancyID = occupancy.occupancyID
        LEFT JOIN booking ON pricing.pricingID = booking.pricingID 
            AND booking.dateReservedStart <= ?
            AND booking.dateReservedEnd >= ?
        WHERE booking.bookingID IS NULL and occupancy.occupancyMax >= ?
        ORDER BY occupancy.occupancyMax;
    ");

    $stmt->bind_param("ssi", $startDate, $endDate, $noPax);
    $stmt->execute();
    $result = $stmt->get_result();

    $availableRooms = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo json_encode(["error" => "Missing required parameters", "start-date" => $_GET["start-date"], "end-date" => $_GET["end-date"], "pax" => intval($_GET["pax"])]);
}

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    echo json_encode($availableRooms);
}

$conn->close();
?>
