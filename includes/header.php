<?php
// Bootstrap shared config + libs. header.php is the single global include, so the
// analytics tag (and config for proxy rate limiting) is loaded here once for every page.
require_once __DIR__ . '/bootstrap.php';

/*
    ---------- PER-PAGE SEO ----------
    Pages set $pageTitle / $pageDescription (and optionally $pageImage) BEFORE
    including this file; anything unset falls back to the site defaults below.

        <?php
        $pageTitle = 'ISO 8583 Parser';
        $pageDescription = 'Decode card authorization messages...';
        include 'includes/header.php';
        ?>
*/
$siteName = 'CardPay Suite';
$baseUrl  = isset($site_config['base_url']) ? $site_config['base_url'] : '';

// Title: page title prefixed onto the brand; home page uses the brand tagline alone.
$defaultTitle = 'CardPay Suite — Learn Payment Processing: ISO 8583, EMV & Fintech Tools';
$pageTitle = isset($pageTitle) && $pageTitle !== ''
    ? $pageTitle . ' | ' . $siteName
    : $defaultTitle;

$defaultDescription = 'CardPay Suite is a free interactive learning platform for payment processing. '
    . 'Explore ISO 8583, EMV TLV, and ISO 20022 with guides, a transaction simulator, and developer tools.';
$metaDescription = isset($pageDescription) && $pageDescription !== ''
    ? $pageDescription
    : $defaultDescription;

// Absolute canonical URL for this request (strip query string so paginated/param
// variants collapse to one canonical page).
$requestPath = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$requestPath = strtok($requestPath, '?');
$canonicalUrl = $baseUrl . $requestPath;

// Social share image (absolute). PNG is the default because Facebook/LinkedIn/X
// don't reliably render SVG og:image (the .svg is kept as the editable source).
// Pages may override with $pageImage.
$ogImage = $baseUrl . (isset($pageImage) && $pageImage !== '' ? $pageImage : '/assets/img/og-image.png');

// Escape everything once for safe attribute output.
$e_title       = htmlspecialchars($pageTitle, ENT_QUOTES);
$e_description  = htmlspecialchars($metaDescription, ENT_QUOTES);
$e_canonical    = htmlspecialchars($canonicalUrl, ENT_QUOTES);
$e_ogImage      = htmlspecialchars($ogImage, ENT_QUOTES);
$e_siteName     = htmlspecialchars($siteName, ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (!empty($analytics_config['ga_measurement_id'])):
        $gaId = htmlspecialchars($analytics_config['ga_measurement_id'], ENT_QUOTES); ?>
    <!-- GA4 id for the consent-gated loader in includes/consent-banner.php.
         gtag.js is loaded ONLY after the visitor accepts cookies (no GA cookies before then). -->
    <script>window.CPS_GA_ID = "<?php echo $gaId; ?>";</script>
    <?php endif; ?>

    <!-- ---------- SEO / social meta ---------- -->
    <title><?php echo $e_title; ?></title>
    <meta name="description" content="<?php echo $e_description; ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $e_canonical; ?>">

    <!-- Open Graph (Facebook, LinkedIn, Slack, etc.) -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo $e_siteName; ?>">
    <meta property="og:title" content="<?php echo $e_title; ?>">
    <meta property="og:description" content="<?php echo $e_description; ?>">
    <meta property="og:url" content="<?php echo $e_canonical; ?>">
    <meta property="og:image" content="<?php echo $e_ogImage; ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $e_title; ?>">
    <meta name="twitter:description" content="<?php echo $e_description; ?>">
    <meta name="twitter:image" content="<?php echo $e_ogImage; ?>">

    <!-- Structured data: identify the site to search engines.
         Built with json_encode from the RAW values (not the HTML-escaped ones):
         browsers don't decode HTML entities inside a <script> block, so escaping
         here would corrupt the JSON. JSON_HEX_TAG guards against a stray </script>. -->
    <script type="application/ld+json">
    <?php echo json_encode(array(
        '@context'    => 'https://schema.org',
        '@type'       => 'WebSite',
        'name'        => $siteName,
        'url'         => $baseUrl,
        'description' => $metaDescription
    ), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_PRETTY_PRINT); ?>
    </script>

    <!-- Favicons: SVG for modern browsers, .ico fallback (16/32/48), touch icon for iOS -->
    <link rel="icon" type="image/svg+xml" href="/assets/img/favicon.svg">
    <link rel="alternate icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">

    <!-- Global stylesheets (absolute paths so they resolve on every page depth) -->
    <!-- style.css = tokens + primitives + site chrome; components.css = shared page/tool/docs patterns -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/assets/css/components.css?v=<?php echo time(); ?>">
    <!-- AI guide widget is injected on every page by footer.php, so its styles load globally too -->
    <link rel="stylesheet" href="/assets/css/ai-guide.css?v=<?php echo time(); ?>">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body> <!-- IMPORTANT: This was missing! -->

<header class="site-header glass-panel">
    <div class="container nav-container">
        <div class="logo text-gradient">
            <i class="fa-solid fa-credit-card"></i> Card Pay Suite
        </div>

        <nav class="menu">
            <a href="/index.php" class="nav-link"><i class="fa-solid fa-house"></i> Home</a>
            <a href="/tools/index.php" class="nav-link"><i class="fa-solid fa-screwdriver-wrench"></i> Tools</a>
            <a href="/docs/index.php" class="nav-link"><i class="fa-solid fa-book"></i> Learn</a>
            <a href="/news.php" class="nav-link"><i class="fa-solid fa-newspaper"></i> News</a>
        </nav>
    </div>
</header>
