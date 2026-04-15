<?php

header("Content-Type: application/json");

$bin = $_GET['bin'] ?? '';

if(strlen($bin) < 6){
    echo json_encode(["error"=>"Invalid BIN"]);
    exit;
}

$url = "https://data.handyapi.com/bin/".$bin;

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);

$response = curl_exec($ch);

if(curl_errno($ch)){
    echo json_encode(["error"=>curl_error($ch)]);
    exit;
}

curl_close($ch);

echo $response;