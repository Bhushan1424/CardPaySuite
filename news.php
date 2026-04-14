<?php include 'includes/header.php'; ?>

<div class="container">

<h1>Fintech & Payments News</h1>
<p>Stay updated with the latest fintech, payments, and card payments industry news.</p>

<hr style="margin:20px 0;">

<?php

$apiKey = "936c49b4ac4bdc0318b0b1eead197028";

$cacheFile = "cache/news.json";
$cacheTime = 1200; // 20 minutes


/* ---------- LOAD CACHE OR API ---------- */

if(file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)){

    $data = json_decode(file_get_contents($cacheFile), true);

}else{

$query = urlencode('fintech OR payments OR banking OR "digital payments" OR mastercard OR visa');

$url = "https://gnews.io/api/v4/search?q=".$query."&lang=en&max=10&token=".$apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response,true);

/* Cache only if API returned articles */

if(isset($data['articles'])){
file_put_contents($cacheFile,$response);
}

}


/* ---------- DISPLAY NEWS ---------- */

if(isset($data['articles'])){

foreach($data['articles'] as $article){

$title = $article['title'] ?? '';
$link = $article['url'] ?? '#';
$desc = $article['description'] ?? '';
$source = $article['source']['name'] ?? 'Unknown';

$date = date("M d, Y",strtotime($article['publishedAt']));

$image = $article['image'] ?? "/assets/news-default.png";

echo "<div style='display:flex;gap:20px;padding:18px 0;border-bottom:1px solid #e5e7eb;align-items:center;'>";

echo "<div style='flex:1;'>";

echo "<a href='".$link."' target='_blank'
style='font-size:18px;font-weight:600;color:#1a0dab;text-decoration:none;'>".$title."</a>";

echo "<p style='margin:6px 0;color:#4b5563;'>".$desc."</p>";

echo "<div style='font-size:13px;color:#6b7280;'>".$source." • ".$date."</div>";

echo "</div>";

echo "<img src='".$image."'
style='width:120px;height:80px;object-fit:cover;border-radius:8px;'
onerror=\"this.src='/assets/news-default.png'\">";

echo "</div>";

}

}else{

echo "<p>No news articles available right now.</p>";

}

?>

</div>

<?php include 'includes/footer.php'; ?>