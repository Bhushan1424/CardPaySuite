<?php include '../includes/header.php'; ?>


<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">
            
            <!-- SIDEBAR NAVIGATION (shared partial) -->
            <?php $activeDoc = 'emv-tlv'; include '../includes/docs-sidebar.php'; ?>

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


<?php include '../includes/footer.php'; ?>
