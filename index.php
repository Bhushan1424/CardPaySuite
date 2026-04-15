<?php include 'includes/header.php'; ?>

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
                    <span>Interactive Visualization</span>
                </div>
                <div class="highlight-item">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>ISO 8583 Logic</span>
                </div>
                <div class="highlight-item">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Real-time Response Simulation</span>
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

<!-- 2. SIMULATOR SECTION (Now with ID for scrolling) -->
<section class="simulator-section" id="simulator-section">
    <div class="container">
        <header class="section-header">
            <h2 class="text-gradient">Card Payment Transaction Simulator</h2>
            <p class="subtitle">Interactive flow visualization for fintech transactions</p>
        </header>

        <div class="main-grid">

            <!-- PANEL 1: PREMIUM TERMINAL -->
            <article class="card terminal-premium-card">
                <div class="terminal-header">
                    <div class="header-main">
                        <h3 class="terminal-title">Terminal Interface</h3>
                        <div class="status-indicator">
                            <span class="pulse-dot"></span>
                            <span id="terminalText" class="status-text">Ready</span>
                        </div>
                    </div>
                </div>

                <div class="terminal-body">
                    <div class="section-label">Select Item</div>
                    <div class="item-list">
                        <div class="item-row" data-name="Premium Burger" data-price="25">
                            <div class="item-info">
                                <div class="item-icon">🍔</div>
                                <span class="item-name">Premium Burger</span>
                            </div>
                            <span class="item-price">$25.00</span>
                        </div>
                        <div class="item-row" data-name="Crispy Fries" data-price="10">
                            <div class="item-info">
                                <div class="item-icon">🍟</div>
                                <span class="item-name">Crispy Fries</span>
                            </div>
                            <span class="item-price">$10.00</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="payment-summary">
                        <div class="summary-row">
                            <span class="label">Total Amount</span>
                            <span class="value">$<span id="amountValue">0.00</span></span>
                        </div>
                    </div>
                    <div class="loader-container" id="loaderContainer">
                        <div class="loader-bar"></div>
                        <span class="loader-text">Processing Transaction...</span>
                    </div>
                    <button id="posTerminal" class="btn-proceed">
                        <span class="btn-text">Proceed to Payment</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </article>

            <!-- PANEL 2: INTERACTIVE FLOW -->
            <article class="card step-block flow-card">
                <div class="card-header">
                    <h3>2. Transaction Flow</h3>
                </div>
                <div class="card-body">
                    <div class="payment-flow-container">
                        <div class="flow-node-wrapper">
                            <div class="flow-node" id="merchant" data-title="Merchant" data-desc="Initiates the transaction request via the POS terminal." data-iso="ISO 8583: MTI 0200 (Financial Request)">
                                <div class="node-icon"><i class="fa-solid fa-store"></i></div>
                                <span class="node-label">Merchant</span>
                            </div>
                            <div class="flow-connector" id="arrow-merchant"></div>
                        </div>
                        <div class="flow-node-wrapper">
                            <div class="flow-node" id="acquirer" data-title="Acquirer" data-desc="Receives the request and routes it to the network." data-iso="ISO 8583: Field 3 (Processing Code)">
                                <div class="node-icon"><i class="fa-solid fa-building-columns"></i></div>
                                <span class="node-label">Acquirer</span>
                            </div>
                            <div class="flow-connector" id="arrow-acquirer"></div>
                        </div>
                        <div class="flow-node-wrapper">
                            <div class="flow-node" id="switch" data-title="Payment Switch" data-desc="The central routing hub that directs messages." data-iso="Logic: BIN Routing">
                                <div class="node-icon"><i class="fa-solid fa-route"></i></div>
                                <span class="node-label">Switch</span>
                            </div>
                            <div class="flow-connector" id="arrow-switch"></div>
                        </div>
                        <div class="flow-node-wrapper">
                            <div class="flow-node" id="network" data-title="Card Network" data-desc="Validates card and routes to the Issuer bank." data-iso="ISO 8583: Network Validation">
                                <div class="node-icon"><i class="fa-solid fa-globe"></i></div>
                                <span class="node-label">Network</span>
                            </div>
                            <div class="flow-connector" id="arrow-network"></div>
                        </div>
                        <div class="flow-node-wrapper">
                            <div class="flow-node" id="issuer" data-title="Issuing Bank" data-desc="Checks balance and security. Sends final decision." data-iso="ISO 8583: Field 39 (Response Code)">
                                <div class="node-icon"><i class="fa-solid fa-credit-card"></i></div>
                                <span class="node-label">Issuer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- PANEL 3: TRANSACTION RESULT -->
            <article class="card step-block result-premium-card">
                <div class="card-header">
                    <h3>3. Transaction Result</h3>
                </div>
                <div class="card-body">
                    <div class="result-glass-container">
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-circle-dot"></i> Status</div>
                            <div class="row-value"><span id="resultStatus" class="status-badge waiting">Waiting</span></div>
                        </div>
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-cart-shopping"></i> Item</div>
                            <div class="row-value" id="resultItem">-</div>
                        </div>
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-dollar-sign"></i> Amount</div>
                            <div class="row-value" id="resultAmount">-</div>
                        </div>
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-shield-halved"></i> Auth Code</div>
                            <div class="row-value" id="authCode">----</div>
                        </div>
                        <div class="result-row">
                            <div class="row-label"><i class="fa-solid fa-comment-dots"></i> Response</div>
                            <div class="row-value" id="responseText">-</div>
                        </div>
                        <div class="tech-details-wrapper">
                            <div class="tech-toggle" id="toggleTech">
                                <span><i class="fa-solid fa-code"></i> View Technical Details</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="tech-panel" id="techPanel">
                                <div class="tech-grid">
                                    <div class="tech-item"><span class="t-label">MTI</span><span class="t-value" id="techMti">-</span></div>
                                    <div class="tech-item"><span class="t-label">DE39</span><span class="t-value" id="techDe39">-</span></div>
                                    <div class="tech-item"><span class="t-label">Trace ID</span><span class="t-value" id="techTrace">-</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="resetBtn" class="btn-restart">
                        <i class="fa-solid fa-rotate-right"></i> Start New Transaction
                    </button>
                </div>
            </article>
        </div>
    </div>
</section>

<script src="assets/js/simulator.js"></script>
<?php include 'includes/footer.php'; ?>
