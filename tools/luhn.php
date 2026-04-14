<?php include '../includes/header.php'; ?>

<div class="container">

<h1>Luhn Validator</h1>
<p>Validate card numbers using the Luhn algorithm</p>

<form method="GET">

<input 
type="text"
name="card"
id="cardInput"
maxlength="19"
inputmode="numeric"
placeholder="Enter card number"
value="<?php echo isset($_GET['card']) ? htmlspecialchars($_GET['card']) : ''; ?>"
style="width:100%;padding:12px;margin-top:20px;"
required
>

<button style="margin-top:10px;padding:10px 16px;">Validate</button>

</form>

<?php

function calculateCheckDigit($number){

$sum = 0;
$alt = true;

for($i = strlen($number)-1; $i >= 0; $i--){

$n = intval($number[$i]);

if($alt){

$n *= 2;

if($n > 9){
$n -= 9;
}

}

$sum += $n;
$alt = !$alt;

}

return (10 - ($sum % 10)) % 10;

}

function luhnCheck($number){

$sum = 0;
$alt = false;

for($i = strlen($number)-1; $i >= 0; $i--){

$n = intval($number[$i]);

if($alt){

$n *= 2;

if($n > 9){
$n -= 9;
}

}

$sum += $n;
$alt = !$alt;

}

return ($sum % 10 == 0);
}

if(isset($_GET['card'])){

$card = preg_replace('/[^0-9]/','', $_GET['card']);

if(strlen($card) < 12){

echo "<p style='color:red;margin-top:15px;'>Please enter a valid card number.</p>";

}else{

$isValid = luhnCheck($card);

echo "<div style='margin-top:25px;background:white;border:1px solid #e5e7eb;border-radius:12px;padding:20px;'>";

if($isValid){

echo "<div style='display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #e5e7eb;'>";

echo "<span style='font-weight:600;'>Result</span>";

echo "<span style='font-weight:700;color:#16a34a;'>VALID ✔</span>";

echo "</div>";

}else{

$body = substr($card,0,-1);

$expected = calculateCheckDigit($body);

$entered = substr($card,-1);

echo "<div style='display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #e5e7eb;'>";

echo "<span style='font-weight:600;'>Result</span>";

echo "<span style='font-weight:700;color:#dc2626;'>INVALID ✖</span>";

echo "</div>";

echo "<div style='padding:12px 0;'>";

echo "The card number appears invalid.<br>";

echo "The last digit should be <strong>$expected</strong> instead of <strong>$entered</strong>.";

echo "</div>";


}

echo "</div>";

}

}

?>

</div>

<script>

document.getElementById("cardInput").addEventListener("input", function(e){

let value = e.target.value.replace(/\D/g, "");

value = value.substring(0,16);

value = value.replace(/(.{4})/g, "$1 ").trim();

e.target.value = value;

});

</script>

<?php include '../includes/footer.php'; ?>