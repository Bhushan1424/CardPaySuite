<?php include '../includes/header.php'; ?>


<!-- WRAPPER FOR STICKY FOOTER -->
<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">
            
            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">BIN Lookup</h1>
                <p class="tools-subtitle">Analyze Bank Identification Numbers (BIN) to identify card issuers, networks, and country of origin.</p>
            </header>

            <!-- MAIN TOOL INTERFACE -->
            <div class="tool-main-container" style="max-width: 600px; margin: 0 auto;">
                
                <!-- INPUT PANEL -->
                <div class="glass-panel tool-input-card">
                    <div class="tool-card-header">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Enter BIN Data</span>
                    </div>
                    
                    <div class="tool-input-group">
                        <input type="text" id="bin" placeholder="e.g. 456789" maxlength="8">
                        <button onclick="lookup()" id="lookupBtn" class="btn-primary">
                            <span id="btnText">Lookup BIN</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                    <p class="input-hint">Enter the first 6 to 8 digits of the card number.</p>
                </div>

                <!-- RESULT PANEL -->
                <div id="resultPanel" class="glass-panel result-card" style="display: none; margin-top: 20px;">
                    <div class="result-card-header">
                        <h3 style="margin:0;">Analysis Result</h3>
                        <span id="resultStatus" class="status-badge approved">Valid BIN</span>
                    </div>

                    <div class="result-grid">
                        <div class="result-item">
                            <span class="res-label">Scheme</span>
                            <span class="res-value" id="resScheme">-</span>
                        </div>
                        <div class="result-item">
                            <span class="res-label">Card Type</span>
                            <span class="res-value" id="resType">-</span>
                        </div>
                        <div class="result-item">
                            <span class="res-label">Issuer Bank</span>
                            <span class="res-value" id="resIssuer">-</span>
                        </div>
                        <div class="result-item">
                            <span class="res-label">Country</span>
                            <span class="res-value" id="resCountry">-</span>
                        </div>
                    </div>
                </div>

                <!-- ERROR MESSAGE -->
                <div id="errorMsg" class="error-banner" style="display: none;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span id="errorText">Invalid BIN or Network Error</span>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
async function lookup() {
    const binInput = document.getElementById("bin");
    const btn = document.getElementById("lookupBtn");
    const btnText = document.getElementById("btnText");
    const resultPanel = document.getElementById("resultPanel");
    const errorMsg = document.getElementById("errorMsg");
    
    let bin = binInput.value.trim();

    if (bin.length < 6) {
        showError("Please enter at least 6 digits.");
        return;
    }

    errorMsg.style.display = "none";
    resultPanel.style.display = "none";
    btn.disabled = true;
    btnText.innerText = "Searching...";

    try {
        // FIX: Changed path from /bin-proxy.php to ../bin-proxy.php
        let response = await fetch("../bin-proxy.php?bin=" + bin);
        
        if (!response.ok) {
            throw new Error(`Server Error: ${response.status} ${response.statusText}`);
        }
        
        let data = await response.json();

        if (data && (data.Scheme || data.Issuer)) {
            document.getElementById("resScheme").innerText = data.Scheme ?? "N/A";
            document.getElementById("resType").innerText = data.Type ?? "N/A";
            document.getElementById("resIssuer").innerText = data.Issuer ?? "N/A";
            document.getElementById("resCountry").innerText = data.Country?.Name ?? "N/A";
            resultPanel.style.display = "block";
        } else {
            showError("No data found for this BIN.");
        }
    } catch (error) {
        showError(error.message);
        console.error("BIN Lookup Error:", error);
    } finally {
        btn.disabled = false;
        btnText.innerText = "Lookup BIN";
    }
}

function showError(text) {
    const errorMsg = document.getElementById("errorMsg");
    const resultPanel = document.getElementById("resultPanel");
    resultPanel.style.display = "none";
    errorMsg.style.display = "flex";
    document.getElementById("errorText").innerText = text;
}
</script>

<?php include '../includes/footer.php'; ?>
