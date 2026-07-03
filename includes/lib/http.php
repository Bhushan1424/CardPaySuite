<?php
/*
    CARDPAY SUITE - Shared HTTP helpers for JSON proxies.
    Keeps CORS headers, JSON responses and config-key checks in one place
    so ai-proxy.php / bin-proxy.php stay small and consistent.
    Plain procedural PHP, array() syntax (matches project convention).
*/

if (!function_exists('cps_cors')) {
    /**
     * Emit the standard JSON + CORS headers shared by every proxy.
     * @param string $methods Allowed methods, e.g. "POST" or "GET".
     */
    function cps_cors($methods = 'POST') {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: ' . $methods);
        header('Access-Control-Allow-Headers: Content-Type');
    }
}

if (!function_exists('cps_json')) {
    /**
     * Send a JSON response and stop. Single exit point for all proxies.
     * @param array $data
     */
    function cps_json($data) {
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('cps_require_key')) {
    /**
     * Ensure a required config value is present, or short-circuit with a
     * JSON error using the given error shape. $errorShape must contain a
     * placeholder-free message already (e.g. array('answer' => '...')).
     * @param array  $config     The config array (e.g. $ai_config).
     * @param string $key        Required key within $config.
     * @param array  $errorShape JSON payload to return when the key is missing.
     * @return mixed The config value when present.
     */
    function cps_require_key($config, $key, $errorShape) {
        if (!isset($config[$key]) || empty($config[$key])) {
            cps_json($errorShape);
        }
        return $config[$key];
    }
}
