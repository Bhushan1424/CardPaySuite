<?php
/*
    CARDPAY SUITE - Bootstrap.
    Path-robust entry point: loads runtime config and shared libraries
    regardless of the caller's directory depth (uses __DIR__, not a bare
    relative path). Include this from proxies and any server-side script:

        require __DIR__ . '/includes/bootstrap.php';
*/

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/lib/http.php';
require_once __DIR__ . '/lib/tracker.php';
