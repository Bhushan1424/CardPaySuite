<?php include '../includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

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

            <!-- Tool 2: BIN Lookup -->
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

            <!-- Tool 3: TLV Decoder -->
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

            <!-- Tool 4: Card generator -->
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

            <!-- Tool 5: Base 64 Convertor -->
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

            <!-- Tool 6: LUHN Validator -->
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

<style>
    /* TOOLS PAGE SPECIFIC STYLES */
    .tools-page-section {
        padding: 80px 0;
        min-height: 100vh;
        color: var(--text-main);
    }

    .tools-header {
        text-align: center;
        margin-bottom: 60px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .tools-header h1 {
        font-size: 3rem;
        margin-bottom: 15px;
        font-weight: 800;
    }

    .tools-subtitle {
        font-size: 1.1rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* GRID LAYOUT */
    .tools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    /* TOOL CARD DESIGN */
    .tool-card {
        padding: 30px;
        display: flex;
        flex-direction: column;
        transition: var(--transition);
        text-align: left;
        position: relative;
    }

    .tool-card:hover {
        transform: translateY(-8px);
        border-color: var(--accent-primary);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4), 0 0 15px var(--accent-glow);
    }

    .tool-icon-box {
        width: 50px;
        height: 50px;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid var(--accent-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--accent-primary);
        margin-bottom: 20px;
    }

    .tool-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-bright);
    }

    .tool-content p {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 30px;
    }

    /* TOOL CTA BUTTON */
    .btn-tool {
        margin-top: auto;
        text-decoration: none;
        color: var(--text-main);
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        padding: 10px 0;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .btn-tool:hover {
        color: var(--accent-primary);
    }

    .btn-tool i {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .btn-tool:hover i {
        transform: translateX(5px);
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .tools-header h1 { font-size: 2.2rem; }
        .tools-grid { grid-template-columns: 1fr; }
    }
</style>

<?php include '../includes/footer.php'; ?>
