/*
    CARDPAY SUITE - Shared Luhn (Mod 10) utility
    Single source of truth for card-number checksum logic.
    Exposed on window.CardPay so plain <script> pages can reuse it
    without a module system (the project has no build step).
*/
window.CardPay = window.CardPay || {};

/**
 * Validate a full card number against the Luhn checksum.
 * Non-digits are ignored, so "4111 1111 1111 1111" is accepted.
 * @param {string} value
 * @returns {boolean} true when the number passes Mod 10.
 */
window.CardPay.luhnValid = function (value) {
    var num = String(value).replace(/\D/g, "");
    if (num.length === 0) return false;

    var sum = 0;
    var shouldDouble = false;
    for (var i = num.length - 1; i >= 0; i--) {
        var digit = parseInt(num.charAt(i), 10);
        if (shouldDouble) {
            digit *= 2;
            if (digit > 9) digit -= 9;
        }
        sum += digit;
        shouldDouble = !shouldDouble;
    }
    return sum % 10 === 0;
};

/**
 * Compute the Luhn check digit for a partial number (everything except
 * the final digit). Used to generate valid test card numbers.
 * @param {string} partial
 * @returns {number} the check digit 0-9.
 */
window.CardPay.luhnCheckDigit = function (partial) {
    var num = String(partial).replace(/\D/g, "");

    var sum = 0;
    var alt = true;
    for (var i = num.length - 1; i >= 0; i--) {
        var n = parseInt(num.charAt(i), 10);
        if (alt) {
            n *= 2;
            if (n > 9) n -= 9;
        }
        sum += n;
        alt = !alt;
    }
    return (10 - (sum % 10)) % 10;
};
