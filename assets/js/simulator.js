/**
 * CARDPAY SUITE - ROBUST TRANSACTION SIMULATOR
 * Version: 2.0 (Production Ready)
 * Features: Safe DOM updates, null-checks, and centralized UI management.
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log("CardPay Simulator: System Initialized ✅");

    // --- State Management ---
    let state = {
        transactionRunning: false,
        transactionApproved: false,
        selectedItem: "",
        selectedAmount: 0
    };

    // --- UI Utility: The "Safe Updater" ---
    // This solves the "Cannot set properties of null" error
    const updateUI = (id, value) => {
        const el = document.getElementById(id);
        if (el) {
            el.innerText = value;
        } else {
            console.warn(`[UI Warning] Element ID "${id}" not found in the current DOM.`);
        }
    };

    const updateClass = (id, className, action = 'add') => {
        const el = document.getElementById(id);
        if (el) {
            action === 'add' ? el.classList.add(className) : el.classList.remove(className);
        } else {
            console.warn(`[UI Warning] Element ID "${id}" not found for class update.`);
        }
    };

    // --- DOM Element Caching ---
    const elements = {
        products: document.querySelectorAll(".item-row"),
        amountDisplay: document.getElementById("amountValue"),
        terminalText: document.getElementById("terminalText"),
        posTerminal: document.getElementById("posTerminal"),
        resetBtn: document.getElementById("resetBtn"),
        loader: document.getElementById("loaderContainer"),
        techPanel: document.getElementById("techPanel")
    };

    // Flow Messages Configuration
    const flowMessages = {
        merchant: "Customer initiates payment",
        acquirer: "Request sent to acquiring bank",
        switch: "Routed via switch",
        network: "Network validation",
        issuer: "Issuer decision",
    };

    /* --- PRODUCT SELECTION --- */
    if (elements.products.length > 0) {
        elements.products.forEach((product) => {
            product.addEventListener("click", function () {
                elements.products.forEach((p) => p.classList.remove("selected"));
                this.classList.add("selected");

                state.selectedItem = this.dataset.name;
                state.selectedAmount = parseFloat(this.dataset.price);

                updateUI("amountValue", state.selectedAmount.toFixed(2));
                
                if (elements.terminalText) {
                    elements.terminalText.innerText = "Tap POS to start";
                    elements.terminalText.style.color = "var(--accent-primary)";
                }
            });
        });
    }

    /* --- POS TERMINAL TRIGGER --- */
    if (elements.posTerminal) {
        elements.posTerminal.addEventListener("click", function () {
            if (!state.selectedItem) {
                alert("Please select a product first.");
                return;
            }
            if (state.transactionRunning) return;
            startTransaction();
        });
    }

    /* --- RESET BUTTON TRIGGER --- */
    if (elements.resetBtn) {
        elements.resetBtn.addEventListener("click", resetSimulator);
    }

    /* --- TRANSACTION LOGIC --- */
    function startTransaction() {
        state.transactionRunning = true;

        // Show Loader, Hide Button
        if (elements.loader) elements.loader.style.display = "block";
        if (elements.posTerminal) elements.posTerminal.style.display = "none";

        if (elements.terminalText) {
            elements.terminalText.innerText = "Processing...";
            elements.terminalText.style.color = "var(--accent-secondary)";
        }
        
        animateFlow();
    }

    function animateFlow() {
        const nodes = ["merchant", "acquirer", "switch", "network", "issuer"];

        nodes.forEach((node, index) => {
            setTimeout(() => {
                updateClass(node, "active", 'add');
                updateClass("arrow-" + node, "active-forward", 'add');

                if (index === nodes.length - 1) {
                    setTimeout(reverseFlow, 1000);
                }
            }, index * 900);
        });
    }

    function reverseFlow() {
        const nodes = ["issuer", "network", "switch", "acquirer", "merchant"];
        state.transactionApproved = Math.random() > 0.3;

        nodes.forEach((node, index) => {
            setTimeout(() => {
                const arrowId = "arrow-" + node;
                const arrow = document.getElementById(arrowId);
                
                if (arrow) {
                    arrow.classList.remove("active-forward");
                    arrow.classList.add("up");
                    arrow.classList.add(state.transactionApproved ? "active-success" : "active-fail");
                }

                if (index === nodes.length - 1) {
                    setTimeout(showResult, 800);
                }
            }, index * 900);
        });
    }

    function showResult() {
        const approved = state.transactionApproved;

        // Update Core Results
        updateUI("resultItem", state.selectedItem);
        updateUI("resultAmount", state.selectedAmount.toFixed(2));

        const statusBadge = document.getElementById("resultStatus");
        if (statusBadge) {
            statusBadge.innerText = approved ? "APPROVED" : "DECLINED";
            statusBadge.className = `status-badge ${approved ? 'approved' : 'declined'}`;
        }

        updateUI("authCode", approved ? Math.floor(100000 + Math.random() * 900000) : "-");
        updateUI("responseText", approved ? "00 Approved" : "05 Declined");

        // Update Technical Panel
        updateUI("techMti", "0110");
        updateUI("techDe39", approved ? "00" : "05");
        updateUI("techTrace", "TRC" + Math.floor(Math.random() * 10000));

        state.transactionRunning = false;
        
        // Reset Terminal State
        if (elements.loader) elements.loader.style.display = "none";
        if (elements.posTerminal) elements.posTerminal.style.display = "flex";
    }

    function resetSimulator() {
        const nodes = ["merchant", "acquirer", "switch", "network", "issuer"];

        // 1. Reset Flow Nodes & Arrows
        nodes.forEach((node) => {
            updateClass(node, "active", 'remove');
            const arrow = document.getElementById("arrow-" + node);
            if (arrow) {
                arrow.classList.remove("up", "active-forward", "active-success", "active-fail");
            }
        });

        // 2. Reset Terminal UI
        if (elements.loader) elements.loader.style.display = "none";
        if (elements.posTerminal) elements.posTerminal.style.display = "flex";
        
        if (elements.terminalText) {
            elements.terminalText.innerText = "Select product";
            elements.terminalText.style.color = "var(--text-muted)";
        }

        // 3. Reset Result Panel
        const statusBadge = document.getElementById("resultStatus");
        if (statusBadge) {
            statusBadge.innerText = "Waiting";
            statusBadge.className = "status-badge waiting";
        }
        updateUI("resultItem", "-");
        updateUI("resultAmount", "-");
        updateUI("authCode", "----");
        updateUI("responseText", "-");

        // 4. Reset Technical Panel
        updateUI("techMti", "-");
        updateUI("techDe39", "-");
        updateUI("techTrace", "-");
        if (elements.techPanel) elements.techPanel.classList.remove("open");

        // 5. Reset Products
        if (elements.products) {
            elements.products.forEach((p) => p.classList.remove("selected"));
        }
        state.selectedItem = "";
        state.selectedAmount = 0;
        updateUI("amountValue", "0.00");

        state.transactionRunning = false;
    }

    // Global access to reset function for the button
    window.resetSimulator = resetSimulator;

        /* --- SMART TOOLTIP MANAGER --- */
    const tooltip = document.getElementById("global-tooltip");
    const ttTitle = document.getElementById("tt-title");
    const ttDesc = document.getElementById("tt-desc");
    const ttIso = document.getElementById("tt-iso");
    let tooltipTimer;

    const showTooltip = (e) => {
        const node = e.currentTarget;
        
        // 1. Extract data from attributes
        ttTitle.innerText = node.dataset.title;
        ttDesc.innerText = node.dataset.desc;
        ttIso.innerText = node.dataset.iso;

        // 2. Position the tooltip
        const rect = node.getBoundingClientRect();
        
        // Position to the right of the node
        let leftPos = rect.right + 15;
        let topPos = rect.top + (rect.height / 2) - (tooltip.offsetHeight / 2);

        // Screen Edge Detection: If tooltip goes off screen, move it to the left
        if (leftPos + 240 > window.innerWidth) {
            leftPos = rect.left - 255;
        }

        tooltip.style.left = `${leftPos}px`;
        tooltip.style.top = `${topPos}px`;
        
        // 3. Show with fade
        tooltip.classList.add("visible");
        clearTimeout(tooltipTimer);
    };

    const hideTooltip = () => {
        // Add a slight delay (200ms) so user can move mouse from node to tooltip
        tooltipTimer = setTimeout(() => {
            tooltip.classList.remove("visible");
        }, 200);
    };

    // Attach listeners to all flow nodes
    const flowNodes = document.querySelectorAll(".flow-node");
    flowNodes.forEach(node => {
        node.addEventListener("mouseenter", showTooltip);
        node.addEventListener("mouseleave", hideTooltip);
    });

    // IMPORTANT: Keep tooltip visible when hovering over the tooltip itself
    tooltip.addEventListener("mouseenter", () => {
        clearTimeout(tooltipTimer);
    });

    tooltip.addEventListener("mouseleave", hideTooltip);

});

// Technical Panel Toggle Logic
document.addEventListener("DOMContentLoaded", function() {
    const toggle = document.getElementById("toggleTech");
    if (toggle) {
        toggle.addEventListener("click", function() {
            const panel = document.getElementById("techPanel");
            if (panel) {
                panel.classList.toggle("open");
                this.querySelector(".fa-chevron-down").classList.toggle("fa-rotate-180");
            }
        });
    }
});
