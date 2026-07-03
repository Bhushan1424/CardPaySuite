<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Pay Suite</title>

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
