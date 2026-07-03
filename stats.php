<?php
/*
    CARDPAY SUITE - Tracking dashboard (Category A + B).
    Token-gated: visit /stats.php?token=YOUR_STATS_TOKEN (set the STATS_TOKEN env var).
    Reads the last 30 days of logs/events-*.jsonl and shows aggregate counts only.
    Standalone page: it does NOT include header/footer, so viewing stats does not
    itself get logged and the AI widget is not loaded here.
*/

require __DIR__ . '/includes/bootstrap.php';

// --- Access control -------------------------------------------------------
$expected = isset($analytics_config['stats_token']) ? $analytics_config['stats_token'] : '';
$provided = isset($_GET['token']) ? $_GET['token'] : '';
if ($expected === '' || !hash_equals((string)$expected, (string)$provided)) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo "403 Forbidden.\n\nThis dashboard is protected. Append ?token=YOUR_STATS_TOKEN\n";
    echo "and set the STATS_TOKEN environment variable on the host.";
    exit;
}

// --- Read + aggregate the last 30 days of events --------------------------
$logsDir = __DIR__ . '/logs';
$days = 30;
$totals = array('pageview' => 0, 'ai_proxy' => 0, 'bin_proxy' => 0);
$uniqueVisitors = array();
$byDay = array();       // date => array('pageviews'=>int, 'visitors'=>array)
$paths = array();       // path => count (pageviews)
$referrers = array();   // host => count (pageviews)
$countries = array();   // cc   => count (pageviews)

for ($i = 0; $i < $days; $i++) {
    $date = gmdate('Y-m-d', time() - $i * 86400);
    $file = $logsDir . '/events-' . $date . '.jsonl';
    if (!is_file($file)) {
        continue;
    }
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        continue;
    }
    foreach ($lines as $line) {
        $e = json_decode($line, true);
        if (!is_array($e) || !isset($e['type'])) {
            continue;
        }
        $type = $e['type'];
        if (isset($totals[$type])) {
            $totals[$type]++;
        }
        if ($type === 'pageview') {
            if (!isset($byDay[$date])) {
                $byDay[$date] = array('pageviews' => 0, 'visitors' => array());
            }
            $byDay[$date]['pageviews']++;
            $vid = isset($e['vid']) ? $e['vid'] : '?';
            $byDay[$date]['visitors'][$vid] = true;
            $uniqueVisitors[$vid] = true;

            $p = isset($e['path']) && $e['path'] !== '' ? $e['path'] : '/';
            $paths[$p] = isset($paths[$p]) ? $paths[$p] + 1 : 1;
            $r = isset($e['ref']) && $e['ref'] !== '' ? $e['ref'] : '(direct)';
            $referrers[$r] = isset($referrers[$r]) ? $referrers[$r] + 1 : 1;
            $c = isset($e['cc']) && $e['cc'] !== '' ? $e['cc'] : 'XX';
            $countries[$c] = isset($countries[$c]) ? $countries[$c] + 1 : 1;
        }
    }
}

arsort($paths);
arsort($referrers);
arsort($countries);
krsort($byDay);

function cps_top($arr, $n) {
    return array_slice($arr, 0, $n, true);
}
function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CardPay Suite — Tracking</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body { padding: 40px 20px; }
        .wrap { max-width: 1000px; margin: 0 auto; }
        h1 { margin-bottom: 4px; }
        .muted { color: var(--text-muted); margin-bottom: 30px; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 16px; margin-bottom: 36px; }
        .stat { padding: 20px; }
        .stat .n { font-size: 2rem; font-weight: 800; color: var(--text-bright); }
        .stat .l { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; }
        .panel { padding: 20px; }
        .panel h2 { font-size: 1.1rem; margin-bottom: 14px; color: var(--accent-primary); }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th, td { text-align: left; padding: 8px 6px; border-bottom: 1px solid var(--border-color); }
        th { color: var(--text-muted); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; }
        td.num { text-align: right; font-variant-numeric: tabular-nums; color: var(--text-bright); font-weight: 600; }
        .empty { color: var(--text-muted); font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="wrap">
    <h1 class="text-gradient">Tracking Dashboard</h1>
    <p class="muted">Aggregate, cookie-free analytics — last <?php echo (int)$days; ?> days. No personal data is stored.</p>

    <div class="cards">
        <div class="stat glass-panel"><div class="n"><?php echo number_format($totals['pageview']); ?></div><div class="l">Pageviews</div></div>
        <div class="stat glass-panel"><div class="n"><?php echo number_format(count($uniqueVisitors)); ?></div><div class="l">Unique Visitors</div></div>
        <div class="stat glass-panel"><div class="n"><?php echo number_format($totals['ai_proxy']); ?></div><div class="l">AI Proxy Calls</div></div>
        <div class="stat glass-panel"><div class="n"><?php echo number_format($totals['bin_proxy']); ?></div><div class="l">BIN Proxy Calls</div></div>
    </div>

    <div class="grid">
        <div class="panel glass-panel">
            <h2>Pageviews by day</h2>
            <?php if (empty($byDay)): ?><p class="empty">No data yet.</p><?php else: ?>
            <table>
                <thead><tr><th>Date (UTC)</th><th class="num">Views</th><th class="num">Visitors</th></tr></thead>
                <tbody>
                <?php foreach ($byDay as $date => $d): ?>
                    <tr><td><?php echo h($date); ?></td><td class="num"><?php echo number_format($d['pageviews']); ?></td><td class="num"><?php echo number_format(count($d['visitors'])); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <div class="panel glass-panel">
            <h2>Top pages</h2>
            <?php if (empty($paths)): ?><p class="empty">No data yet.</p><?php else: ?>
            <table>
                <thead><tr><th>Path</th><th class="num">Views</th></tr></thead>
                <tbody>
                <?php foreach (cps_top($paths, 15) as $p => $n): ?>
                    <tr><td><?php echo h($p); ?></td><td class="num"><?php echo number_format($n); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <div class="panel glass-panel">
            <h2>Where visitors come from</h2>
            <?php if (empty($referrers)): ?><p class="empty">No data yet.</p><?php else: ?>
            <table>
                <thead><tr><th>Referrer</th><th class="num">Views</th></tr></thead>
                <tbody>
                <?php foreach (cps_top($referrers, 10) as $r => $n): ?>
                    <tr><td><?php echo h($r); ?></td><td class="num"><?php echo number_format($n); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <div class="panel glass-panel">
            <h2>Countries</h2>
            <?php if (empty($countries)): ?><p class="empty">No data yet.</p><?php else: ?>
            <table>
                <thead><tr><th>Country</th><th class="num">Views</th></tr></thead>
                <tbody>
                <?php foreach (cps_top($countries, 10) as $c => $n): ?>
                    <tr><td><?php echo h($c); ?></td><td class="num"><?php echo number_format($n); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

    <p class="muted" style="margin-top:30px;font-size:0.8rem;">
        Country requires Cloudflare in front of the site (CF-IPCountry header); shows XX otherwise.
    </p>
</div>
</body>
</html>
