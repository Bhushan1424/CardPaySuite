<?php include '../includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">
            
            <!-- SIDEBAR NAVIGATION (Consistent with index.php) -->
            <aside class="docs-sidebar glass-panel">
                <div class="sidebar-header">
                    <h3>Learning Center</h3>
                </div>
                <nav class="sidebar-nav">
                    <div class="nav-group">
                        <span class="group-title">Fundamentals</span>
                        <a href="index.php" class="nav-item"><i class="fa-solid fa-book-open"></i> Introduction</a>
                        <a href="transaction-lifecycle.php" class="nav-item active"><i class="fa-solid fa-route"></i> Transaction Flow</a>
                    </div>
                    
                    <div class="nav-group">
                        <span class="group-title">Technical Standards</span>
                        <a href="iso8583.php" class="nav-item"><i class="fa-solid fa-code"></i> ISO 8583 Standard</a>
                        <a href="emv-tlv.php" class="nav-item"><i class="fa-solid fa-microchip"></i> EMV & TLV Logic</a>
                    </div>

                    <div class="nav-group">
                        <span class="group-title">Reference</span>
                        <a href="glossary.php" class="nav-item"><i class="fa-solid fa-list"></i> Glossary of Terms</a>
                    </div>
                </nav>
            </aside>

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

<style>
    /* --- Layout Basics --- */
    .docs-section { padding: 60px 0; color: var(--text-main); }
    .docs-layout { display: grid; grid-template-columns: 280px 1fr; gap: 30px; align-items: start; }
    .docs-sidebar { padding: 20px; position: sticky; top: 100px; height: fit-content; }
    .sidebar-header h3 { font-size: 1.1rem; color: var(--accent-primary); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color); }
    .nav-group { margin-bottom: 25px; }
    .group-title { display: block; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; margin-bottom: 10px; font-weight: 600; }
    .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; border-radius: 8px; transition: var(--transition); margin-bottom: 4px; }
    .nav-item:hover, .nav-item.active { background: rgba(99, 102, 241, 0.1); color: var(--accent-primary); }
    .docs-content { padding: 40px; }
    .content-header { margin-bottom: 40px; border-bottom: 1px solid var(--border-color); padding-bottom: 30px; }
    .content-header h1 { font-size: 2.5rem; margin-bottom: 10px; }
    .docs-subtitle { font-size: 1.1rem; color: var(--text-muted); }
    .info-card { background: rgba(99, 102, 241, 0.1); border-left: 4px solid var(--accent-primary); padding: 20px; border-radius: 8px; display: flex; gap: 15px; align-items: center; margin-bottom: 40px; color: var(--text-main); }
    .info-card i { color: var(--accent-primary); font-size: 1.2rem; }

    /* --- Timeline Design --- */
    .lifecycle-timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
        padding-left: 40px;
    }

    .lifecycle-timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--accent-primary), var(--accent-secondary), var(--border-color));
    }

    .timeline-item {
        position: relative;
        margin-bottom: 40px;
    }

    .timeline-dot {
        position: absolute;
        left: -35px;
        top: 20px;
        width: 24px;
        height: 24px;
        background: var(--accent-primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
        z-index: 10;
        box-shadow: 0 0 10px var(--accent-glow);
    }

    .timeline-content {
        padding: 20px;
        transition: var(--transition);
    }

    .timeline-content:hover {
        transform: translateX(10px);
        border-color: var(--accent-primary);
    }

    .step-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .step-header i {
        color: var(--accent-primary);
        font-size: 1.2rem;
    }

    .step-header h4 {
        font-size: 1.1rem;
        color: var(--text-bright);
        margin: 0;
    }

    .tech-callout {
        margin-top: 15px;
        font-size: 0.8rem;
        background: rgba(0, 0, 0, 0.2);
        padding: 8px 12px;
        border-radius: 6px;
        color: var(--accent-primary);
        font-family: 'Courier New', monospace;
        border-left: 2px solid var(--accent-primary);
    }

    /* CTA Box */
    .simulator-cta-box {
        margin-top: 60px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.1));
        border: 1px solid var(--accent-primary);
        padding: 30px;
        border-radius: 24px;
        text-align: center;
    }

    .simulator-cta-box h3 {
        margin-bottom: 10px;
        color: var(--text-bright);
    }

    .simulator-cta-box p {
        margin-bottom: 20px;
        color: var(--text-muted);
    }

    @media (max-width: 992px) {
        .docs-layout { grid-template-columns: 1fr; }
        .docs-sidebar { position: relative; top: 0; }
    }
</style>

<?php include '../includes/footer.php'; ?>
