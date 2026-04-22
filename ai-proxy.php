<?php
/**
 * CARDPAY SUITE - AI PROXY BRIDGE (STABLE VERSION)
 * Fixed: API Version updated from v1beta to v1
 */

header('Content-,Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// 1. Configuration
$API_KEY = 'AIzaSyA9HHnkH8S1o9UMmZHjMjZK_yDC2AMFPj8'; // <--- REPLACE THIS
$MODEL = 'gemini-1.5-flash';

// 2. Get Input
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$userQuestion = isset($input['question']) ? $input['question'] : '';

if (empty($userQuestion)) {
    echo json_encode(array('answer' => 'Please ask a question first!'));
    exit;
}

// 3. System Prompt
$systemPrompt = "You are the official AI Guide for 'CardPay Suite'. You are an expert in ISO 8583 and EMV TLV. Keep answers technical and concise.";

// 4. Prepare Payload
$payload = array(
    "contents" => array(
        array(
            "role" => "user",
            "parts" => array(
                array("text" => "SYSTEM INSTRUCTION: " . $systemPrompt . "\n\nUSER QUESTION: " . $userQuestion)
            )
        )
    ),
    "generationConfig" => array(
        "temperature" => 0.7,
        "maxOutputTokens" => 800
    )
);

$jsonPayload = json_encode($payload);

// 5. SEND REQUEST (Using Stable v1 Endpoint)
// Changed v1beta to v1
$url = "https://generativelanguage.googleapis.com/v1/models/" . $MODEL . ":generateContent?key=" . $API_KEY;

$options = array(
    "http" => array(
        "header"  => "Content-Type: application/json\r\n",
        "method"  => "POST",
        "content" => $jsonPayload,
        "ignore_errors" => true 
    )
);

$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);

if ($response === FALSE) {
    echo json_encode(array('answer' => "Critical Error: Could not connect to the AI server."));
    exit;
}

// 6. Process Response
$result = json_decode($response, true);

if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    $answer = $result['candidates'][0]['content']['parts'][0]['text'];
    echo json_encode(array('answer' => $answer));
} else {
    $errorMsg = isset($result['error']['message']) ? $result['error']['message'] : 'The AI service returned an unexpected response.';
    echo json_encode(array('answer' => "AI Error: " . $errorMsg));
}
?>
