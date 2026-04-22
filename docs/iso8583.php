<?php include '../includes/header.php'; ?>

<!-- Link Custom CSS -->
<link rel="stylesheet" href="/assets/css/simulator.css">

<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">
            
            <!-- SIDEBAR NAVIGATION -->
            <aside class="docs-sidebar glass-panel">
                <div class="sidebar-header">
                    <h3>Learning Center</h3>
                </div>
                <nav class="sidebar-nav">
                    <div class="nav-group">
                        <span class="group-title">Fundamentals</span>
                        <a href="index.php" class="nav-item"><i class="fa-solid fa-book-open"></i> Introduction</a>
                        <a href="transaction-lifecycle.php" class="nav-item"><i class="fa-solid fa-route"></i> Transaction Flow</a>
                    </div>
                    
                    <div class="nav-group">
                        <span class="group-title">Technical Standards</span>
                        <a href="iso8583.php" class="nav-item active"><i class="fa-solid fa-code"></i> ISO 8583 Standard</a>
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
                    <h1 class="text-gradient">The ISO 8583 Standard</h1>
                    <p class="docs-subtitle">Understanding the international standard for financial transaction messaging. The backbone of global ATM and POS networks.</p>
                </div>

                <div class="content-body">
                    
                    <!-- Intro Section -->
                    <section class="doc-section">
                        <h2>What is ISO 8583?</h2>
                        <p>ISO 8583 is an international standard for systems that transmit electronic messages between financial institutions. It defines a common format for transaction messages, ensuring that a POS terminal in London can communicate effectively with a bank in New York.</p>
                    </section>

                    <!-- MTI Section -->
                    <section class="doc-section">
                        <div class="section-flex">
                            <div class="text-content">
                                <h2>1. Message Type Indicator (MTI)</h2>
                                <p>The MTI is the first 4 digits of every ISO 8583 message. It tells the receiving system what the <strong>purpose</strong> of the message is.</p>
                            </div>
                        </div>

                        <div class="tech-table-wrapper">
                            <table class="tech-table">
                                <thead>
                                    <tr>
                                        <th>MTI</th>
                                        <th>Description</th>
                                        <th>Example Use Case</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="code-cell">0100</td>
                                        <td>Authorization Request</td>
                                        <td>Customer taps card to pay for coffee.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">0110</td>
                                        <td>Authorization Response</td>
                                        <td>Bank approves/declines the coffee payment.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">0200</td>
                                        <td>Financial Request</td>
                                        <td>A full financial transaction request.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">0210</td>
                                        <td>Financial Response</td>
                                        <td>The final answer to a financial request.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">0800</td>
                                        <td>Network Management</td>
                                        <td>Echo test to see if the server is alive.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Bitmap Section -->
                    <section class="doc-section">
                        <h2>2. The Primary Bitmap</h2>
                        <p>After the MTI comes the <strong>Bitmap</strong>. Since ISO 8583 has hundreds of possible fields, it would be wasteful to send every field in every message. The Bitmap tells the receiver: <span class="highlight">"Which fields are actually present in this message."</span></p>
                        
                        <div class="info-card">
                            <i class="fa-solid fa-binary"></i>
                            <p><strong>How it works:</strong> A 64-bit binary map. If the 1st bit is 1, Field 1 is present. If the 5th bit is 0, Field 5 is absent.</p>
                        </div>
                    </section>

                    <!-- Data Elements Section -->
                    <section class="doc-section">
                        <h2>3. Common Data Elements (DE)</h2>
                        <p>Depending on the Bitmap, the message will contain various Data Elements. Here are the most critical fields used in our simulator:</p>

                        <div class="tech-table-wrapper">
                            <table class="tech-table">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Name</th>
                                        <th>Format</th>
                                        <th>Purpose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="code-cell">DE 2</td>
                                        <td>PAN</td>
                                        <td>Variable</td>
                                        <td>Primary Account Number (Card Number).</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">DE 3</td>
                                        <td>Processing Code</td>
                                        <td>Fixed (6)</td>
                                        <td>Determines if it's a withdrawal, purchase, etc.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">DE 4</td>
                                        <td>Amount</td>
                                        <td>Fixed (12)</td>
                                        <td>Transaction value in cents.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">DE 7</td>
                                        <td>Transmission Date</td>
                                        <td>Fixed (10)</td>
                                        <td>MMDDHHMMSS format.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">DE 11</td>
                                        <td>STAN</td>
                                        <td>Fixed (6)</td>
                                        <td>System Trace Audit Number.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">DE 39</td>
                                        <td>Response Code</td>
                                        <td>Fixed (2)</td>
                                        <td>00 = Approved, 05 = Declined, etc.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Call to Action -->
                    <div class="simulator-cta-box">
                        <h3>Ready to decode?</h3>
                        <p>Use our <strong class="text-gradient">ISO 8583 Visual Parser</strong> to break down a raw message and see these fields in real-time.</p>
                        <a href="/tools/iso8583-parser.php" class="btn-primary">Open Parser <i class="fa-solid fa-arrow-right"></i></a>
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
    .doc-section { margin-bottom: 50px; }
    .doc-section h2 { font-size: 1.6rem; color: var(--text-bright); margin-bottom: 20px; }
    .doc-section p { font-size: 1rem; line-height: 1.7; margin-bottom: 20px; }

    /* Technical Tables */
    .tech-table-wrapper {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        margin: 20px 0;
    }

    .tech-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.9rem;
    }

    .tech-table th {
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
    }

    .tech-table td {
        padding: 15px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .code-cell {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: var(--accent-primary);
        background: rgba(99, 102, 241, 0.05);
        width: 120px;
    }

    .highlight {
        color: var(--accent-primary);
        font-weight: 600;
    }

    /* Info Card */
    .info-card {
        background: rgba(99, 102, 241, 0.1);
        border-left: 4px solid var(--accent-primary);
        padding: 20px;
        border-radius: 8px;
        display: flex;
        gap: 15px;
        align-items: center;
        margin: 20px 0;
        color: var(--text-main);
    }

    .info-card i { color: var(--accent-primary); font-size: 1.2rem; }

    /* CTA Box */
    .simulator-cta-box {
        margin-top: 60px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.1));
        border: 1px solid var(--accent-primary);
        padding: 30px;
        border-radius: 24px;
        text-align: center;
    }

    .simulator-cta-box h3 { margin-bottom: 10px; color: var(--text-bright); }
    .simulator-cta-box p { margin-bottom: 20px; color: var(--text-muted); }

    @media (max-width: 992px) {
        .docs-layout { grid-template-columns: 1fr; }
        .docs-sidebar { position: relative; top: 0; }
    }
</style>

<?php include '../includes/footer.php'; ?>
