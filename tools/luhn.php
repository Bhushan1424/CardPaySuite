<?php
$pageTitle = 'Luhn Validator';
$pageDescription = 'Check whether a card number passes the Luhn checksum algorithm used to catch mistyped card numbers.';
include '../includes/header.php';
?>


<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">
            
            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">Luhn Validator</h1>
                <p class="tools-subtitle">Verify the mathematical validity of card numbers using the Luhn Algorithm (Mod 10). Essential for QA and payment gateway testing.</p>
            </header>

            <!-- MAIN TOOL INTERFACE -->
            <div class="tool-main-container" style="max-width: 500px; margin: 0 auto;">
                
                <!-- INPUT PANEL -->
                <div class="glass-panel tool-input-card">
                    <div class="tool-card-header">
                        <i class="fa-solid fa-shield-check"></i>
                        <span>Card Number Validation</span>
                    </div>
                    
                    <div class="tool-input-group">
                        <input type="text" id="card" placeholder="Enter card number..." maxlength="19">
                        <button onclick="validateLuhn()" id="checkBtn" class="btn-primary">
                            <span id="btnText">Validate</span>
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </div>
                    <p class="input-hint">Spaces and dashes are automatically removed.</p>
                </div>

                <!-- RESULT PANEL (Hidden by default) -->
                <div id="resPanel" class="glass-panel luhn-result-card" style="display: none; margin-top: 20px; text-align: center;">
                    <div id="resIcon" class="result-icon"></div>
                    <h2 id="resTitle" style="margin: 15px 0 5px 0; font-size: 1.5rem;"></h2>
                    <p id="resMsg" class="tools-subtitle" style="margin-bottom: 0;"></p>
                </div>

                <!-- ERROR MESSAGE -->
                <div id="errorMsg" class="error-banner" style="display: none;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span id="errorText">Please enter a valid card number.</span>
                </div>

            </div>
        </div>
    </section>
</div>


<!-- Shared Luhn utility (window.CardPay) -->
<script src="/assets/js/luhn.js"></script>
<script>
function validateLuhn() {
    const cardInput = document.getElementById("card");
    const resPanel = document.getElementById("resPanel");
    const resIcon = document.getElementById("resIcon");
    const resTitle = document.getElementById("resTitle");
    const resMsg = document.getElementById("resMsg");
    const errorMsg = document.getElementById("errorMsg");

    let num = cardInput.value.replace(/\D/g, '');

    // 1. Basic Validation
    if (num.length < 13 || num.length > 19) {
        errorMsg.style.display = "flex";
        resPanel.style.display = "none";
        document.getElementById("errorText").innerText = "Please enter a valid card number (13-19 digits).";
        return;
    }

    errorMsg.style.display = "none";

    // 2. Validate via the shared Luhn utility
    const isValid = CardPay.luhnValid(num);

    // 3. UI Update
    resPanel.style.display = "block";

    if (isValid) {
        resIcon.className = "result-icon icon-valid";
        resIcon.innerHTML = '<i class="fa-solid fa-check"></i>';
        resTitle.innerText = "Valid Card Number";
        resTitle.style.color = "var(--status-success)";
        resMsg.innerText = "The number passes the Luhn checksum validation.";
    } else {
        resIcon.className = "result-icon icon-invalid";
        resIcon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        resTitle.innerText = "Invalid Card Number";
        resTitle.style.color = "var(--status-error)";
        resMsg.innerText = "The number failed the Luhn checksum validation.";
    }
}
</script>

<?php include '../includes/footer.php'; ?>
