<?php
$pageTitle = 'Base64 Encoder / Decoder';
$pageDescription = 'Convert data to and from Base64 quickly and privately in your browser.';
include '../includes/header.php';
?>


<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">
            
            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">Base64 & Hex Converter</h1>
                <p class="tools-subtitle">Professional data transformation tool. Convert between Base64, Plain Text, and Hexadecimal formats instantly.</p>
            </header>

            <!-- MAIN CONVERTER INTERFACE -->
            <div class="converter-container">
                
                <!-- CONTROL BAR -->
                <div class="converter-controls glass-panel">
                    <div class="control-group">
                        <label>Conversion Mode:</label>
                        <select id="convMode" onchange="updateModeUI()" class="mode-select">
                            <option value="b64-text">Base64 ➔ Text</option>
                            <option value="text-b64">Text ➔ Base64</option>
                            <option value="b64-hex">Base64 ➔ Hex</option>
                            <option value="hex-b64">Hex ➔ Base64</option>
                            <option value="text-hex">Text ➔ Hex</option>
                            <option value="hex-text">Hex ➔ Text</option>
                        </select>
                    </div>
                    <div class="control-actions">
                        <button onclick="clearAll()" class="btn-console">Clear</button>
                        <button onclick="processConversion()" class="btn-primary">Convert Now <i class="fa-solid fa-rotate"></i></button>
                    </div>
                </div>

                <!-- INPUT/OUTPUT GRID -->
                <div class="converter-grid">
                    
                    <!-- Input Panel -->
                    <div class="converter-panel">
                        <div class="panel-header">
                            <span id="inputLabel">Input (Base64)</span>
                            <span class="char-count" id="inputCount">0 chars</span>
                        </div>
                        <textarea id="inputArea" placeholder="Enter data here..." spellcheck="false"></textarea>
                    </div>

                    <!-- Visual Arrow/Divider -->
                    <div class="converter-divider">
                        <div class="arrow-circle">
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </div>
                    </div>

                    <!-- Output Panel -->
                    <div class="converter-panel">
                        <div class="panel-header">
                            <span id="outputLabel">Output (Text)</span>
                            <button onclick="copyOutput()" class="copy-btn"><i class="fa-solid fa-copy"></i> Copy</button>
                        </div>
                        <textarea id="outputArea" readonly placeholder="Result will appear here..."></textarea>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>


<script>
    // Utility: Hex to String
    const hexToString = (hex) => {
        let str = '';
        for (let i = 0; i < hex.length; i += 2) {
            str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
        }
        return str;
    };

    // Utility: String to Hex
    const stringToHex = (str) => {
        return str.split('').map(c => c.charCodeAt(0).toString(16).padStart(2, '0')).join('');
    };

    function updateModeUI() {
        const mode = document.getElementById("convMode").value;
        const inputLabel = document.getElementById("inputLabel");
        const outputLabel = document.getElementById("outputLabel");

        const labels = {
            "b64-text": { in: "Input (Base64)", out: "Output (Text)" },
            "text-b64": { in: "Input (Text)", out: "Output (Base64)" },
            "b64-hex": { in: "Input (Base64)", out: "Output (Hex)" },
            "hex-b64": { in: "Input (Hex)", out: "Output (Base64)" },
            "text-hex": { in: "Input (Text)", out: "Output (Hex)" },
            "hex-text": { in: "Input (Hex)", out: "Output (Text)" },
        };

        inputLabel.innerText = labels[mode].in;
        outputLabel.innerText = labels[mode].out;
    }

    function processConversion() {
        const mode = document.getElementById("convMode").value;
        const input = document.getElementById("inputArea").value.trim();
        const outputField = document.getElementById("outputArea");
        let result = "";

        if (!input) return;

        try {
            switch (mode) {
                case "b64-text":
                    result = atob(input);
                    break;
                case "text-b64":
                    result = btoa(input);
                    break;
                case "b64-hex":
                    const binary = atob(input);
                    result = stringToHex(binary);
                    break;
                case "hex-b64":
                    const textFromHex = hexToString(input.replace(/\s/g, ''));
                    result = btoa(textFromHex);
                    break;
                case "text-hex":
                    result = stringToHex(input);
                    break;
                case "hex-text":
                    result = hexToString(input.replace(/\s/g, ''));
                    break;
            }
            outputField.value = result;
        } catch (e) {
            outputField.value = "ERROR: Invalid input for the selected mode.";
        }
    }

    function clearAll() {
        document.getElementById("inputArea").value = "";
        document.getElementById("outputArea").value = "";
        document.getElementById("inputCount").innerText = "0 chars";
    }

    function copyOutput() {
        const output = document.getElementById("outputArea");
        output.select();
        document.execCommand("copy");
        alert("Copied to clipboard!");
    }

    // Character counter
    document.getElementById("inputArea").addEventListener("input", function() {
        document.getElementById("inputCount").innerText = this.value.length + " chars";
    });
</script>

<?php include '../includes/footer.php'; ?>
