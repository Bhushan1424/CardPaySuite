/*
    CARDPAY SUITE - Cookie consent + consent-gated Google Analytics loader.
    GA4 (gtag.js) is loaded ONLY after the visitor explicitly accepts. Declining or
    ignoring the banner means gtag.js never loads and no GA cookies are set.
    The choice is remembered in localStorage ('cps_consent' = granted | denied).
    No dependencies.
*/
(function () {
    var KEY = "cps_consent";

    function loadGA() {
        if (!window.CPS_GA_ID || window.__cpsGaLoaded) {
            return;
        }
        window.__cpsGaLoaded = true;

        var s = document.createElement("script");
        s.async = true;
        s.src = "https://www.googletagmanager.com/gtag/js?id=" + encodeURIComponent(window.CPS_GA_ID);
        document.head.appendChild(s);

        window.dataLayer = window.dataLayer || [];
        window.gtag = function () { window.dataLayer.push(arguments); };
        window.gtag("js", new Date());
        window.gtag("config", window.CPS_GA_ID);
    }

    function readChoice() {
        try { return localStorage.getItem(KEY); } catch (e) { return null; }
    }
    function saveChoice(v) {
        try { localStorage.setItem(KEY, v); } catch (e) {}
    }

    document.addEventListener("DOMContentLoaded", function () {
        var choice = readChoice();

        // Returning visitor who already decided.
        if (choice === "granted") { loadGA(); return; }
        if (choice === "denied") { return; }

        // Nothing to consent to if GA isn't configured.
        if (!window.CPS_GA_ID) { return; }

        var banner = document.getElementById("cookie-consent");
        if (!banner) { return; }
        banner.classList.add("show");

        function decide(value) {
            saveChoice(value);
            banner.classList.remove("show");
            if (value === "granted") { loadGA(); }
        }

        var accept = document.getElementById("cookie-accept");
        var decline = document.getElementById("cookie-decline");
        if (accept) { accept.addEventListener("click", function () { decide("granted"); }); }
        if (decline) { decline.addEventListener("click", function () { decide("denied"); }); }
    });
})();
