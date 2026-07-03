<?php
/**
 * CARDPAY SUITE - AI PROXY BRIDGE (GROQ STABLE VERSION)
 * Updated: Switched to Llama 3.1 Instant for maximum stability.
 */

require __DIR__ . '/includes/bootstrap.php';

cps_cors('POST');

// 1. Load API key from config (loaded by bootstrap)
$API_KEY = cps_require_key(
    isset($ai_config) ? $ai_config : array(),
    'groq_api_key',
    array('answer' => 'Configuration Error: groq_api_key missing in config.php.')
);

// 2. MODEL LIST (In order of preference)
// We try the newest, fastest model first.
$model_attempts = array(
    "llama-3.1-8b-instant", // Current standard fast model
    "llama3-8b-8192",       // Legacy fallback
    "mixtral-8x7b-32768"    // Reliable alternative
);

// 3. Get Input
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$userQuestion = isset($input['question']) ? $input['question'] : '';

if (empty($userQuestion)) {
    cps_json(array('answer' => 'Please ask a question first!'));
}

// 4. System Prompt
$systemPrompt = "You are the official AI Guide for 'CardPay Suite'. You are an expert in ISO 8583 and EMV TLV. Keep answers technical, professional, and concise.";

// 5. Loop through models until one works
foreach ($model_attempts as $MODEL) {

    $payload = array(
        "model" => $MODEL,
        "messages" => array(
            array(
                "role" => "system",
                "content" => $systemPrompt
            ),
            array(
                "role" => "user",
                "content" => $userQuestion
            )
        ),
        "temperature" => 0.7
    );

    $jsonPayload = json_encode($payload);

    $url = "https://api.groq.com/openai/v1/chat/completions";

    $options = array(
        "http" => array(
            "header"  => "Content-Type: application/json\r\n" . "Authorization: Bearer " . $API_KEY . "\r\n",
            "method"  => "POST",
            "content" => $jsonPayload,
            "ignore_errors" => true
        )
    );

    $context  = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    if ($response !== FALSE) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            cps_json(array('answer' => $result['choices'][0]['message']['content'])); // Success! Stop looking.
        }
    }
}

// 6. Final Fallback if NO models work
cps_json(array('answer' => "AI Error: All supported models are currently unavailable. Please check your Groq API key."));
