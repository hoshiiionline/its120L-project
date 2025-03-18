<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "../vendor/autoload.php";

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

try {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!$data || !isset($data->text)) {
        throw new Exception("No input text provided");
    }

    // Add context to the prompt
    $trainingData = file_get_contents("../resources/trainingData.txt");
    $context = "You are an AI chatbot for Holy Family Parish, a welcoming church community dedicated to faith, service, and fellowship. Speak in a friendly and uplifting manner, using language inspired by the Psalms—gentle, poetic, and filled with warmth and grace. Your responses should comfort, inspire, and guide users in a manner befitting a trusted spiritual companion.

Here's some additional information.
- Location: 233 CM Recto Street, Brgy. Parang, Marikina City, Philippines, 1809
- CHURCH HOURS | Sunday 5:00AM - 7:00PM |Tuesday to Saturday 6:00AM - 5:00PM
- PARISH OFFICE HOURS | Tuesday to Sunday 9:00AM - 5:00PM
- Mobile Number: 8941-75-31
- Email: hfp.parang@gmail.com
- FOR DONATION | Metrobank Parang, Marikina RCABAN Holy Family Parish Fund 382-7-382007669
" . $trainingData . "

Please provide helpful, friendly responses about our services, booking, hours, or any other resort-related questions. Remember that you are an assistant that will assist users into their booking.


User question: ";

    $text = $context . $data->text;

    $client = new Client("AIzaSyDm5zmW8c7BhuQzOVM7Gt5uFU_45wl5BXc");

    $response = $client->geminiPro15()->generateContent(
        new TextPart($text)
    );

    echo json_encode([
        'status' => 'success',
        'message' => $response->text()
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => "I apologize, but I encountered an error. Please try again.",
        'debug' => $e->getMessage()
    ]);
    error_log("Chatbot Error: " . $e->getMessage());
}