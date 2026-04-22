<footer class="site-footer glass-panel">
    <div class="container footer-content">
        <div class="footer-left">
            <p>© 2026 <strong>Card Pay Suite</strong> <span class="badge">v1.0.0-beta</span></p>
        </div>
    </div>
</footer>

<style>
    /* --- AI GUIDE WIDGET SYSTEM --- */
    #ai-guide-widget {
        position: fixed !important;
        bottom: 30px !important;
        right: 30px !important;
        z-index: 10001 !important;
        font-family: 'Inter', sans-serif;
        pointer-events: none; /* Prevents invisible box from blocking page clicks */
    }

    .ai-fab {
        position: relative;
        width: 60px; height: 60px;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        border-radius: 50%;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.27);
        pointer-events: auto; /* Re-enable clicks for the button */
        z-index: 100;
    }

    .fab-inner { color: white; font-size: 1.5rem; position: relative; z-index: 2; }

    .fab-glow {
        position: absolute;
        width: 100%; height: 100%;
        background: var(--accent-primary);
        border-radius: 50%;
        animation: fab-pulse 2s infinite;
        z-index: 1;
    }

    .ai-window {
        position: fixed !important;
        bottom: 100px !important;
        right: 30px !important;
        width: 350px; height: 500px;
        display: none; 
        flex-direction: column;
        background: rgba(15, 23, 42, 0.95) !important;
        backdrop-filter: blur(15px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        z-index: 10002 !important;
        overflow: hidden;
        pointer-events: auto;
    }

    .ai-header {
        padding: 20px; background: rgba(255, 255, 255, 0.05);
        display: flex; justify-content: space-between; align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .header-info { display: flex; align-items: center; gap: 10px; color: white; font-weight: 600; }
    .status-dot { width: 8px; height: 8px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 5px #4ade80; }
    
    .ai-messages { 
        flex: 1; padding: 20px; overflow-y: auto; 
        display: flex; flex-direction: column; gap: 15px; 
    }

    .msg-bubble { 
        max-width: 80%; padding: 12px 16px; 
        border-radius: 16px; font-size: 0.9rem; 
        line-height: 1.5; animation: fadeIn 0.3s ease;
    }

    .ai-msg { 
        background: rgba(255, 255, 255, 0.05); 
        color: #e2e8f0; align-self: flex-start; 
        border: 1px solid rgba(255, 255, 255, 0.1); 
        border-bottom-left-radius: 2px;
    }

    .user-msg { 
        background: linear-gradient(135deg, #6366f1, #a855f7); 
        color: white; align-self: flex-end; 
        border-bottom-right-radius: 2px;
    }

    .ai-input-area { 
        padding: 20px; display: flex; gap: 10px; 
        background: rgba(0, 0, 0, 0.2); 
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .ai-input-area input { 
        flex: 1; background: rgba(0, 0, 0, 0.3); 
        border: 1px solid rgba(255, 255, 255, 0.1); 
        border-radius: 12px; padding: 10px 15px; 
        color: white; outline: none; font-size: 0.9rem;
    }

    .ai-input-area input:focus { border-color: var(--accent-primary); }

    .close-btn { 
        background: none; border: none; color: #94a3b8; 
        cursor: pointer; font-size: 1.2rem; transition: var(--transition);
    }
    .close-btn:hover { color: white; }

    .typing-indicator {
        padding: 10px 20px; display: flex; gap: 4px;
    }
    .typing-indicator span {
        width: 6px; height: 6px; background: #94a3b8;
        border-radius: 50%; animation: blink 1.4s infinite both;
    }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes fab-pulse {
        0% { transform: scale(1); opacity: 0.6; }
        100% { transform: scale(1.6); opacity: 0; }
    }
    @keyframes blink {
        0%, 100% { opacity: 0.2; }
        20% { opacity: 1; }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- AI WIDGET -->
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
</body>
</html>
