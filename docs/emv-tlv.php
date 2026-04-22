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
                        <a href="iso8583.php" class="nav-item"><i class="fa-solid fa-code"></i> ISO 8583 Standard</a>
                        <a href="emv-tlv.php" class="nav-item active"><i class="fa-solid fa-microchip"></i> EMV & TLV Logic</a>
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
                    <h1 class="text-gradient">EMV & TLV Logic</h1>
                    <p class="docs-subtitle">Understanding the "Language of the Chip." How EMV cards store and transmit data using the Tag-Length-Value format.</p>
                </div>

                <div class="content-body">
                    
                    <!-- Intro Section -->
                    <section class="doc-section">
                        <h2 id="what-is-tlv">What is TLV?</h2>
                        <p>Unlike the fixed-length fields of ISO 8583, EMV (Europay, Mastercard, and Visa) uses a flexible format called <strong class="highlight">TLV</strong>. This allows cards to send different amounts of data depending on the transaction type.</p>
                    </section>

                    <!-- TLV VISUAL BREAKDOWN -->
                    <section class="doc-section">
                        <h2>How a TLV Object Works</h2>
                        <p>Every piece of data on a chip card is wrapped in a "TLV Envelope." Here is the breakdown of a single data element:</p>
                        
                        <div class="tlv-visual-box">
                            <div class="tlv-component tag">
                                <span class="comp-label">TAG</span>
                                <span class="comp-value">9F 02</span>
                                <span class="comp-desc">The "ID" of the data</span>
                            </div>
                            <div class="tlv-arrow"><i class="fa-solid fa-chevron-right"></i></div>
                            <div class="tlv-component length">
                                <span class="comp-label">LENGTH</span>
                                <span class="comp-value">06</span>
                                <span class="comp-desc">How many bytes follow</span>
                            </div>
                            <div class="tlv-arrow"><i class="fa-solid fa-chevron-right"></i></div>
                            <div class="tlv-component value">
                                <span class="comp-label">VALUE</span>
                                <span class="comp-value">00 00 00 00 01 00</span>
                                <span class="comp-desc">The actual data (Amount)</span>
                            </div>
                        </div>
                    </section>

                    <!-- Technical Logic -->
                    <section class="doc-section">
                        <h2>Tagging Rules</h2>
                        <p>EMV tags are not just random numbers; they follow specific binary rules. Tags can be <strong>Primitive</strong> (simple values) or <strong>Constructed</strong> (tags that contain other tags inside them).</p>
                        
                        <div class="info-card">
                            <i class="fa-solid fa-circle-info"></i>
                            <p><strong>Pro Tip:</strong> If the first byte of a tag has bits 5-1 set to 1, it is a multi-byte tag. This allows the EMV standard to support thousands of unique data fields.</p>
                        </div>
                    </section>

                    <!-- Common EMV Tags Table -->
                    <section class="doc-section">
                        <h2>Common EMV Tags</h2>
                        <p>These are the most frequent tags you will encounter when parsing chip data:</p>

                        <div class="tech-table-wrapper">
                            <table class="tech-table">
                                <thead>
                                    <tr>
                                        <th>Tag</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="code-cell">5A</td>
                                        <td>Application PAN</td>
                                        <td>The Primary Account Number of the card.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">5F24</td>
                                        <td>Application Expiry Date</td>
                                        <td>The expiration date of the card.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">9F02</td>
                                        <td>Amount, Authorized</td>
                                        <td>The transaction amount.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">9F36</td>
                                        <td>Application Transaction Counter</td>
                                        <td>Increments every time the card is used.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">C4</td>
                                        <td>Application Identifier (AID)</td>
                                        <td>Identifies the payment application on the chip.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- CTA -->
                    <div class="simulator-cta-box">
                        <h3>Test Your Knowledge</h3>
                        <p>Paste a raw hex stream into our parser to see the TLV logic in action.</p>
                        <a href="/tools/tlv.php" class="btn-primary">Open TLV Parser <i class="fa-solid fa-arrow-right"></i></a>
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

    /* --- TLV Visual Breakdown --- */
    .tlv-visual-box {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        padding: 40px 20px;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        margin: 30px 0;
    }

    .tlv-component {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        border-radius: 12px;
        min-width: 140px;
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .tlv-component .comp-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .tlv-component .comp-value {
        font-family: 'Courier New', monospace;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-bright);
        margin-bottom: 8px;
    }

    .tlv-component .comp-desc {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-align: center;
        line-height: 1.2;
    }

    .tlv-component.tag { background: rgba(99, 102, 241, 0.15); border-color: var(--accent-primary); }
    .tlv-component.length { background: rgba(168, 85, 247, 0.15); border-color: var(--accent-secondary); }
    .tlv-component.value { background: rgba(6, 182, 212, 0.15); border-color: #06b6d4; }

    .tlv-arrow {
        color: var(--text-muted);
        font-size: 1.2rem;
    }

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
        width: 100px;
    }

    .highlight {
        color: var(--accent-primary);
        font-weight: 600;
    }

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
        .tlv-visual-box { flex-direction: column; gap: 20px; }
        .tlv-arrow { transform: rotate(90deg); }
    }
</style>

<?php include '../includes/footer.php'; ?>
