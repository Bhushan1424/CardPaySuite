<?php
// config.php
$ai_config = array(
    'groq_api_key' => getenv('GROQ_API_KEY') // Removed the extra semicolon here
);

$news_config = array(
    'gnews_api_key' => getenv('GNEWS_API_KEY')
);
?>
