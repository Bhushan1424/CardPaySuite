<?php include '../includes/header.php'; ?>

<div class="container">

<h1>Card Test Numbers & Generator</h1>
<p>Generate valid card numbers for QA testing using the Luhn algorithm.</p>

<br>

<label><strong>Select Card Brand</strong></label>

<select id="brand" style="padding:8px;margin-left:10px;">
<option value="visa">Visa</option>
<option value="mastercard">Mastercard</option>
<option value="amex">American Express</option>
<option value="discover">Discover</option>
</select>

<hr style="margin:20px 0;">

<h3>Static Test Cards</h3>

<div id="staticCards"></div>

<hr style="margin:20px 0;">

<h3>Generate New Card</h3>

<button onclick="generateCard()" style="padding:10px 16px;">Generate Card</button>

<br><br>

<div id="generatedCard"></div>

</div>

<script>

const cards = {

visa: [
"4111 1111 1111 1111",
"4000 0566 5566 5556",
"4000 0000 0000 0002"
],

mastercard: [
"5555 5555 5555 4444",
"5200 8282 8282 8210"
],

amex: [
"3782 822463 10005",
"3714 496353 98431"
],

discover: [
"6011 1111 1111 1117"
]

};


function showStatic(){

let brand = document.getElementById("brand").value;

let list = cards[brand];

let html = "";

list.forEach(function(card){

html += `
<div style="display:flex;align-items:center;margin:8px 0;font-family:monospace;font-size:16px;">
<span style="flex:1;">${card}</span>
<button onclick="copyText('${card}')" style="padding:4px 8px;font-size:12px;">Copy</button>
</div>
`;

});

document.getElementById("staticCards").innerHTML = html;

}



function generateCard(){

let brand = document.getElementById("brand").value;

let prefix = "";
let length = 16;

if(brand=="visa") prefix="4";

if(brand=="mastercard"){
let prefixes = ["51","52","53","54","55"];
prefix = prefixes[Math.floor(Math.random()*prefixes.length)];
}

if(brand=="amex"){
prefix="34";
length=15;
}

if(brand=="discover") prefix="6011";


let number = prefix;

while(number.length < length-1){

number += Math.floor(Math.random()*10);

}

number += luhnCheckDigit(number);


let formatted = formatCard(number);


document.getElementById("generatedCard").innerHTML = `
<div style="display:flex;align-items:center;font-family:monospace;font-size:18px;">
<span style="flex:1;">${formatted}</span>
<button onclick="copyText('${formatted}')" style="padding:5px 10px;">Copy</button>
</div>
`;

}



function formatCard(number){

return number.replace(/(.{4})/g,'$1 ').trim();

}



function luhnCheckDigit(number){

let sum = 0;
let alt = true;

for(let i=number.length-1;i>=0;i--){

let n = parseInt(number.charAt(i));

if(alt){
n *= 2;
if(n>9) n -= 9;
}

sum += n;
alt = !alt;

}

return (10-(sum%10))%10;

}



function copyText(text){

navigator.clipboard.writeText(text);

}



document.getElementById("brand").addEventListener("change", showStatic);

showStatic();

</script>

<?php include '../includes/footer.php'; ?>