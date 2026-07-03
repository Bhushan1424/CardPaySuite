<?php include '../includes/header.php'; ?>


<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">
            
            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">ISO 8583 Visual Parser</h1>
                <p class="tools-subtitle">Decode raw card authorization messages. Analyze MTI, Bitmaps, and Data Elements in real-time.</p>
            </header>

            <div class="tool-main-container" style="max-width: 900px; margin: 0 auto;">
                
                <!-- INPUT PANEL -->
                <div class="glass-panel tool-input-card">
                    <div class="tool-card-header">
                        <i class="fa-solid fa-microchip"></i>
                        <span>Raw Message Input</span>
                    </div>
                    
                    <div class="parser-input-area">
                        <textarea id="msg" placeholder="Paste raw hex or string message here... (e.g. 0200...)" rows="5"></textarea>
                        <button onclick="parseMessage()" id="parseBtn" class="btn-primary">
                            <span id="btnText">Analyze Message</span>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <p class="input-hint">Supports MTI + Primary Bitmap parsing for standard financial request messages.</p>
                </div>

                <!-- RESULT PANEL (Hidden by default) -->
                <div id="resultPanel" class="glass-panel result-card" style="display: none; margin-top: 30px;">
                    <div class="result-card-header">
                        <h3 style="margin:0;">Parsed Frame Analysis</h3>
                        <span class="status-badge approved">Decoded Successfully</span>
                    </div>

                    <!-- Header Info (MTI & Bitmap) -->
                    <div class="analysis-header-grid">
                        <div class="analysis-box">
                            <span class="res-label">Message Type (MTI)</span>
                            <span class="res-value" id="resMti">-</span>
                        </div>
                        <div class="analysis-box">
                            <span class="res-label">Primary Bitmap</span>
                            <span class="res-value" id="resBitmap">-</span>
                        </div>
                    </div>

                    <!-- Fields Table -->
                    <div class="fields-table-wrapper">
                        <table class="fields-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Description</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody id="fieldsBody">
                                <!-- JS will inject rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ERROR MESSAGE -->
                <div id="errorMsg" class="error-banner" style="display: none;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span id="errorText">Invalid ISO 8583 Format</span>
                </div>

            </div>
        </div>
    </section>
</div>


<script>
function parseMessage() {
    const msg = document.getElementById("msg").value.trim();
    const btn = document.getElementById("parseBtn");
    const btnText = document.getElementById("btnText");
    const resultPanel = document.getElementById("resultPanel");
    const errorMsg = document.getElementById("errorMsg");
    const fieldsBody = document.getElementById("fieldsBody");

    if (!msg) {
        showError("Please paste a message to parse.");
        return;
    }

    // UI Loading State
    errorMsg.style.display = "none";
    resultPanel.style.display = "none";
    btn.disabled = true;
    btnText.innerText = "Analyzing...";

    try {
        let pointer = 0;

        // 1. MTI Extraction
        if (msg.length < 4) throw new Error("Message too short for MTI");
        let mti = msg.substring(pointer, 4);
        pointer += 4;

        // 2. Bitmap Extraction
        if (msg.length < pointer + 16) throw new Error("Message too short for Bitmap");
        let bitmap = msg.substring(pointer, pointer + 16);
        pointer += 16;

        // UI Update Header
        document.getElementById("resMti").innerText = mti;
        document.getElementById("resBitmap").innerText = bitmap;

        // 3. Bitmap to Binary Conversion
        let bitmapBinary = "";
        for (let i = 0; i < bitmap.length; i++) {
            let hexDigit = parseInt(bitmap[i], 16);
            if (isNaN(hexDigit)) throw new Error("Invalid hex character in bitmap");
            bitmapBinary += hexDigit.toString(2).padStart(4, '0');
        }

        // 4. Field Parsing logic
        let fieldsHtml = "";
        let fieldsFound = 0;

        for (let i = 1; i <= 64; i++) {
            if (bitmapBinary[i - 1] === "1") {
                let fieldName = "Unknown Field";
                let fieldVal = "";

                switch (i) {
                    case 2:
                        fieldName = "Primary Account Number (PAN)";
                        let panLen = parseInt(msg.substring(pointer, pointer + 2)) || 0;
                        pointer += 2;
                        fieldVal = msg.substring(pointer, pointer + panLen);
                        pointer += panLen;
                        break;
                    case 3:
                        fieldName = "Processing Code";
                        fieldVal = msg.substring(pointer, pointer + 6);
                        pointer += 6;
                        break;
                    case 4:
                        fieldName = "Transaction Amount";
                        fieldVal = msg.substring(pointer, pointer + 12);
                        pointer += 12;
                        break;
                    case 7:
                        fieldName = "Transmission Date & Time";
                        fieldVal = msg.substring(pointer, pointer + 10);
                        pointer += 10;
                        break;
                    case 11:
                        fieldName = "Systems Trace Audit Number (STAN)";
                        fieldVal = msg.substring(pointer, pointer + 6);
                        pointer += 6;
                        break;
                    case 41:
                        fieldName = "Terminal Identification";
                        fieldVal = msg.substring(pointer, pointer + 8);
                        pointer += 8;
                        break;
                    default:
                        // Handle other fields as generic for now
                        fieldVal = "Length unknown / Not implemented";
                        break;
                }
                
                if (fieldVal) {
                    fieldsHtml += `<tr>
                        <td class="field-id">DE${i}</td>
                        <td>${fieldName}</td>
                        <td>${fieldVal}</td>
                    </tr>`;
                    fieldsFound++;
                }
            }
        }

        if (fieldsFound === 0) {
            fieldsHtml = "<tr><td colspan='3' style='text-align:center'>No recognized fields found in bitmap</td></tr>";
        }

        fieldsBody.innerHTML = fieldsHtml;
        resultPanel.style.display = "block";

    } catch (e) {
        showError(e.message);
    } finally {
        btn.disabled = false;
        btnText.innerText = "Analyze Message";
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
