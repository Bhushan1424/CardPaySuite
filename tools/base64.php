<?php include '../includes/header.php'; ?>

<div class="container">

<h1>Base64 Encoder / Decoder</h1>
<p>Convert text to Base64 and decode Base64 back to text</p>

<div style="display:flex;gap:20px;margin-top:20px;align-items:center;flex-wrap:wrap;">

<!-- INPUT -->
<div style="flex:1;min-width:320px;">
<h3>Input</h3>

<textarea id="inputText"
style="width:100%;height:220px;padding:12px;border:1px solid #e5e7eb;border-radius:8px;resize:none;"
placeholder="Enter text or Base64 here"></textarea>

</div>


<!-- BUTTON COLUMN -->
<div style="width:120px;display:flex;flex-direction:column;gap:10px;align-items:center;justify-content:center;">

<button onclick="encodeBase64()">Encode</button>

<button onclick="decodeBase64()">Decode</button>

<button onclick="clearFields()">Clear</button>

</div>


<!-- OUTPUT -->
<div style="flex:1;min-width:320px;">
<h3>Output</h3>

<div style="position:relative;">

<textarea id="outputText"
style="width:100%;height:220px;padding:12px;border:1px solid #e5e7eb;border-radius:8px;resize:none;"
placeholder="Result will appear here"></textarea>

<button onclick="copyResult()"
style="
position:absolute;
top:8px;
right:8px;
padding:6px 10px;
font-size:12px;
border:1px solid #d1d5db;
border-radius:6px;
background:white;
cursor:pointer;
">
Copy
</button>

</div>

</div>

</div>

</div>

<script>

function encodeBase64(){

let input = document.getElementById("inputText").value;

try{
document.getElementById("outputText").value = btoa(input);
}catch(e){
alert("Encoding failed. Check your input.");
}

}

function decodeBase64(){

let input = document.getElementById("inputText").value;

try{
document.getElementById("outputText").value = atob(input);
}catch(e){
alert("Invalid Base64 string.");
}

}

function copyResult(){

let output = document.getElementById("outputText");

output.select();
document.execCommand("copy");

alert("Copied to clipboard");

}

function clearFields(){

document.getElementById("inputText").value="";
document.getElementById("outputText").value="";

}

</script>

<?php include '../includes/footer.php'; ?>