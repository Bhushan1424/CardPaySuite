<?php include 'includes/header.php'; ?>

<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container" style="max-width: 820px;">

            <header class="tools-header" style="text-align: center;">
                <h1 class="text-gradient">Privacy Policy</h1>
                <p class="tools-subtitle">How CardPay Suite handles data. Last updated 4 July 2026.</p>
            </header>

            <div class="glass-panel" style="padding: 32px;">

                <div class="doc-section">
                    <h2>Who we are</h2>
                    <p>
                        CardPay Suite is a free, educational website for learning payment-processing
                        concepts (ISO 8583, EMV TLV, the transaction lifecycle). It is <strong>not</strong>
                        a real payment processor — every "transaction" is simulated in your browser or
                        proxied to read-only lookup APIs. We do not ask you to create an account and we
                        do not collect your name, email, or real card details.
                    </p>
                </div>

                <div class="doc-section">
                    <h2>What we collect</h2>
                    <p>
                        <strong>Analytics (only with your consent).</strong> If you click "Accept" on the
                        cookie banner, we load Google Analytics 4, which sets cookies to measure aggregate,
                        anonymous usage — pages viewed, approximate country, device and browser type. If you
                        Decline (or ignore the banner), Google Analytics is never loaded and no analytics
                        cookies are set.
                    </p>
                    <p>
                        <strong>Abuse protection (legitimate interest, no cookie).</strong> Our API proxies
                        apply rate limiting to protect against abuse. To do this we compute a salted,
                        daily-rotating hash of your IP address and browser. We <strong>do not store your raw
                        IP address</strong>, and this value is not used to identify you — it only counts
                        requests within a short window and rotates every day.
                    </p>
                </div>

                <div class="doc-section">
                    <h2>Data you send to third parties</h2>
                    <p>When you use certain tools, your input is forwarded to third-party services to return a result:</p>
                    <ul style="color: var(--text-main); line-height: 1.8; padding-left: 20px;">
                        <li><strong>AI Guide</strong> — your question is sent to <strong>Groq</strong> to generate an answer.</li>
                        <li><strong>BIN Lookup</strong> — the BIN digits you enter are sent to <strong>HandyAPI</strong>.</li>
                        <li><strong>News</strong> — headlines are fetched from <strong>GNews</strong>.</li>
                        <li><strong>Delivery</strong> — the site is served via <strong>Cloudflare</strong>; fonts and icons load from <strong>Google Fonts</strong> and <strong>Font Awesome</strong> CDNs.</li>
                    </ul>
                    <p>
                        Because this is an educational tool, please do not enter real card numbers or any
                        personal or sensitive data into the simulators.
                    </p>
                </div>

                <div class="doc-section">
                    <h2>Cookies &amp; your choices</h2>
                    <p>
                        The only cookies we set are Google Analytics cookies, and only after you Accept.
                        You can withdraw consent at any time by clearing this site's cookies and site data
                        in your browser — you will then be asked again on your next visit. You can also opt
                        out of Google Analytics across all sites using Google's
                        <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener" class="cookie-link">opt-out browser add-on</a>.
                    </p>
                </div>

                <div class="doc-section">
                    <h2>Selling &amp; retention</h2>
                    <p>
                        We do not sell your data. Analytics data is aggregate and subject to Google's
                        privacy policies. Our internal rate-limit and usage logs are pseudonymous
                        (no raw IP) and short-lived.
                    </p>
                </div>

                <div class="doc-section">
                    <h2>Contact</h2>
                    <p>
                        Questions about this policy? Reach us at
                        <a href="mailto:CONTACT_EMAIL_HERE" class="cookie-link">CONTACT_EMAIL_HERE</a>.
                        We may update this policy from time to time; the date at the top reflects the latest change.
                    </p>
                </div>

            </div>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
