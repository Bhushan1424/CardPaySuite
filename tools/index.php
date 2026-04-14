<?php include '../includes/header.php'; ?>

<div class="container">

<h1>Developer Tools</h1>

<div class="grid">

<a class="card" href="iso8583-parser.php">
<h3><i class="fas fa-network-wired"></i> ISO8583 Parser</h3>
<p>Decode card authorization messages</p>
</a>

<a class="card" href="tlv.php">
<h3><i class="fas fa-box-open"></i> TLV Parser</h3>
<p>Parse EMV TLV structures</p>
</a>

<a class="card" href="base64.php">
<h3><i class="fas fa-lock"></i> Base64 Tool</h3>
<p>Encode and decode Base64</p>
</a>

<a class="card" href="luhn.php">
<h3><i class="fas fa-check-circle"></i> Luhn Validator</h3>
<p>Validate card numbers</p>
</a>

<a class="card" href="bin-lookup.php">
<h3><i class="fas fa-university"></i> BIN Lookup</h3>
<p>Identify card issuer</p>
</a>

<a class="card" href="card-generator.php">
<h3><i class="fas fa-credit-card"></i> Card Generator</h3>
<p>Generate valid card numbers for QA testing</p>
</a>

</div>

</div>

<?php include '../includes/footer.php'; ?>