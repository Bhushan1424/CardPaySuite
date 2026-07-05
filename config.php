<?php
// config.php
//
// Secrets are read from environment variables. On hosts where real env vars are
// awkward/unreliable (e.g. shared hosting), a local .env file at the project root
// supplies them instead. Keep .env out of version control (it is gitignored) and
// blocked from direct HTTP access (see the root .htaccess).

if (!function_exists('load_env_file')) {
    function load_env_file($path) {
        if (!file_exists($path)) {
            return;
        }
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
                continue;
            }
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (getenv($key) === false) { // real env vars win over the .env file
                putenv("$key=$value");
            }
        }
    }
}

load_env_file(__DIR__ . '/.env');

$ai_config = array(
    'groq_api_key' => getenv('GROQ_API_KEY') // Removed the extra semicolon here
);

$news_config = array(
    'gnews_api_key' => getenv('GNEWS_API_KEY')
);

// Site / SEO.
//  - base_url : canonical origin used to build absolute URLs for canonical tags,
//    Open Graph / Twitter cards, and sitemap.xml. No trailing slash. An env var
//    (SITE_BASE_URL) wins so staging/preview hosts can override it.
$site_base_url = getenv('SITE_BASE_URL');
$site_config = array(
    'base_url' => ($site_base_url !== false && $site_base_url !== '')
        ? rtrim($site_base_url, '/')
        : 'https://cardpaysuite.com'
);

// Tracking / analytics.
//  - GA_MEASUREMENT_ID : Google Analytics 4 measurement id (e.g. G-XXXXXXXXXX).
//    A GA4 measurement id is a PUBLIC client-side id (it ships in the page HTML),
//    so it is safe to keep the live id here as the default; an env var still wins.
//  - TRACKING_SALT     : salt for the per-visitor hash used by the proxy rate limiter.
$ga_measurement_id = getenv('GA_MEASUREMENT_ID');
$analytics_config = array(
    'ga_measurement_id' => ($ga_measurement_id !== false && $ga_measurement_id !== '')
        ? $ga_measurement_id
        : 'G-Y5R9TDTZ5X',
    'tracking_salt'     => getenv('TRACKING_SALT')
);
?>
