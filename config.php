<?php
// config.php
$ai_config = array(
    'groq_api_key' => getenv('GROQ_API_KEY') // Removed the extra semicolon here
);

$news_config = array(
    'gnews_api_key' => getenv('GNEWS_API_KEY')
);

// Tracking / analytics. All optional and env-driven (no secrets in source).
//  - CLOUDFLARE_ANALYTICS_TOKEN : enables the optional Cloudflare Web Analytics beacon.
//  - STATS_TOKEN                 : required to view the /stats.php dashboard (?token=...).
//  - TRACKING_SALT              : salt for the daily visitor hash (set any random string).
$analytics_config = array(
    'cloudflare_token' => getenv('CLOUDFLARE_ANALYTICS_TOKEN'),
    'stats_token'      => getenv('STATS_TOKEN'),
    'tracking_salt'    => getenv('TRACKING_SALT')
);
?>
