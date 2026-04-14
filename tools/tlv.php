<?php include '../includes/header.php'; ?>

<div class="container">

<h1>EMV TLV Parser</h1>
<p>Parse EMV TLV structures</p>

<form method="POST">

<textarea name="tlv"
style="width:100%;height:180px;padding:12px;border:1px solid #e5e7eb;border-radius:8px;resize:none;"
placeholder="Paste TLV data here"><?php echo $_POST['tlv'] ?? ''; ?></textarea>

<div style="text-align:center;margin-top:15px;">
<button type="submit">Parse TLV</button>
</div>

</form>

<?php

function parseTLV($hex){

$hex = strtoupper(preg_replace('/[^0-9A-F]/','',$hex));

$i = 0;
$result = [];

while($i < strlen($hex)){

$tag = substr($hex,$i,2);
$i += 2;

if((hexdec($tag) & 0x1F) == 0x1F){

while(true){

$next = substr($hex,$i,2);
$tag .= $next;
$i += 2;

if(!(hexdec($next) & 0x80)){
break;
}

}

}

$lenByte = substr($hex,$i,2);
$i += 2;

if(hexdec($lenByte) > 127){

$bytes = hexdec($lenByte) - 128;
$lengthHex = substr($hex,$i,$bytes*2);
$i += $bytes*2;
$length = hexdec($lengthHex);

}else{

$length = hexdec($lenByte);

}

$value = substr($hex,$i,$length*2);
$i += $length*2;

$result[] = [
'tag'=>$tag,
'length'=>$length,
'value'=>$value
];

}

return $result;

}

if(isset($_POST['tlv']) && $_POST['tlv']!=''){

$dictionary = json_decode(file_get_contents('../data/emv-tags.json'), true);

$tagMap = [];

foreach($dictionary as $group){

foreach($group as $tag=>$desc){

$tagMap[$tag] = $desc;

}

}

$parsed = parseTLV($_POST['tlv']);

echo "<div style='margin-top:25px;background:white;border:1px solid #e5e7eb;border-radius:10px;padding:20px;'>";

echo "<table style='width:100%;border-collapse:collapse;'>";

echo "<tr style='border-bottom:1px solid #e5e7eb;font-weight:600;'>
<td>Tag</td>
<td>Length</td>
<td>Value</td>
<td>Description</td>
</tr>";

foreach($parsed as $row){

$desc = $tagMap[$row['tag']] ?? "Unknown Tag";

echo "<tr style='border-bottom:1px solid #f1f5f9;'>";

echo "<td>".$row['tag']."</td>";
echo "<td>".$row['length']."</td>";
echo "<td style='font-family:monospace;'>".$row['value']."</td>";
echo "<td>".$desc."</td>";

echo "</tr>";

}

echo "</table>";

echo "</div>";

}

?>

</div>

<?php include '../includes/footer.php'; ?>