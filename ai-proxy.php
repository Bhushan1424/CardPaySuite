<?php
/**
 * CARDPAY SUITE - AI PROXY BRIDGE (AUTO-HEALING VERSION)
 * This version automatically tries multiple models if the first one is not found.
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// 1. Configuration
$API_KEY = 'AIzaSyA9HHnkH8S1o9UMmZHjMjZK_yDC2AMFPj8'; // <--- REPLACE THIS

// We define a list of models to try in order of preference
$model_fallback_list = array(
    "gemini-1.5-flash", // Fast, modern
    "gemini-1.5-pro",   // More powerful
    "gemini-pro",       // Classic stable
    "gemini-1.0-pro"    // Legacy fallback
);

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

// 4. Payload Structure
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

// 5. THE LOOP: Try models until one works
$finalAnswer = null;
$lastError = "";

foreach ($model_fallback_list as $currentModel) {
    // We try v1beta first, then v1 if that fails
    $versions = array("v1beta", "v1");
    
    foreach ($versions as $version) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/" . $currentModel . ":generateContent?key=" . $API_KEY;
        // If version is v1, replace v1beta in the URL
        if ($version == "v1") {
            $url = str_replace("v1beta", "v1", $url);
        }

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

        if ($response !== FALSE) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $finalAnswer = $result['candidates'][0]['content']['parts'][0]['text'];
                break 2; // SUCCESS! Break out of both loops
            } else {
                $lastError = isset($result['error']['message']) ? $result['error']['message'] : "Model not available";
            }
        } else {
            $lastError = "Connection failed for " . $currentModel;
        }
    }
}

// 6. Final Response
if ($finalAnswer) {
    echo json_encode(array('answer' => $finalAnswer));
} else {
    echo json_encode(array('answer' => "AI Error: I couldn't find a compatible model for your API key. Last error: " . $lastError));
}
?>
