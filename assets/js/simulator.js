document.addEventListener("DOMContentLoaded", function () {
    let transactionRunning = false;
    let transactionApproved = false;
    let selectedItem = "";
    let selectedAmount = 0;

    // DOM Elements
    const products = document.querySelectorAll(".product-item");
    const amountDisplay = document.getElementById("amountValue");
    const terminalText = document.getElementById("terminalText");
    const posTerminal = document.getElementById("posTerminal");
    const resetBtn = document.getElementById("resetBtn");

    const resultItem = document.getElementById("resultItem");
    const resultAmount = document.getElementById("resultAmount");
    const resultStatus = document.getElementById("resultStatus");
    const authCode = document.getElementById("authCode");
    const responseText = document.getElementById("responseText");

    // Flow Messages Configuration
    const flowMessages = {
        merchant: "Customer initiates payment",
        acquirer: "Request sent to acquiring bank",
        switch: "Routed via switch",
        network: "Network validation",
        issuer: "Issuer decision",
    };

    /* --- PRODUCT SELECTION --- */
    products.forEach((product) => {
        product.addEventListener("click", function () {
            // Remove selected class from all
            products.forEach((p) => p.classList.remove("selected"));
            // Add to current
            this.classList.add("selected");

            selectedItem = this.dataset.name;
            selectedAmount = parseFloat(this.dataset.price);

            // Update UI
            amountDisplay.innerText = selectedAmount.toFixed(2);
            terminalText.innerText = "Tap POS to start";
            terminalText.style.color = "var(--primary)";
            terminalText.style.fontWeight = "600";
        });
    });

    /* --- POS CLICK --- */
    posTerminal.addEventListener("click", function () {
        if (!selectedItem) {
            alert("Please select a product first.");
            return;
        }

        if (transactionRunning) return;

        startTransaction();
    });

    /* --- RESET BUTTON --- */
    resetBtn.addEventListener("click", resetSimulator);

    /* --- TRANSACTION LOGIC --- */
    function startTransaction() {
        transactionRunning = true;
        terminalText.innerText = "Processing...";
        terminalText.style.color = "var(--secondary)";
        terminalText.style.fontWeight = "400";
        animateFlow();
    }

    function animateFlow() {
        const nodes = ["merchant", "acquirer", "switch", "network", "issuer"];

        nodes.forEach((node, index) => {
            setTimeout(() => {
                let el = document.getElementById(node);
                let arrow = document.getElementById("arrow-" + node);
                let box = document.getElementById("info-" + node);

                if (el) el.classList.add("active");
                if (arrow) arrow.classList.add("active-forward");

                if (box) {
                    box.innerText = flowMessages[node];
                    box.classList.add("active");
                }

                // Start reverse flow after last node
                if (index === nodes.length - 1) {
                    setTimeout(reverseFlow, 1000);
                }
            }, index * 900);
        });
    }

    function reverseFlow() {
        const nodes = ["issuer", "network", "switch", "acquirer", "merchant"];

        // Simulate Approval/Decline (70% chance of approval)
        transactionApproved = Math.random() > 0.3;

        nodes.forEach((node, index) => {
            setTimeout(() => {
                let arrow = document.getElementById("arrow-" + node);
                let box = document.getElementById("info-" + node);

                if (arrow) {
                    arrow.classList.remove("down", "active-forward");
                    arrow.classList.add("up");
                    arrow.classList.add(
                        transactionApproved ? "active-success" : "active-fail"
                    );
                }

                if (box) {
                    box.innerText = transactionApproved
                        ? "Approved (00)"
                        : "Declined (05)";
                    box.style.borderColor = transactionApproved
                        ? "var(--success)"
                        : "var(--error)";
                    box.style.color = transactionApproved
                        ? "var(--success)"
                        : "var(--error)";
                }

                if (index === nodes.length - 1) {
                    setTimeout(showResult, 800);
                }
            }, index * 900);
        });
    }

    function showResult() {
        const approved = transactionApproved;

        resultItem.innerText = selectedItem;
        resultAmount.innerText = selectedAmount.toFixed(2);

        if (approved) {
            resultStatus.innerText = "APPROVED";
            resultStatus.className = "approved";
            authCode.innerText = Math.floor(100000 + Math.random() * 900000);
            responseText.innerText = "00 Approved";
        } else {
            resultStatus.innerText = "DECLINED";
            resultStatus.className = "declined";
            authCode.innerText = "-";
            responseText.innerText = "05 Declined";
        }

        transactionRunning = false;
    }

    function resetSimulator() {
        const nodes = ["merchant", "acquirer", "switch", "network", "issuer"];

        nodes.forEach((node) => {
            let el = document.getElementById(node);
            if (el) el.classList.remove("active");

            let arrow = document.getElementById("arrow-" + node);
            if (arrow) {
                arrow.classList.remove(
                    "up",
                    "active-forward",
                    "active-success",
                    "active-fail"
                );
                arrow.classList.add("down");
            }

            let box = document.getElementById("info-" + node);
            if (box) {
                box.innerText = "";
                box.classList.remove("active");
                box.style.borderColor = "var(--border)";
                box.style.color = "var(--secondary)";
            }
        });

        terminalText.innerText = "Select product";
        terminalText.style.color = "var(--secondary)";
        terminalText.style.fontWeight = "400";

        resultStatus.innerText = "Waiting";
        resultStatus.className = "";
        resultItem.innerText = "-";
        resultAmount.innerText = "-";
        authCode.innerText = "----";
        responseText.innerText = "-";

        // Reset Products
        products.forEach((p) => p.classList.remove("selected"));
        selectedItem = "";
        selectedAmount = 0;
        amountDisplay.innerText = "0.00";

        transactionRunning = false;
    }
});