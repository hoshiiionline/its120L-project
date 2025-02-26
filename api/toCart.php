<?php
session_start();
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['roomType'])) {
    echo json_encode(["success" => false, "message" => "Invalid room data"]);
    exit;
}

$cart = $_SESSION['cart'] ?? [];

// Check if the room is already in the cart
foreach ($cart as $room) {
    if ($room['roomType'] === $input['roomType']) {
        echo json_encode(["success" => false, "message" => "Room already in cart"]);
        exit;
    }
}

// Add room to the session cart
$cart[] = $input;
$_SESSION['cart'] = $cart;

echo json_encode(["success" => true, "cart" => $cart]);
