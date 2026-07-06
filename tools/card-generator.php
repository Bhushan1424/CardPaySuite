<?php
$pageTitle = 'Test Card Generator';
$pageDescription = 'Generate Luhn-valid test card numbers for development and QA. For testing only — these are not real, chargeable cards.';
include '../includes/header.php';
?>


<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">
            
            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">Test Card Generator</h1>
                <p class="tools-subtitle">Generate mathematically valid card numbers for QA testing and payment gateway integration using the Luhn algorithm.</p>
            </header>

            <div class="tool-main-container" style="max-width: 800px; margin: 0 auto;">
                
                <!-- TOP CONTROL PANEL -->
                <div class="glass-panel tool-control-card">
                    <div class="control-flex">
                        <div class="control-group">
                            <label>Select Card Brand</label>
                            <!-- FIXED: Using the exact same mode-select style as Base64 tool -->
                            <select id="brand" class="mode-select">
                                <option value="visa">Visa</option>
                                <option value="mastercard">Mastercard</option>
                                <option value="amex">American Express</option>
                                <option value="discover">Discover</option>
                            </select>
                        </div>
                        <button onclick="generateCard()" id="genBtn" class="btn-primary">
                            <span id="btnText">Generate</span>
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </button>
                    </div>
                </div>

                <!-- VIRTUAL CARD DISPLAY -->
                <div class="card-visual-container">
                    <div id="virtualCard" class="virtual-card visa">
                        <div class="card-inner">
                            <div class="card-top">
                                <div class="chip"></div>
                                <div class="brand-logo" id="cardLogo">Visa</div>
                            </div>
                            <div class="card-number" id="displayNumber">4111 1111 1111 1111</div>
                            <div class="card-bottom">
                                <div class="bottom-group">
                                    <span class="label">Card Holder</span>
                                    <span class="value">JOHN DOE</span>
                                </div>
                                <div class="bottom-group">
                                    <span class="label">Expires</span>
                                    <span class="value">12/28</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button onclick="copyCurrentCard()" class="btn-console">
                            <i class="fa-solid fa-copy"></i> Copy Number
                        </button>
                    </div>
                </div>

                <!-- STATIC CARDS SECTION -->
                <div class="static-cards-section">
                    <h3 class="section-label" style="text-align: center; margin-bottom: 20px;">Quick Test Cards</h3>
                    <div id="staticCards" class="static-grid">
                        <!-- Injected by JS -->
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>


<!-- Shared Luhn utility (window.CardPay) -->
<script src="/assets/js/luhn.js"></script>
<script>
const cardsData = {
    visa: ["4111 1111 1111 1111", "4000 0566 5566 5556", "4000 0000 0000 0002"],
    mastercard: ["5555 5555 5555 4444", "5200 8282 8282 8210"],
    amex: ["3782 822463 10005", "3714 496353 98431"],
    discover: ["6011 1111 1111 1117"]
};

function showStatic() {
    const brand = document.getElementById("brand").value;
    const list = cardsData[brand];
    let html = "";

    list.forEach(card => {
        html += `
            <div class="static-card-item" onclick="useStaticCard('${card}')">
                <span>${card}</span>
                <span class="copy-badge">Click to Use</span>
            </div>`;
    });

    document.getElementById("staticCards").innerHTML = html;
}

function useStaticCard(card) {
    document.getElementById("displayNumber").innerText = card;
    const brand = document.getElementById("brand").value;
    updateCardVisuals(brand);
}

function generateCard() {
    const brand = document.getElementById("brand").value;
    let prefix = "";
    let length = 16;

    if(brand === "visa") prefix = "4";
    else if(brand === "mastercard") {
        const prefixes = ["51","52","53","54","55"];
        prefix = prefixes[Math.floor(Math.random()*prefixes.length)];
    }
    else if(brand === "amex") {
        prefix = "34";
        length = 15;
    }
    else if(brand === "discover") prefix = "6011";

    let number = prefix;
    while(number.length < length - 1) {
        number += Math.floor(Math.random()*10);
    }
    number += CardPay.luhnCheckDigit(number);

    const formatted = formatCard(number);
    document.getElementById("displayNumber").innerText = formatted;
    updateCardVisuals(brand);
}

function updateCardVisuals(brand) {
    const cardEl = document.getElementById("virtualCard");
    const logoEl = document.getElementById("cardLogo");
    cardEl.className = `virtual-card ${brand}`;
    logoEl.innerText = brand.charAt(0).toUpperCase() + brand.slice(1);
}

function formatCard(number) {
    return number.replace(/(.{4})/g, '$1 ').trim();
}

function copyCurrentCard() {
    const text = document.getElementById("displayNumber").innerText;
    navigator.clipboard.writeText(text);
    alert("Card number copied to clipboard!");
}

document.getElementById("brand").addEventListener("change", () => {
    showStatic();
    generateCard();
});

showStatic();
generateCard();
</script>

<?php include '../includes/footer.php'; ?>
