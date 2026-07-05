<?php
$pageTitle = 'Transaction Lifecycle';
$pageDescription = 'Follow a card payment step by step from POS terminal to issuing bank — authorization, clearing, and settlement explained.';
include '../includes/header.php';
?>


<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">
            
            <!-- SIDEBAR NAVIGATION (shared partial) -->
            <?php $activeDoc = 'lifecycle'; include '../includes/docs-sidebar.php'; ?>

            <!-- MAIN CONTENT AREA -->
            <main class="docs-content glass-panel">
                <div class="content-header">
                    <h1 class="text-gradient">The Transaction Lifecycle</h1>
                    <p class="docs-subtitle">A step-by-step breakdown of how a payment request travels across the global financial network in milliseconds.</p>
                </div>

                <div class="content-body">
                    <!-- Intro Section -->
                    <div class="info-card">
                        <i class="fa-solid fa-circle-info"></i>
                        <p>This guide follows the <strong>"Happy Path"</strong>—a successful authorization flow. In a real scenario, the flow can be interrupted by fraud checks, insufficient funds, or network timeouts.</p>
                    </div>

                    <!-- THE TIMELINE -->
                    <div class="lifecycle-timeline">
                        
                        <!-- Step 1 -->
                        <div class="timeline-item">
                            <div class="timeline-dot">1</div>
                            <div class="timeline-content glass-panel">
                                <div class="step-header">
                                    <i class="fa-solid fa-store"></i>
                                    <h4>The Merchant (Initiation)</h4>
                                </div>
                                <p>The process begins when a customer taps their card. The POS terminal captures the chip data and creates an <strong>ISO 8583 Request Message (MTI 0200)</strong>.</p>
                                <div class="tech-callout"><strong>Key Action:</strong> Capturing PAN and Transaction Amount.</div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="timeline-item">
                            <div class="timeline-dot">2</div>
                            <div class="timeline-content glass-panel">
                                <div class="step-header">
                                    <i class="fa-solid fa-building-columns"></i>
                                    <h4>The Acquirer (Processing)</h4>
                                </div>
                                <p>The Merchant sends the request to their bank (The Acquirer). The Acquirer validates the format and decides which network (Visa, Mastercard, etc.) should handle the request.</p>
                                <div class="tech-callout"><strong>Key Action:</strong> Routing and Message Validation.</div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="timeline-item">
                            <div class="timeline-dot">3</div>
                            <div class="timeline-content glass-panel">
                                <div class="step-header">
                                    <i class="fa-solid fa-route"></i>
                                    <h4>The Switch (Routing)</h4>
                                </div>
                                <p>The Switch acts as a giant traffic controller. It reads the <strong>BIN (Bank Identification Number)</strong> to determine which specific Issuer bank owns the card.</p>
                                <div class="tech-callout"><strong>Key Action:</strong> BIN Lookup and Path Determination.</div>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="timeline-item">
                            <div class="timeline-dot">4</div>
                            <div class="timeline-content glass-panel">
                                <div class="fa-solid fa-globe"></div>
                                <div class="step-header">
                                    <i class="fa-solid fa-globe"></i>
                                    <h4>The Card Network (Verification)</h4>
                                </div>
                                <p>The message travels through the network (e.g., VisaNet). The network ensures the message is secure and forwards it to the correct Issuing Bank.</p>
                                <div class="tech-callout"><strong>Key Action:</strong> Network Security & Protocol Translation.</div>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="timeline-item">
                            <div class="timeline-dot">5</div>
                            <div class="timeline-content glass-panel">
                                <div class="step-header">
                                    <i class="fa-solid fa-credit-card"></i>
                                    <h4>The Issuer (Decision)</h4>
                                </div>
                                <p>The Issuer bank checks if the account is active and has enough funds. It then generates a <strong>Response Message (MTI 0210)</strong> with a Response Code (e.g., 00 for Approved).</p>
                                <div class="tech-callout"><strong>Key Action:</strong> Balance Check & Fraud Scoring.</div>
                            </div>
                        </div>

                    </div>

                    <!-- CTA to Simulator -->
                    <div class="simulator-cta-box">
                        <h3>Want to see this in action?</h3>
                        <p>Head over to our interactive simulator to trigger this flow yourself and see the nodes light up in real-time.</p>
                        <a href="/index.php#simulator-section" class="btn-primary">Go to Simulator <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                </div>
            </main>

        </div>
    </section>
</div>


<?php include '../includes/footer.php'; ?>
