<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["bookingID"])) {
    echo json_encode(["success" => false, "error" => "Missing booking ID"]);
    exit;
}

$bookingID = $data["bookingID"];
$updateFields = [];
$params = [];
$paramTypes = "";
$returnBookingID = false;

if (isset($data["newPax"])) {
    $updateFields[] = "pax = ?";
    $params[] = $data["newPax"];
    $paramTypes .= "i";
    $returnBookingID = true;
}

if (isset($data["status"])) {
    $validStatuses = ["PENDING", "CANCEL"];
    if (!in_array($data["status"], $validStatuses)) {
        echo json_encode(["success" => false, "error" => "Invalid status"]);
        exit;
    }
    $updateFields[] = "status = ?";
    $params[] = $data["status"];
    $paramTypes .= "s";
}

if (empty($updateFields)) {
    echo json_encode(["success" => false, "error" => "No valid fields to update"]);
    exit;
}

$sql = "UPDATE booking SET " . implode(", ", $updateFields) . " WHERE bookingID = ?";
$params[] = $bookingID;
$paramTypes .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($paramTypes, ...$params);

if ($stmt->execute()) {
    $response = ["success" => true];
    if ($returnBookingID) {
        $response["bookingID"] = $bookingID;
    }
    echo json_encode($response);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
