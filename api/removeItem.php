<?php
session_start();
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['roomType'])) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$cart = array_filter($cart, fn($room) => $room['roomType'] !== $input['roomType']);

$_SESSION['cart'] = array_values($cart); // Reindex array

echo json_encode(["success" => true, "cart" => $cart]);
?>