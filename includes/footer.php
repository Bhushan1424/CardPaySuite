<footer class="site-footer glass-panel">
    <div class="container footer-content">
        <div class="footer-left">
            <p>© 2026 <strong>Card Pay Suite</strong> <span class="badge">v1.0.0-beta</span></p>
        </div>
    </div>
</footer>

<!-- AI WIDGET (styles: assets/css/ai-guide.css, linked globally in header.php) -->
<div id="ai-guide-widget">
    <div id="ai-trigger" class="ai-fab">
        <div class="fab-inner"><i class="fa-solid fa-robot"></i></div>
        <div class="fab-glow"></div>
    </div>

    <div id="ai-window" class="ai-window glass-panel">
        <div class="ai-header">
            <div class="header-info">
                <div class="status-dot"></div>
                <span>Fintech Guide AI</span>
            </div>
            <button id="close-ai" class="close-btn">&times;</button>
        </div>
        <div id="ai-messages" class="ai-messages">
            <div class="msg-bubble ai-msg">
                Hello! I am your CardPay AI expert. Ask me anything about ISO 8583, EMV TLV, or payment flows! 🚀
            </div>
        </div>
        <div id="ai-typing" class="typing-indicator" style="display: none;">
            <span></span><span></span><span></span>
        </div>
        <div class="ai-input-area">
            <input type="text" id="ai-input" placeholder="Ask a technical question..." autocomplete="off">
            <button id="send-ai-btn" class="btn-primary">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script src="/assets/js/ai-guide.js"></script>
<?php include __DIR__ . '/consent-banner.php'; ?>
</body>
</html>
