<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
}

include_once "../config/config.php";

if (isset($_GET["start-date"], $_GET["end-date"])) {
    $startDate = $_GET["start-date"];
    $endDate = $_GET["end-date"];
    //$pax = intval($_GET["pax"]);

    if ($startDate >= $endDate) {
        echo json_encode(["error" => "Check-Out date must be after Check-In date"]);
        exit;
    }

    $stmt = $conn->prepare("
        SELECT room.roomType, room.roomPackage
        FROM booking 
        LEFT JOIN pricing 
            ON booking.pricingID = pricing.pricingID
        RIGHT JOIN room 
            ON pricing.roomID = room.roomID
        WHERE booking.bookingID NOT IN (
                SELECT bookingID 
                FROM booking 
                WHERE bookingDate BETWEEN ? AND ?
            );
    ");

    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $availableRooms = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($availableRooms);
} else {
    echo json_encode(["error" => "Missing required parameters", "start-date" => $_GET["start-date"], "end-date" => $_GET["end-date"]]);
}

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    echo json_encode($availableRooms);
}

$conn->close();
?>
