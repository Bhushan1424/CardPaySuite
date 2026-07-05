<?php include '../includes/header.php'; ?>


<section class="tools-page-section">
    <div class="container">
        
        <!-- HEADER SECTION -->
        <header class="tools-header">
            <h1 class="text-gradient">Developer Tools</h1>
            <p class="tools-subtitle">Essential utilities for card payments, ISO 8583, and EMV analysis. Professional-grade tools for fintech engineers.</p>
        </header>

        <!-- TOOLS GRID -->
        <div class="tools-grid">

            <!-- Tool 1: ISO8583 Parser -->
            <div class="tool-card glass-panel">
                <div class="tool-icon-box">
                    <i class="fa-solid fa-code"></i>
                </div>
                <div class="tool-content">
                    <h3>ISO8583 Parser</h3>
                    <p>Decode complex card authorization messages and analyze MTI and data elements.</p>
                </div>
                <a href="/tools/iso8583-parser.php" class="btn-tool">Open Tool <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Tool 2: ISO 20022 Parser -->
            <div class="tool-card glass-panel">
                <div class="tool-icon-box">
                    <i class="fa-solid fa-file-code"></i>
                </div>
                <div class="tool-content">
                    <h3>ISO 20022 Parser</h3>
                    <p>Decode ISO 20022 XML messages (pacs, pain, camt) and inspect every element with friendly names.</p>
                </div>
                <a href="/tools/iso20022-parser.php" class="btn-tool">Open Tool <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Tool 3: BIN Lookup -->
            <div class="tool-card glass-panel">
                <div class="tool-icon-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="tool-content">
                    <h3>BIN Lookup</h3>
                    <p>Identify the card issuer, network, and country by analyzing the Bank Identification Number.</p>
                </div>
                <a href="/tools/bin-lookup.php" class="btn-tool">Open Tool <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Tool 4: TLV Decoder -->
            <div class="tool-card glass-panel">
                <div class="tool-icon-box">
                    <i class="fa-solid fa-database"></i>
                </div>
                <div class="tool-content">
                    <h3>TLV Decoder</h3>
                    <p>Parse EMV TLV (Tag-Length-Value) structures used in chip-and-pin transactions.</p>
                </div>
                <a href="/tools/tlv.php" class="btn-tool">Open Tool <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Tool 5: Card generator -->
            <div class="tool-card glass-panel">
                <div class="tool-icon-box">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <div class="tool-content">
                    <h3>Card Generator</h3>
                    <p>Create valid card numbers for testing and development purposes.</p>
                </div>
                <a href="/tools/card-generator.php" class="btn-tool">Open Tool <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Tool 6: Base 64 Convertor -->
            <div class="tool-card glass-panel">
                <div class="tool-icon-box">
                    <i class="fa-solid fa-border-all"></i>
                </div>
                <div class="tool-content">
                    <h3>Base 64 Convertor</h3>
                    <p>Convert data between Base 64 and other formats for seamless integration.</p>
                </div>
                <a href="/tools/base64.php" class="btn-tool">Open Tool <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Tool 7: LUHN Validator -->
            <div class="tool-card glass-panel">
                <div class="tool-icon-box">
                    <i class="fa-solid fa-check-double"></i>
                </div>
                <div class="tool-content">
                    <h3>LUHN Validator</h3>
                    <p>Verify LUHN Check Algorithm compliance for card numbers.</p>
                </div>
                <a href="/tools/luhn.php" class="btn-tool">Open Tool <i class="fa-solid fa-arrow-right"></i></a>
            </div>

        </div>
    </div>
</section>


<?php include '../includes/footer.php'; ?>
