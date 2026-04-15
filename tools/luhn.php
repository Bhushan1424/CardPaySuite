<?php include '../includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

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

    .tool-input-card {
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .tool-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: var(--accent-primary);
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    .tool-input-group {
        display: flex;
        gap: 12px;
    }

    .tool-input-group input {
        flex: 1;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 14px;
        color: white;
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        transition: var(--transition);
    }

    .tool-input-group input:focus {
        outline: none;
        border-color: var(--accent-primary);
        box-shadow: 0 0 10px var(--accent-glow);
    }

    .input-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 12px;
    }

    /* --- Luhn Specific Result Card --- */
    .luhn-result-card {
        padding: 30px;
        animation: slideUp 0.3s ease-out;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .result-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        transition: var(--transition);
    }

    .icon-valid {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        box-shadow: 0 0 20px rgba(34, 197, 94, 0.4);
    }

    .icon-invalid {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
    }

    .error-banner {
        margin-top: 20px;
        background: rgba(248, 113, 113, 0.1);
        border: 1px solid #f87171;
        color: #f87171;
        padding: 12px;
        border-radius: 12px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

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

    // 2. Luhn Algorithm Implementation
    let sum = 0;
    let shouldDouble = false;

    for (let i = num.length - 1; i >= 0; i--) {
        let digit = parseInt(num[i]);

        if (shouldDouble) {
            digit *= 2;
            if (digit > 9) digit -= 9;
        }

        sum += digit;
        shouldDouble = !shouldDouble;
    }

    const isValid = (sum % 10 === 0);

    // 3. UI Update
    resPanel.style.display = "block";
    
    if (isValid) {
        resIcon.className = "result-icon icon-valid";
        resIcon.innerHTML = '<i class="fa-solid fa-check"></i>';
        resTitle.innerText = "Valid Card Number";
        resTitle.style.color = "#4ade80";
        resMsg.innerText = "The number passes the Luhn checksum validation.";
    } else {
        resIcon.className = "result-icon icon-invalid";
        resIcon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        resTitle.innerText = "Invalid Card Number";
        resTitle.style.color = "#f87171";
        resMsg.innerText = "The number failed the Luhn checksum validation.";
    }
}
</script>

<?php include '../includes/footer.php'; ?>
