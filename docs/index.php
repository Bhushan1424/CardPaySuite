<?php
$pageTitle = 'Learning Center';
$pageDescription = 'Learn payment processing from the ground up — acquirers, issuers, switches, ISO 8583, EMV, and ISO 20022 explained with clear, interactive guides.';
include '../includes/header.php';
?>

<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">

            <!-- SIDEBAR NAVIGATION (shared partial) -->
            <?php $activeDoc = 'index'; include '../includes/docs-sidebar.php'; ?>

            <!-- MAIN CONTENT AREA -->
            <main class="docs-content glass-panel">
                <div class="content-header">
                    <h1 class="text-gradient">Welcome to the Learning Center</h1>
                    <p class="docs-subtitle">Master the complexities of global payment processing through interactive guides and technical breakdowns.</p>
                </div>

                <div class="content-body">
                    <div class="info-card">
                        <i class="fa-solid fa-lightbulb"></i>
                        <p><strong>Pro Tip:</strong> Use the <strong>Transaction Simulator</strong> on the home page to see these concepts in action as you read through the guides.</p>
                    </div>

                    <section class="doc-section">
                        <h2>What is Payment Processing?</h2>
                        <p>At its core, payment processing is the movement of information and money from a customer's bank account to a merchant's account. While it happens in milliseconds, it involves a complex relay of messages across multiple entities.</p>
                    </section>

                    <section class="doc-section">
                        <h2>The Core Pillars</h2>
                        <div class="pillars-grid">
                            <div class="pillar-item">
                                <i class="fa-solid fa-building"></i>
                                <h4>The Acquirer</h4>
                                <p>The bank that processes payments on behalf of the merchant.</p>
                            </div>
                            <div class="pillar-item">
                                <i class="fa-solid fa-shuffle"></i>
                                <h4>The Switch</h4>
                                <p>The routing engine that directs messages to the correct network.</p>
                            </div>
                            <div class="pillar-item">
                                <i class="fa-solid fa-credit-card"></i>
                                <h4>The Issuer</h4>
                                <p>The bank that issued the card and holds the customer's funds.</p>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

        </div>
    </section>
</div>


<?php include '../includes/footer.php'; ?>
