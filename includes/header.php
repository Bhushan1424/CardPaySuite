<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Pay Suite</title>

    <!-- Use Absolute Path (starting with /) so it works on all pages -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    
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

<style>
    /* Quick Header-Specific Polish to make the nav look professional */
    .site-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 15px 0;
        border-bottom: 1px solid var(--border-color);
    }
    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .logo {
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .menu {
        display: flex;
        gap: 20px;
    }
    .nav-link {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nav-link:hover {
        color: var(--accent-primary);
    }

    @media (max-width: 640px) {
        .nav-container {
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }
        .menu {
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px 16px;
        }
        .nav-link {
            font-size: 0.85rem;
        }
    }
</style>
