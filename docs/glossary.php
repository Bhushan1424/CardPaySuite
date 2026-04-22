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
                        <a href="emv-tlv.php" class="nav-item"><i class="fa-solid fa-microchip"></i> EMV & TLV Logic</a>
                    </div>

                    <div class="nav-group">
                        <span class="group-title">Reference</span>
                        <a href="glossary.php" class="nav-item active"><i class="fa-solid fa-list"></i> Glossary of Terms</a>
                    </div>
                </nav>
            </aside>

            <!-- MAIN CONTENT AREA -->
            <main class="docs-content glass-panel">
                <div class="content-header">
                    <h1 class="text-gradient">Fintech Glossary</h1>
                    <p class="docs-subtitle">A comprehensive directory of terms, acronyms, and standards used in the global payment ecosystem.</p>
                </div>

                <!-- SEARCH BAR -->
                <div class="glossary-search-container">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="glossarySearch" placeholder="Search for a term (e.g. BIN, MTI, Acquirer)..." onkeyup="filterGlossary()">
                    </div>
                </div>

                <!-- GLOSSARY GRID -->
                <div class="glossary-grid" id="glossaryGrid">
                    
                    <!-- Entity: Acquirer -->
                    <div class="glossary-item" data-term="acquirer bank acquiring">
                        <div class="term-header">
                            <span class="term-name">Acquirer</span>
                            <span class="term-category">Entity</span>
                        </div>
                        <p class="term-desc">The financial institution that maintains the merchant's account and processes credit or debit card payments on the merchant's behalf.</p>
                    </div>

                    <!-- Entity: Issuer -->
                    <div class="glossary-item" data-term="issuer bank issuing">
                        <div class="term-header">
                            <span class="term-name">Issuer</span>
                            <span class="term-category">Entity</span>
                        </div>
                        <p class="term-desc">The bank that issued the card to the customer and is responsible for authorizing transactions and providing the funds.</p>
                    </div>

                    <!-- Technical: MTI -->
                    <div class="glossary-item" data-term="mti message type indicator iso8583">
                        <div class="term-header">
                            <span class="term-name">MTI</span>
                            <span class="term-category">ISO 8583</span>
                        </div>
                        <p class="term-desc">Message Type Indicator. A 4-digit numeric field that defines the general function of the ISO 8583 message (e.g., 0200 for Financial Request).</p>
                    </div>

                    <!-- Technical: BIN -->
                    <div class="glossary-item" data-term="bin bank identification number">
                        <div class="term-header">
                            <span class="term-name">BIN</span>
                            <span class="term-category">Standard</span>
                        </div>
                        <p class="term-desc">Bank Identification Number. The first 6 to 8 digits of a card number used to identify the issuing bank and card network.</p>
                    </div>

                    <!-- Technical: STAN -->
                    <div class="glossary-item" data-term="stan system trace audit number">
                        <div class="term-header">
                            <span class="term-name">STAN</span>
                            <span class="term-category">ISO 8583</span>
                        </div>
                        <p class="term-desc">System Trace Audit Number. A unique number assigned by the terminal to identify a specific transaction for auditing purposes.</p>
                    </div>

                    <!-- Technical: TLV -->
                    <div class="glossary-item" data-term="tlv tag length value emv">
                        <div class="term-header">
                            <span class="term-name">TLV</span>
                            <span class="term-category">EMV</span>
                        </div>
                        <p class="term-desc">Tag-Length-Value. A data format used in EMV chip cards to store information in a flexible, self-describing structure.</p>
                    </div>

                    <!-- Technical: PAN -->
                    <div class="glossary-item" data-term="pan primary account number">
                        <div class="term-header">
                            <span class="term-name">PAN</span>
                            <span class="term-category">Standard</span>
                        </div>
                        <p class="term-desc">Primary Account Number. The long number displayed on the front of terms, which uniquely identifies the cardholder's account.</p>
                    </div>

                    <!-- Logic: Switch -->
                    <div class="glossary-item" data-term="switch routing network">
                        <div class="term-header">
                            <span class="term-name">Payment Switch</span>
                            <span class="term-category">Entity</span>
                        </div>
                        <p class="term-desc">A routing system that directs payment messages between acquirers, networks, and issuers based on the BIN.</p>
                    </div>

                    <!-- Logic: Authorization -->
                    <div class="glossary-item" data-term="authorization approval decline">
                        <div class="term-header">
                            <span class="term-name">Authorization</span>
                            <span class="term-category">Process</span>
                        </div>
                        <p class="term-desc">The process of verifying that a card is valid and that the account holder has sufficient funds to cover the transaction.</p>
                    </div>

                    <!-- Logic: Settlement -->
                    <div class="glossary-item" data-term="settlement clearing funds">
                        <div class="term-header">
                            <span class="term-name">Settlement</span>
                            <span class="term-category">Process</span>
                        </div>
                        <p class="term-desc">The final transfer of funds from the Issuer bank to the Acquirer bank after a batch of transactions is processed.</p>
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

    /* --- Search Bar --- */
    .glossary-search-container {
        margin-bottom: 40px;
        display: flex;
        justify-content: center;
    }

    .search-box {
        position: relative;
        width: 100%;
        max-width: 500px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1rem;
    }

    .search-box input {
        width: 100%;
        padding: 15px 15px 15px 45px;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        color: white;
        font-size: 1rem;
        transition: var(--transition);
        outline: none;
    }

    .search-box input:focus {
        border-color: var(--accent-primary);
        box-shadow: 0 0 15px var(--accent-glow);
    }

    /* --- Glossary Grid --- */
    .glossary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .glossary-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        padding: 20px;
        border-radius: 16px;
        transition: all 0.3s ease;
        animation: fadeIn 0.4s ease;
    }

    .glossary-item:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--accent-primary);
        transform: translateY(-5px);
    }

    .term-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .term-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-bright);
    }

    .term-category {
        font-size: 0.65rem;
        text-transform: uppercase;
        background: var(--accent-primary);
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .term-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin: 0;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @media (max-width: 992px) {
        .docs-layout { grid-template-columns: 1fr; }
        .docs-sidebar { position: relative; top: 0; }
    }
</style>

<script>
function filterGlossary() {
    const query = document.getElementById("glossarySearch").value.toLowerCase();
    const items = document.querySelectorAll(".glossary-item");
    
    items.forEach(item => {
        const tags = item.getAttribute("data-term").toLowerCase();
        if (tags.includes(query)) {
            item.style.display = "block";
            item.style.opacity = "1";
        } else {
            item.style.display = "none";
            item.style.opacity = "0";
        }
    });
}
</script>

<?php include '../includes/footer.php'; ?>
