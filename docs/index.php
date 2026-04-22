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
                        <a href="index.php" class="nav-item active"><i class="fa-solid fa-book-open"></i> Introduction</a>
                        <a href="transaction-lifecycle.php" class="nav-item"><i class="fa-solid fa-route"></i> Transaction Flow</a>
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

<style>
    /* --- Documentation Layout --- */
    .docs-section {
        padding: 60px 0;
        color: var(--text-main);
    }

    .docs-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* Sidebar Styling */
    .docs-sidebar {
        padding: 20px;
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .sidebar-header h3 {
        font-size: 1.1rem;
        color: var(--accent-primary);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .nav-group {
        margin-bottom: 25px;
    }

    .group-title {
        display: block;
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 1px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        border-radius: 8px;
        transition: var(--transition);
        margin-bottom: 4px;
    }

    .nav-item:hover, .nav-item.active {
        background: rgba(99, 102, 241, 0.1);
        color: var(--accent-primary);
    }

    /* Content Area */
    .docs-content {
        padding: 40px;
    }

    .content-header {
        margin-bottom: 40px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 30px;
    }

    .content-header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .docs-subtitle {
        font-size: 1.1rem;
        color: var(--text-muted);
    }

    .doc-section {
        margin-bottom: 40px;
    }

    .doc-section h2 {
        font-size: 1.5rem;
        color: var(--text-bright);
        margin-bottom: 15px;
    }

    .doc-section p {
        font-size: 1rem;
        line-height: 1.7;
        color: var(--text-main);
    }

    /* Info Callout Box */
    .info-card {
        background: rgba(99, 102, 241, 0.1);
        border-left: 4px solid var(--accent-primary);
        padding: 20px;
        border-radius: 8px;
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 30px;
        color: var(--text-main);
    }

    .info-card i {
        color: var(--accent-primary);
        font-size: 1.2rem;
    }

    /* Pillars Grid */
    .pillars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .pillar-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        padding: 20px;
        border-radius: 16px;
        text-align: center;
        transition: var(--transition);
    }

    .pillar-item:hover {
        border-color: var(--accent-primary);
        transform: translateY(-5px);
    }

    .pillar-item i {
        font-size: 2rem;
        color: var(--accent-primary);
        margin-bottom: 15px;
        display: block;
    }

    .pillar-item h4 {
        color: var(--text-bright);
        margin-bottom: 10px;
    }

    .pillar-item p {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    @media (max-width: 992px) {
        .docs-layout {
            grid-template-columns: 1fr;
        }
        .docs-sidebar {
            position: relative;
            top: 0;
        }
    }
</style>

<?php include '../includes/footer.php'; ?>
