<?php include '../includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

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

    .converter-container {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* --- Control Bar --- */
    .converter-controls {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 20px;
    }

    .control-group {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .control-group label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .mode-select {
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid var(--border-color);
        color: white;
        padding: 8px 15px;
        border-radius: 10px;
        font-size: 0.9rem;
        cursor: pointer;
        outline: none;
    }

    .control-actions {
        display: flex;
        gap: 10px;
    }

    /* --- Grid Layout --- */
    .converter-grid {
        display: grid;
        grid-template-columns: 1fr 100px 1fr;
        gap: 20px;
        align-items: center;
    }

    .converter-panel {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        transition: var(--transition);
    }

    .converter-panel:hover {
        border-color: var(--accent-primary);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .char-count {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    textarea {
        width: 100%;
        height: 300px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 15px;
        color: #4ade80; /* Terminal Green */
        font-family: 'Courier New', monospace;
        font-size: 1rem;
        resize: none;
        outline: none;
        transition: var(--transition);
    }

    textarea:focus {
        border-color: var(--accent-primary);
        box-shadow: 0 0 10px var(--accent-glow);
    }

    /* --- Divider / Arrow --- */
    .converter-divider {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .arrow-circle {
        width: 50px;
        height: 50px;
        background: var(--accent-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 0 15px var(--accent-glow);
        animation: rotatePulse 3s infinite ease-in-out;
    }

    .copy-btn {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .copy-btn:hover {
        color: white;
        border-color: var(--accent-primary);
    }

    @keyframes rotatePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    @media (max-width: 900px) {
        .converter-grid {
            grid-template-columns: 1fr;
        }
        .converter-divider {
            transform: rotate(90deg);
            margin: 10px 0;
        }
    }
</style>

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
