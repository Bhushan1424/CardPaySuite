<?php
// Cookie consent banner. Renders only when GA4 is configured (otherwise there are
// no analytics cookies to consent to). Styles live in assets/css/components.css;
// the consent logic + gated GA loader live in assets/js/consent.js.
if (!empty($analytics_config['ga_measurement_id'])):
?>
<div id="cookie-consent" class="cookie-consent" role="dialog" aria-live="polite" aria-label="Cookie consent">
    <p class="cookie-text">
        We use <strong>Google Analytics</strong> cookies to understand how the site is used.
        No personal data is sold. You can decline and keep browsing.
    </p>
    <div class="cookie-actions">
        <button id="cookie-decline" class="cookie-btn cookie-decline" type="button">Decline</button>
        <button id="cookie-accept" class="cookie-btn cookie-accept" type="button">Accept</button>
    </div>
</div>
<script src="/assets/js/consent.js"></script>
<?php endif; ?>
