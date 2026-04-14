<?php include '../includes/header.php'; ?>

<div class="container">

<h1>BIN Lookup</h1>
<p>Identify card issuer and network</p>

<form method="GET">

<input 
type="text"
name="bin"
id="cardInput"
maxlength="19"
inputmode="numeric"
placeholder="Enter card number"
value="<?php echo isset($_GET['bin']) ? htmlspecialchars($_GET['bin']) : ''; ?>"
style="width:100%;padding:12px;margin-top:20px;"
required
>

<button style="margin-top:10px;padding:10px 16px;">Lookup</button>

</form>

<?php

if(isset($_GET['bin'])){

$bin = preg_replace('/[^0-9]/','', $_GET['bin']);

if(strlen($bin) < 6){

echo "<p style='color:red;margin-top:15px;'>Please enter at least 6 digits.</p>";

}else{

$url = "https://bins.antipublic.cc/bins/".$bin;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response,true);

if($data && isset($data['brand'])){

$brand = strtolower($data['brand'] ?? 'default');
$type = strtoupper($data['type'] ?? 'N/A');
$bank = $data['bank'] ?? 'N/A';
$country = $data['country_name'] ?? 'N/A';

$logo = "/assets/img/cards/".$brand.".svg";

if(!file_exists($_SERVER['DOCUMENT_ROOT'].$logo)){
$logo = "/assets/img/cards/default.png";
}

echo "<div style='margin-top:25px;background:white;border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;gap:30px;'>";

echo "<div style='width:180px;background:#f8fafc;border-radius:10px;display:flex;align-items:center;justify-content:center;padding:35px;'>";

echo "<img src='".$logo."' style='height:80px;max-width:100%;'>";
echo "</div>";

echo "<div style='flex:1;'>";

echo "<div style='display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #e5e7eb;'>";
echo "<span style='font-weight:600;'>Card Type</span>";
echo "<span style='background:#e0f2fe;color:#0369a1;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:600;'>".$type."</span>";
echo "</div>";

echo "<div style='display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #e5e7eb;'>";
echo "<span style='font-weight:600;'>Bank</span>";
echo "<span>".$bank."</span>";
echo "</div>";

echo "<div style='display:flex;justify-content:space-between;padding:12px 0;'>";
echo "<span style='font-weight:600;'>Country</span>";
echo "<span>".$country."</span>";
echo "</div>";

echo "</div>";

echo "</div>";

}else{

echo "<p style='margin-top:15px;'>No data found for this BIN.</p>";

}

}

}

?>

</div>

<?php include '../includes/footer.php'; ?>