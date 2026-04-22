<?php include 'includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

<div class="page-wrapper">
    <section class="news-page-section">
        <div class="container">
            
            <!-- HEADER SECTION -->
            <header class="news-header">
                <h1 class="text-gradient">Fintech News Radar</h1>
                <p class="news-subtitle">Stay updated with the latest in global payments, ISO standards, and digital banking innovation.</p>
                
                <!-- LIVE INDICATOR -->
                <div class="live-indicator">
                    <span class="pulse-dot"></span>
                    <span>Live Feed</span>
                </div>
            </header>

            <?php
            $apiKey = "936c49b4ac4bdc0318b0b1eead197028";
            $cacheFile = "cache/news.json";
            $cacheTime = 1200; // 20 minutes

            /* ---------- LOAD CACHE OR API ---------- */
            if(file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)){
                $data = json_decode(file_get_contents($cacheFile), true);
            } else {
                $query = urlencode('fintech OR payments OR banking OR "digital payments" OR mastercard OR visa');
                $url = "https://gnews.io/api/v4/search?q=".$query."&lang=en&max=10&token=".$apiKey;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);

                if(isset($data['articles'])){
                    file_put_contents($cacheFile, $response);
                }
            }

            /* ---------- DISPLAY NEWS GRID ---------- */
            if(isset($data['articles']) && !empty($data['articles'])): ?>
                
                <div class="news-grid">
                    <?php foreach($data['articles'] as $article): 
                        $title = $article['title'] ?? 'Untitled Article';
                        $link = $article['url'] ?? '#';
                        $desc = $article['description'] ?? 'No description available for this article.';
                        $source = $article['source']['name'] ?? 'Unknown Source';
                        $date = date("M d, Y", strtotime($article['publishedAt']));
                        $image = $article['image'] ?? "/assets/news-default.png";
                    ?>
                        
                        <div class="news-card glass-panel">
                            <div class="news-image-wrapper">
                                <img src="<?php echo $image; ?>" alt="News Image" onerror="this.src='/assets/news-default.png'">
                                <div class="source-badge"><?php echo $source; ?></div>
                            </div>
                            
                            <div class="news-content">
                                <div class="news-date"><?php echo $date; ?></div>
                                <h3 class="news-title"><?php echo $title; ?></h3>
                                <p class="news-excerpt"><?php echo $desc; ?></p>
                                
                                <a href="<?php echo $link; ?>" target="_blank" class="btn-read-more">
                                    Read Article <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="no-news-alert glass-panel">
                    <i class="fa-solid fa-satellite-dish"></i>
                    <p>Our news radar is currently searching for updates. Please check back shortly!</p>
                </div>
            <?php endif; ?>

        </div>
    </section>
</div>

<style>
    /* --- Page Layout --- */
    .page-wrapper {
        min-height: calc(100vh - 160px);
        display: flex;
        flex-direction: column;
    }

    .news-page-section {
        padding: 80px 0;
        color: var(--text-main);
    }

    .news-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .news-header h1 {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .news-subtitle {
        font-size: 1.1rem;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto 20px;
    }

    .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0, 0, 0, 0.3);
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.75rem;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    /* --- News Grid --- */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }

    .news-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--border-color);
        cursor: pointer;
    }

    .news-card:hover {
        transform: translateY(-10px);
        border-color: var(--accent-primary);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    /* Image Section */
    .news-image-wrapper {
        position: relative;
        width: 100%;
        height: 180px;
        overflow: hidden;
    }

    .news-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-card:hover img {
        transform: scale(1.1);
    }

    .source-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--accent-primary);
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 5px;
        text-transform: uppercase;
    }

    /* Content Section */
    .news-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .news-date {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .news-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-bright);
        line-height: 1.4;
        margin: 0;
    }

    .news-excerpt {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-read-more {
        margin-top: 15px;
        color: var(--accent-primary);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }

    .btn-read-more:hover {
        color: var(--accent-secondary);
        transform: translateX(5px);
    }

    /* Error/Empty State */
    .no-news-alert {
        text-align: center;
        padding: 50px;
        color: var(--text-muted);
    }

    .no-news-alert i {
        display: block;
        font-size: 3rem;
        margin-bottom: 20px;
        color: var(--accent-primary);
    }

    @media (max-width: 768px) {
        .news-grid { grid-template-columns: 1fr; }
        .news-header h1 { font-size: 2.2rem; }
    }
</style>
