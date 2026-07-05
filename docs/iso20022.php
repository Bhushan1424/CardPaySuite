<?php include '../includes/header.php'; ?>


<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">

            <!-- SIDEBAR NAVIGATION (shared partial) -->
            <?php $activeDoc = 'iso20022'; include '../includes/docs-sidebar.php'; ?>

            <!-- MAIN CONTENT AREA -->
            <main class="docs-content glass-panel">
                <div class="content-header">
                    <h1 class="text-gradient">The ISO 20022 Standard</h1>
                    <p class="docs-subtitle">The modern, data-rich messaging standard replacing legacy formats across payments, securities, and trade — the new common language of global finance.</p>
                </div>

                <div class="content-body">

                    <!-- Intro Section -->
                    <section class="doc-section">
                        <h2>What is ISO 20022?</h2>
                        <p>ISO 20022 is an open international standard for exchanging financial messages. Unlike the fixed, compact fields of ISO 8583, it uses <strong>structured XML</strong> built on a shared data dictionary, so every message carries rich, self-describing information. It powers SEPA in Europe, instant payment schemes worldwide, and the SWIFT cross-border migration from legacy MT messages to modern <span class="highlight">MX messages</span>.</p>
                    </section>

                    <!-- Business Areas Section -->
                    <section class="doc-section">
                        <h2>1. Message Families (Business Areas)</h2>
                        <p>Every ISO 20022 message belongs to a <strong>business area</strong>, identified by a four-letter code. These are the families you will meet most often in payments:</p>

                        <div class="tech-table-wrapper">
                            <table class="tech-table">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Business Area</th>
                                        <th>Example Use Case</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="code-cell">pain</td>
                                        <td>Payments Initiation</td>
                                        <td>A company instructs its bank to pay salaries.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">pacs</td>
                                        <td>Payments Clearing &amp; Settlement</td>
                                        <td>Bank-to-bank credit transfer over a clearing network.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">camt</td>
                                        <td>Cash Management</td>
                                        <td>End-of-day account statement or payment status report.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">acmt</td>
                                        <td>Account Management</td>
                                        <td>Opening or modifying a bank account.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">remt</td>
                                        <td>Remittance Advice</td>
                                        <td>Detailed invoice data travelling with a payment.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Message ID Anatomy Section -->
                    <section class="doc-section">
                        <h2>2. Anatomy of a Message Identifier</h2>
                        <p>Each message type has a precise identifier, e.g. <span class="highlight">pacs.008.001.08</span> — the workhorse "customer credit transfer" that moves money between banks. Reading it left to right:</p>

                        <div class="tech-table-wrapper">
                            <table class="tech-table">
                                <thead>
                                    <tr>
                                        <th>Part</th>
                                        <th>Name</th>
                                        <th>Meaning</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="code-cell">pacs</td>
                                        <td>Business Area</td>
                                        <td>Payments Clearing &amp; Settlement family.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">008</td>
                                        <td>Message Number</td>
                                        <td>FI-to-FI Customer Credit Transfer.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">001</td>
                                        <td>Variant</td>
                                        <td>A flavour of the message for a specific community.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">08</td>
                                        <td>Version</td>
                                        <td>The 8th published version of this schema.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="info-card">
                            <i class="fa-solid fa-sitemap"></i>
                            <p><strong>Inside the XML:</strong> every message starts with a <span class="highlight">Group Header</span> (message ID, creation timestamp, settlement info) followed by one or more <span class="highlight">Transaction blocks</span> carrying debtor, creditor, amount, and remittance details.</p>
                        </div>
                    </section>

                    <!-- Key Elements Section -->
                    <section class="doc-section">
                        <h2>3. Key Elements of a Credit Transfer (pacs.008)</h2>
                        <p>ISO 20022 uses nested, named XML elements instead of numbered fields. These are the elements that do the heavy lifting in a credit transfer:</p>

                        <div class="tech-table-wrapper">
                            <table class="tech-table">
                                <thead>
                                    <tr>
                                        <th>Element</th>
                                        <th>Name</th>
                                        <th>Purpose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="code-cell">&lt;GrpHdr&gt;</td>
                                        <td>Group Header</td>
                                        <td>Message ID, creation time, number of transactions.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">&lt;EndToEndId&gt;</td>
                                        <td>End-to-End ID</td>
                                        <td>Reference that survives the whole payment chain.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">&lt;IntrBkSttlmAmt&gt;</td>
                                        <td>Settlement Amount</td>
                                        <td>Amount and currency settled between banks.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">&lt;Dbtr&gt; / &lt;Cdtr&gt;</td>
                                        <td>Debtor / Creditor</td>
                                        <td>Structured name and address of payer and payee.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">&lt;DbtrAgt&gt; / &lt;CdtrAgt&gt;</td>
                                        <td>Debtor / Creditor Agent</td>
                                        <td>The banks on each side, identified by BIC.</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">&lt;RmtInf&gt;</td>
                                        <td>Remittance Information</td>
                                        <td>What the payment is for — invoice numbers, references.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Comparison Section -->
                    <section class="doc-section">
                        <h2>4. ISO 8583 vs ISO 20022</h2>
                        <p>Both standards move money, but they were designed decades apart and it shows:</p>

                        <div class="tech-table-wrapper">
                            <table class="tech-table">
                                <thead>
                                    <tr>
                                        <th>Aspect</th>
                                        <th>ISO 8583</th>
                                        <th>ISO 20022</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="code-cell">Format</td>
                                        <td>Compact bitmap + numbered fields</td>
                                        <td>Structured XML with named elements</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">Domain</td>
                                        <td>Card payments (ATM, POS)</td>
                                        <td>Account-to-account, securities, trade</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">Data richness</td>
                                        <td>Minimal — sized for 1980s networks</td>
                                        <td>Rich — full remittance &amp; party data</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">Readability</td>
                                        <td>Needs a parser and a spec</td>
                                        <td>Human-readable element names</td>
                                    </tr>
                                    <tr>
                                        <td class="code-cell">Typical rails</td>
                                        <td>Visa, Mastercard, ATM switches</td>
                                        <td>SWIFT MX, SEPA, instant payment schemes</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="info-card">
                            <i class="fa-solid fa-lightbulb"></i>
                            <p><strong>They coexist:</strong> your card tap still travels as ISO 8583 today, while the bank-to-bank settlement behind it increasingly rides ISO 20022 rails. Card networks are also exploring ISO 20022 for clearing.</p>
                        </div>
                    </section>

                    <!-- Call to Action -->
                    <div class="simulator-cta-box">
                        <h3>Ready to decode?</h3>
                        <p>Use our <strong class="text-gradient">ISO 20022 Message Parser</strong> to break down a pacs.008 XML message and see these elements in real-time.</p>
                        <a href="/tools/iso20022-parser.php" class="btn-primary">Open Parser <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                </div>
            </main>

        </div>
    </section>
</div>


<?php include '../includes/footer.php'; ?>
