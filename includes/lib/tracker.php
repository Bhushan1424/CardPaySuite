<?php
/*
    CARDPAY SUITE - Lightweight tracker + rate limiter.

    No database (matches the app's stateless, no-DB design): events are appended
    as one JSON object per line to logs/events-YYYY-MM-DD.jsonl, and rate-limit
    counters live in small per-key JSON files. Privacy-conscious by design:
      - the raw IP address is NEVER stored;
      - visitors are identified by a salted daily hash (rotates every day);
      - no cookies are set.

    Used for:
      - Category A: server-side pageview logging (called from includes/header.php).
      - Category B: rate limiting + call logging on the API proxies.
*/

if (!function_exists('cps_logs_dir')) {
    /** Absolute path to the logs directory (created + web-protected on first use). */
    function cps_logs_dir() {
        $dir = __DIR__ . '/../../logs'; // includes/lib -> project root -> /logs
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
            // Defense in depth: block direct HTTP access to the log files on Apache.
            $htaccess = "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n"
                      . "<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n";
            @file_put_contents($dir . '/.htaccess', $htaccess);
        }
        return $dir;
    }
}

if (!function_exists('cps_client_ip')) {
    /** Best-effort client IP, honoring Cloudflare / proxy headers. Used only for hashing. */
    function cps_client_ip() {
        $keys = array('HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');
        foreach ($keys as $k) {
            if (!empty($_SERVER[$k])) {
                $ip = $_SERVER[$k];
                if (strpos($ip, ',') !== false) {
                    $parts = explode(',', $ip);
                    $ip = trim($parts[0]);
                }
                return $ip;
            }
        }
        return '0.0.0.0';
    }
}

if (!function_exists('cps_referrer_host')) {
    /** The host of the referring page, or "(direct)". We never store full URLs. */
    function cps_referrer_host() {
        if (empty($_SERVER['HTTP_REFERER'])) {
            return '(direct)';
        }
        $host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        return $host ? $host : '(direct)';
    }
}

if (!function_exists('cps_visitor_hash')) {
    /**
     * A salted, daily-rotating pseudonymous id derived from IP + User-Agent.
     * Lets us count unique-ish visitors and rate-limit abusers WITHOUT storing PII.
     */
    function cps_visitor_hash() {
        global $analytics_config;
        $salt = (isset($analytics_config['tracking_salt']) && $analytics_config['tracking_salt'] !== '')
            ? $analytics_config['tracking_salt']
            : 'cardpay-default-salt';
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        return substr(hash('sha256', cps_client_ip() . '|' . $ua . '|' . $salt . '|' . gmdate('Y-m-d')), 0, 16);
    }
}

if (!function_exists('cps_track_event')) {
    /**
     * Append a single tracking event. Fails silently so tracking can never break a page.
     * @param string $type e.g. 'pageview', 'ai_proxy', 'bin_proxy'
     * @param array  $meta optional extra fields
     */
    function cps_track_event($type, $meta = array()) {
        $record = array(
            't'    => gmdate('c'),
            'type' => $type,
            'path' => isset($_SERVER['REQUEST_URI']) ? substr($_SERVER['REQUEST_URI'], 0, 200) : '',
            'ref'  => cps_referrer_host(),
            'cc'   => isset($_SERVER['HTTP_CF_IPCOUNTRY']) ? $_SERVER['HTTP_CF_IPCOUNTRY'] : 'XX',
            'vid'  => cps_visitor_hash()
        );
        if (!empty($meta)) {
            $record['meta'] = $meta;
        }
        $file = cps_logs_dir() . '/events-' . gmdate('Y-m-d') . '.jsonl';
        @file_put_contents($file, json_encode($record) . "\n", FILE_APPEND | LOCK_EX);
    }
}

if (!function_exists('cps_rate_limit')) {
    /**
     * Fixed-window rate limiter backed by a per-key counter file.
     * Fail-OPEN: if the filesystem is unavailable we allow the request rather than
     * break the proxy.
     * @return bool true if the request is allowed, false if the limit is exceeded.
     */
    function cps_rate_limit($key, $maxHits, $windowSeconds) {
        $dir = cps_logs_dir() . '/rl';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $file = $dir . '/' . hash('sha256', $key) . '.json';
        $now = time();
        $state = array('start' => $now, 'count' => 0);

        $fp = @fopen($file, 'c+');
        if ($fp === false) {
            return true; // fail-open
        }
        flock($fp, LOCK_EX);
        $raw = stream_get_contents($fp);
        if ($raw) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && isset($decoded['start'], $decoded['count'])) {
                $state = $decoded;
            }
        }
        if ($now - $state['start'] >= $windowSeconds) {
            $state = array('start' => $now, 'count' => 0); // window elapsed, reset
        }
        $state['count']++;
        $allowed = $state['count'] <= $maxHits;

        rewind($fp);
        ftruncate($fp, 0);
        fwrite($fp, json_encode($state));
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        return $allowed;
    }
}
