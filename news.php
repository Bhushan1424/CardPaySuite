<?php include 'includes/header.php'; ?>


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
            include 'config.php';
            $apiKey = $news_config['gnews_api_key'];
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
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="News Image" onerror="this.src='/assets/news-default.png'">
                                <div class="source-badge"><?php echo htmlspecialchars($source); ?></div>
                            </div>

                            <div class="news-content">
                                <div class="news-date"><?php echo htmlspecialchars($date); ?></div>
                                <h3 class="news-title"><?php echo htmlspecialchars($title); ?></h3>
                                <p class="news-excerpt"><?php echo htmlspecialchars($desc); ?></p>

                                <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" class="btn-read-more">
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

