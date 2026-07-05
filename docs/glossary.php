<?php
$pageTitle = 'Payments Glossary';
$pageDescription = 'Definitions of key card payment and fintech terms — from acquirer and BIN to cryptogram and TLV.';
include '../includes/header.php';
?>


<div class="page-wrapper">
    <section class="docs-section">
        <div class="container docs-layout">
            
            <!-- SIDEBAR NAVIGATION (shared partial) -->
            <?php $activeDoc = 'glossary'; include '../includes/docs-sidebar.php'; ?>

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
