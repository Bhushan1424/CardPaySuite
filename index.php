<?php include 'includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="assets/css/simulator.css">

<section class="simulator-section">
    <div class="container">
        <header class="section-header">
            <h2>Card Payment Transaction Simulator</h2>
            <p class="subtitle">Interactive flow visualization for fintech transactions</p>
        </header>

        <div class="main-grid">

            <!-- PRODUCTS -->
            <article class="card step-block">
                <div class="card-header">
                    <h3>1. Purchase</h3>
                </div>
                <div class="card-body">
                    <div class="product-grid">
                        <div class="product-item" data-name="Burger" data-price="25">
                            <span class="icon">🍔</span>
                            <div class="details">
                                <p class="name">Burger</p>
                                <span class="price">$25.00</span>
                            </div>
                        </div>

                        <div class="product-item" data-name="Fries" data-price="10">
                            <span class="icon">🍟</span>
                            <div class="details">
                                <p class="name">Fries</p>
                                <span class="price">$10.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- POS -->
            <article class="card step-block">
                <div class="card-header">
                    <h3>2. POS Terminal</h3>
                </div>
                <div class="card-body">
                    <div class="terminal" id="posTerminal">
                        <div class="terminal-screen">
                            <span class="amount">$<span id="amountValue">0.00</span></span>
                        </div>
                        <div class="terminal-pad">
                            <span class="tap-indicator">Tap Here</span>
                        </div>
                    </div>
                    <p id="terminalText" class="status-text">Select product</p>
                </div>
            </article>

            <!-- FLOW -->
            <article class="card step-block flow-card">
                <div class="card-header">
                    <h3>3. Payment Flow</h3>
                </div>
                <div class="card-body">
                    <div class="payment-flow-diagram">

                        <div class="flow-row">
                            <div class="step-node" id="merchant">Merchant</div>
                            <div class="arrow down" id="arrow-merchant"></div>
                            <div class="flow-box" id="info-merchant"></div>
                        </div>

                        <div class="flow-row">
                            <div class="step-node" id="acquirer">Acquirer</div>
                            <div class="arrow down" id="arrow-acquirer"></div>
                            <div class="flow-box" id="info-acquirer"></div>
                        </div>

                        <div class="flow-row">
                            <div class="step-node" id="switch">Switch</div>
                            <div class="arrow down" id="arrow-switch"></div>
                            <div class="flow-box" id="info-switch"></div>
                        </div>

                        <div class="flow-row">
                            <div class="step-node" id="network">Network</div>
                            <div class="arrow down" id="arrow-network"></div>
                            <div class="flow-box" id="info-network"></div>
                        </div>

                        <div class="flow-row">
                            <div class="step-node" id="issuer">Issuer</div>
                            <div class="flow-box" id="info-issuer"></div>
                        </div>

                    </div>
                </div>
            </article>

            <!-- RESULT -->
            <article class="card step-block">
                <div class="card-header">
                    <h3>4. Result</h3>
                </div>
                <div class="card-body">
                    <div class="result-box">
                        <div class="result-row">
                            <span class="label">Status:</span>
                            <span id="resultStatus" class="value">Waiting</span>
                        </div>
                        <div class="result-row">
                            <span class="label">Item:</span>
                            <span id="resultItem" class="value">-</span>
                        </div>
                        <div class="result-row">
                            <span class="label">Amount:</span>
                            <span id="resultAmount" class="value">-</span>
                        </div>
                        <div class="result-row">
                            <span class="label">Auth Code:</span>
                            <span id="authCode" class="value">----</span>
                        </div>
                        <div class="result-row">
                            <span class="label">Response:</span>
                            <span id="responseText" class="value">-</span>
                        </div>

                        <button id="resetBtn" class="btn btn-reset">
                            <span>🔄</span> Reset Transaction
                        </button>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- Link Custom JS -->
<script src="assets/js/simulator.js"></script>

<?php include 'includes/footer.php'; ?>