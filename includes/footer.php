<footer class="site-footer glass-panel">
    <div class="container footer-content">
        <div class="footer-left">
            <p>© 2026 <strong>Card Pay Suite</strong> <span class="badge">v1.0.0-beta</span></p>
        </div>
        
        <div class="footer-links">
            <a href="/docs/index.php"><i class="fa-solid fa-book"></i> Documentation</a>
            <a href="/news.php"><i class="fa-solid fa-rss"></i> Updates</a>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        margin-top: 60px;
        padding: 25px 0;
        border-top: 1px solid var(--border-color);
        background: var(--glass-bg);
    }
    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .footer-links {
        display: flex;
        gap: 25px;
    }
    .footer-links a {
        color: var(--text-muted);
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .footer-links a:hover {
        color: var(--accent-primary);
    }
    .badge {
        font-size: 0.7rem;
        background: var(--bg-surface);
        padding: 2px 8px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        margin-left: 10px;
        vertical-align: middle;
    }
    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
    }
</style>
<!-- Global Tooltip Element -->
<div id="global-tooltip" class="node-tooltip">
    <h4 id="tt-title"></h4>
    <p id="tt-desc"></p>
    <div id="tt-iso" class="iso-info"></div>
</div>
</body>
</html>
