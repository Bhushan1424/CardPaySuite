<?php
// config.php
$ai_config = array(
    'groq_api_key' => getenv('GROQ_API_KEY') // Removed the extra semicolon here
);

$news_config = array(
    'gnews_api_key' => getenv('GNEWS_API_KEY')
);

// Tracking / analytics. All optional and env-driven (no secrets in source).
//  - GA_MEASUREMENT_ID : Google Analytics 4 measurement id (e.g. G-XXXXXXXXXX);
//                        when set, header.php renders the gtag.js snippet.
//  - TRACKING_SALT     : salt for the per-visitor hash used by the proxy rate limiter.
$analytics_config = array(
    'ga_measurement_id' => getenv('GA_MEASUREMENT_ID'),
    'tracking_salt'     => getenv('TRACKING_SALT')
);
?>
