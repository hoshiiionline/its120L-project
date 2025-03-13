<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
}

include_once "../config/config.php";

$bookingID = isset($_GET["bookingID"]) ? $_GET["bookingID"] : null;

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
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $startDate = new DateTime($data['dateReservedStart']);
        $endDate = new DateTime($data['dateReservedEnd']);
        $endDate->modify('+1 day'); // Include the last day in the loop

        $period = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);
        $weekdayCount = 0;
        $weekendCount = 0;

        foreach ($period as $date) {
            if (in_array($date->format('N'), [6, 7])) {
                $weekendCount++;
            } else {
                $weekdayCount++;
            }
        }

        $data['weekdayCount'] = $weekdayCount;
        $data['weekendCount'] = $weekendCount;
    }

    echo json_encode($data);
} else {
    echo json_encode(["error" => "No booking ID provided"]);
}

$conn->close();
?>