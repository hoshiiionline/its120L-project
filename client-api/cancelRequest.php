<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once "../config/config.php";

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["bookingID"]) || !isset($data["status"])) {
    echo json_encode(["success" => false, "error" => "Missing parameters"]);
    exit;
}

$bookingID = $data["bookingID"];
$status = $data["status"];

// Ensure status is valid
$validStatuses = ["PENDING", "CANCEL"];
if (!in_array($status, $validStatuses)) {
    echo json_encode(["success" => false, "error" => "Invalid status"]);
    exit;
}

// Update the booking status
$stmt = $conn->prepare("UPDATE booking SET status = ? WHERE bookingID = ?");
$stmt->bind_param("si", $status, $bookingID);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
