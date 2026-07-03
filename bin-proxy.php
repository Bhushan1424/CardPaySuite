<?php
/**
 * CARDPAY SUITE - BIN LOOKUP PROXY (HandyAPI)
 * Read-only server-side proxy so the client never calls the vendor directly.
 */

require __DIR__ . '/includes/bootstrap.php';

cps_cors('GET');

// Category B: rate-limit this open proxy to protect the upstream API quota.
if (!cps_rate_limit('bin:' . cps_visitor_hash(), 40, 60)) {
    http_response_code(429);
    cps_json(array('error' => 'Rate limit exceeded — please slow down.'));
}

$bin = isset($_GET['bin']) ? $_GET['bin'] : '';

if (!ctype_digit($bin) || strlen($bin) < 6) {
    cps_json(array('error' => 'Invalid BIN'));
}

cps_track_event('bin_proxy');

$url = "https://data.handyapi.com/bin/" . $bin;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: application/json"
));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $err = curl_error($ch);
    curl_close($ch);
    cps_json(array('error' => $err));
}

curl_close($ch);

// HandyAPI already returns JSON; pass it straight through.
echo $response;
