<?php
$pageDescription = 'Master payment processing with CardPay Suite — an interactive transaction simulator, ISO 8583, EMV & ISO 20022 guides, and free developer tools for fintech engineers and students.';
include 'includes/header.php';
?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="assets/css/simulator.css">

<!-- 1. HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="text-gradient">Master the Art of <br>Payment Processing</h1>
            <p class="hero-description">
                An interactive deep-dive into the world of Fintech. Learn how transactions travel from a POS terminal
                through the <strong>ISO 8583</strong> standard, routing through switches and networks, and finally
                reaching the issuing bank. Designed for developers, students, and fintech enthusiasts.
            </p>

            <!-- Highlight Points -->
            <div class="hero-highlights">
                <div class="highlight-item">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Step-by-Step Guided Mode</span>
                </div>
                <div class="highlight-item">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Live ISO 8583 Message</span>
                </div>
                <div class="highlight-item">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Approve &amp; Decline Scenarios</span>
                </div>
            </div>

            <!-- CTA Button -->
            <a href="#simulator-section" class="btn-proceed hero-cta">
                <span>Launch Transaction Simulator</span>
                <i class="fa-solid fa-chevron-down"></i>
            </a>
        </div>
    </div>
</section>

<!-- 2. SIMULATOR SECTION -->
<section class="simulator-section" id="simulator-section">
    <div class="container">
        <header class="section-header">
            <h2 class="text-gradient">Card Payment Transaction Simulator</h2>
            <p class="subtitle">Step through a real card authorization — watch the ISO 8583 message travel from terminal to issuer and back.</p>
        </header>

        <!-- CONTROL BAR -->
        <div class="sim-controls glass-panel">
            <div class="control-group">
                <span class="control-label">Scenario</span>
                <div class="scenario-pills" id="scenarioPills">
                    <button class="scenario-pill active" data-scenario="approved"><i class="fa-solid fa-circle-check"></i> Approved</button>
                    <button class="scenario-pill" data-scenario="insufficient"><i class="fa-solid fa-wallet"></i> Insufficient Funds</button>
                    <button class="scenario-pill" data-scenario="donothonor"><i class="fa-solid fa-ban"></i> Do Not Honor</button>
                    <button class="scenario-pill" data-scenario="fraud"><i class="fa-solid fa-shield-halved"></i> Suspected Fraud</button>
                </div>
            </div>

            <div class="control-group">
                <span class="control-label">Amount (DE4)</span>
                <div class="amount-pills" id="amountPills">
                    <button class="amount-btn" data-price="7">$7</button>
                    <button class="amount-btn" data-price="10">$10</button>
                    <button class="amount-btn active" data-price="25">$25</button>
                </div>
            </div>

            <div class="control-group">
                <span class="control-label">Mode</span>
                <div class="mode-toggle" id="modeToggle">
                    <button class="mode-btn active" data-mode="guided"><i class="fa-solid fa-shoe-prints"></i> Guided</button>
                    <button class="mode-btn" data-mode="auto"><i class="fa-solid fa-play"></i> Auto-play</button>
                </div>
            </div>

            <div class="control-group" id="speedControl" style="display:none;">
                <span class="control-label">Speed</span>
                <div class="speed-pills" id="speedPills">
                    <button class="speed-btn" data-speed="1400">Slow</button>
                    <button class="speed-btn active" data-speed="900">Normal</button>
                    <button class="speed-btn" data-speed="450">Fast</button>
                </div>
            </div>

            <div class="control-group control-actions">
                <button id="prevBtn" class="btn-restart sim-icon-btn" title="Previous step" style="display:none;"><i class="fa-solid fa-arrow-left"></i></button>
                <button id="primaryBtn" class="btn-proceed sim-primary">
                    <span class="btn-text">Start</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button id="resetBtn" class="btn-restart sim-icon-btn" title="Reset simulator"><i class="fa-solid fa-rotate-right"></i></button>
            </div>
        </div>

        <!-- PROGRESS STEPPER (hover a stage for what it does) -->
        <div class="sim-stepper" id="simStepper">
            <div class="stepper-node" data-stage="0"
                 data-title="Cardholder &amp; POS" data-desc="The cardholder presents the card; the merchant's terminal reads it and packages the purchase into an ISO 8583 request." data-iso="ISO 8583: MTI 0200 (Financial Request)">
                <span class="stepper-dot">1</span><span class="stepper-label">Cardholder</span>
            </div>
            <div class="stepper-line"></div>
            <div class="stepper-node" data-stage="1"
                 data-title="Acquirer" data-desc="The merchant's bank. Validates the message and forwards it toward the card network." data-iso="ISO 8583: DE32 (Acquiring Institution ID)">
                <span class="stepper-dot">2</span><span class="stepper-label">Acquirer</span>
            </div>
            <div class="stepper-line"></div>
            <div class="stepper-node" data-stage="2"
                 data-title="Payment Switch" data-desc="A routing hub. Uses the card's BIN (leading digits of the PAN) to decide where the message goes next." data-iso="Logic: BIN routing on DE2">
                <span class="stepper-dot">3</span><span class="stepper-label">Switch</span>
            </div>
            <div class="stepper-line"></div>
            <div class="stepper-node" data-stage="3"
                 data-title="Card Network" data-desc="Visa / Mastercard etc. Validates the card program and routes the request to the issuing bank." data-iso="ISO 8583: message forwarded intact">
                <span class="stepper-dot">4</span><span class="stepper-label">Network</span>
            </div>
            <div class="stepper-line"></div>
            <div class="stepper-node" data-stage="4"
                 data-title="Issuing Bank" data-desc="The cardholder's bank. Checks the balance, verifies credentials, scores fraud and returns the decision." data-iso="ISO 8583: DE39 (Response Code)">
                <span class="stepper-dot">5</span><span class="stepper-label">Issuer</span>
            </div>
            <div class="stepper-line"></div>
            <div class="stepper-node" data-stage="5"
                 data-title="Response" data-desc="The issuer's decision returns as an 0210 message along the same path back to the terminal." data-iso="ISO 8583: MTI 0210 · DE39 (+ DE38 if approved)">
                <span class="stepper-dot">6</span><span class="stepper-label">Response</span>
            </div>
        </div>

        <!-- TEACHING CORE (full width) -->
        <article class="card teach-card">
            <div class="teach-tabs" id="teachTabs">
                <button class="teach-tab active" data-tab="narration"><i class="fa-solid fa-lightbulb"></i> What's happening</button>
                <button class="teach-tab" data-tab="iso"><i class="fa-solid fa-code"></i> ISO 8583 Message</button>
                <button class="teach-tab" data-tab="result"><i class="fa-solid fa-receipt"></i> Result</button>
            </div>

            <div class="teach-body">

                <!-- TAB: NARRATION -->
                <div class="teach-panel active" id="tab-narration">
                    <div class="narr-stage" id="narrStage">Ready to begin</div>
                    <h3 class="narr-title" id="narrTitle">Press Start to run a transaction</h3>
                    <p class="narr-text" id="narrText">Pick a <strong>scenario</strong>, an <strong>amount</strong> and a <strong>mode</strong> above, then press <strong>Start</strong>. In <em>Guided</em> mode you advance one hop at a time and read what happens at each; <em>Auto-play</em> runs the whole flow for you.</p>
                    <div class="narr-iso">
                        <i class="fa-solid fa-microchip"></i>
                        <span id="narrIsoText">ISO 8583 field details will appear here as the message travels. Hover a stage above to see what each party does.</span>
                    </div>
                </div>

                <!-- TAB: ISO 8583 MESSAGE -->
                <div class="teach-panel" id="tab-iso">
                    <div class="iso-panel-head">
                        <span>Live ISO 8583 message</span>
                        <span class="iso-mti-badge" id="isoMti">MTI —</span>
                    </div>
                    <div class="iso-inspector">
                        <div class="iso-group">Authorization Request · 0200</div>
                        <div class="iso-row" data-field="de2">
                            <span class="iso-de">DE2</span><span class="iso-name">Primary Account Number</span>
                            <span class="iso-val">4111 11•• •••• 1111</span>
                        </div>
                        <div class="iso-row" data-field="de3">
                            <span class="iso-de">DE3</span><span class="iso-name">Processing Code</span>
                            <span class="iso-val">000000 · purchase</span>
                        </div>
                        <div class="iso-row" data-field="de4">
                            <span class="iso-de">DE4</span><span class="iso-name">Amount</span>
                            <span class="iso-val" id="valDe4">—</span>
                        </div>
                        <div class="iso-row" data-field="de11">
                            <span class="iso-de">DE11</span><span class="iso-name">System Trace (STAN)</span>
                            <span class="iso-val" id="valDe11">—</span>
                        </div>
                        <div class="iso-row" data-field="de22">
                            <span class="iso-de">DE22</span><span class="iso-name">POS Entry Mode</span>
                            <span class="iso-val">051 · chip</span>
                        </div>
                        <div class="iso-row" data-field="de41">
                            <span class="iso-de">DE41</span><span class="iso-name">Terminal ID</span>
                            <span class="iso-val">TERM0001</span>
                        </div>
                        <div class="iso-row" data-field="de32">
                            <span class="iso-de">DE32</span><span class="iso-name">Acquiring Institution ID</span>
                            <span class="iso-val">12345678</span>
                        </div>

                        <div class="iso-group">Issuer Response · 0210</div>
                        <div class="iso-row" data-field="de39">
                            <span class="iso-de">DE39</span><span class="iso-name">Response Code</span>
                            <span class="iso-val" id="valDe39">—</span>
                        </div>
                        <div class="iso-row" data-field="de38">
                            <span class="iso-de">DE38</span><span class="iso-name">Authorization Code</span>
                            <span class="iso-val" id="valDe38">—</span>
                        </div>
                    </div>
                </div>

                <!-- TAB: RESULT -->
                <div class="teach-panel" id="tab-result">
                    <div class="result-glass-container">
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-circle-dot"></i> Status</div>
                            <div class="row-value"><span id="resultStatus" class="status-badge waiting">Waiting</span></div>
                        </div>
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-dollar-sign"></i> Amount</div>
                            <div class="row-value" id="resultAmount">-</div>
                        </div>
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-shield-halved"></i> Auth Code (DE38)</div>
                            <div class="row-value" id="authCode">----</div>
                        </div>
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-comment-dots"></i> Response (DE39)</div>
                            <div class="row-value" id="responseText">-</div>
                        </div>
                    </div>
                    <p class="result-hint" id="resultHint">Run a transaction to see the outcome the issuer returned.</p>
                </div>

            </div>
        </article>
    </div>
</section>

<!-- Page-scoped tooltip for stepper stages (kept out of the global footer) -->
<div id="global-tooltip" class="node-tooltip">
    <h4 id="tt-title"></h4>
    <p id="tt-desc"></p>
    <div class="iso-info" id="tt-iso"></div>
</div>

<script src="assets/js/simulator.js"></script>
<?php include 'includes/footer.php'; ?>
