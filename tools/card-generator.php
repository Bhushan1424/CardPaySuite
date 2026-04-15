<?php include '../includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">
            
            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">Card Test Generator</h1>
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
                            <span id="btnText">Generate New Card</span>
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

<style>
    /* --- Page Layout --- */
    .page-wrapper {
        min-height: calc(100vh - 160px);
        display: flex;
        flex-direction: column;
    }

    .tools-page-section {
        padding: 80px 0;
        color: var(--text-main);
    }

    .tool-main-container {
        animation: fadeInUp 0.5s ease-out;
    }

    .tool-control-card {
        padding: 20px;
        border-radius: 20px;
        margin-bottom: 40px;
    }

    .control-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .control-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .control-group label {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    /* FIXED: Dropdown styling to match Base64 tool exactly */
    .mode-select {
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid var(--border-color);
        color: white;
        padding: 8px 15px;
        border-radius: 10px;
        font-size: 0.9rem;
        cursor: pointer;
        outline: none;
        transition: var(--transition);
    }
    .mode-select:focus {
        border-color: var(--accent-primary);
        box-shadow: 0 0 10px var(--accent-glow);
    }

    /* --- Virtual Card Design --- */
    .card-visual-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin-bottom: 60px;
    }

    .virtual-card {
        width: 400px;
        height: 250px;
        border-radius: 24px;
        position: relative;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .card-inner {
        width: 100%;
        height: 100%;
        border-radius: 24px;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: white;
        box-sizing: border-box;
    }

    /* Brand Colors */
    .virtual-card.visa { background: linear-gradient(135deg, #1a1f71 0%, #003f5c 100%); }
    .virtual-card.mastercard { background: linear-gradient(135deg, #eb001b 0%, #cf8000 100%); }
    .virtual-card.amex { background: linear-gradient(135deg, #0072a3 0%, #003f5c 100%); }
    .virtual-card.discover { background: linear-gradient(135deg, #f68121 0%, #d64d00 100%); }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .chip {
        width: 50px;
        height: 38px;
        background: linear-gradient(135deg, #fcd34d, #b45309);
        border-radius: 8px;
        position: relative;
    }

    .brand-logo {
        font-size: 1.5rem;
        font-weight: 800;
        font-style: italic;
        text-transform: uppercase;
    }

    .card-number {
        font-family: 'Courier New', monospace;
        font-size: 1.8rem;
        letter-spacing: 4px;
        text-align: center;
        margin: 40px 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    /* FIXED: Alignment of bottom elements */
    .card-bottom {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        width: 100%;
    }

    .bottom-group {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .bottom-group .label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.7;
        margin-bottom: 4px;
    }

    .bottom-group .value {
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* --- Static Cards Grid --- */
    .static-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .static-card-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        padding: 12px 20px;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
        cursor: pointer;
    }

    .static-card-item:hover {
        background: rgba(99, 102, 241, 0.1);
        border-color: var(--accent-primary);
        transform: translateX(5px);
    }

    .static-card-item span {
        font-family: 'Courier New', monospace;
        font-size: 1rem;
        color: var(--text-main);
    }

    .copy-badge {
        font-size: 0.7rem;
        background: var(--bg-surface);
        padding: 4px 8px;
        border-radius: 6px;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    @media (max-width: 480px) {
        .virtual-card { width: 300px; height: 190px; }
        .card-number { font-size: 1.3rem; }
    }
</style>

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
    number += luhnCheckDigit(number);

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

function luhnCheckDigit(number) {
    let sum = 0;
    let alt = true;
    for(let i=number.length-1; i>=0; i--) {
        let n = parseInt(number.charAt(i));
        if(alt) { n *= 2; if(n>9) n -= 9; }
        sum += n;
        alt = !alt;
    }
    return (10 - (sum % 10)) % 10;
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
