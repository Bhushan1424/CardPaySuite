<?php
// Simple contact handler for GoDaddy Web Starter Hosting.
// WARNING: This script does NOT store inputs. It sends an email to the configured recipient.
// Update $recipient before use. Ensure mail() is allowed by your host.
$recipient = 'you@example.com'; // <-- change to your email
$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING) ?? '';
$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL) ?? '';
$message = filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING) ?? '';
if(!$recipient){
    http_response_code(500);
    echo 'Recipient not configured.';
    exit;
}
if(!$email || !$message){
    http_response_code(400);
    echo 'Please provide email and message.';
    exit;
}
$subject = 'CardPaySuite contact from '.($name?:$email);
$body = "From: {$name} ({$email})\n\n".substr($message,0,4000);
// Use mail() — on some shared hosts you may need to configure sender headers
$headers = 'From: noreply@'.($_SERVER['SERVER_NAME'] ?? 'localhost') . "\r\n" . 'Reply-To: '.$email;
$ok = mail($recipient,$subject,$body,$headers);
if($ok) echo 'Message sent (no data retained).'; else { http_response_code(500); echo 'Unable to send message.'; }
?>