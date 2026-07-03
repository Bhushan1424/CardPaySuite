<?php include '../includes/header.php'; ?>


<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">
            
            <!-- SIDEBAR NAVIGATION (shared partial) -->
            <?php $activeDoc = 'iso8583'; include '../includes/docs-sidebar.php'; ?>

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


<?php include '../includes/footer.php'; ?>
