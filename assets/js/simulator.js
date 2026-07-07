/**
 * CARDPAY SUITE — INTERACTIVE LEARNING SIMULATOR
 * Version: 3.1
 *
 * A "flight simulator for card payments": the learner picks a scenario, an amount
 * and a mode, then steps a real ISO 8583 authorization through the payment chain
 * and back. One STEPS array drives the stepper, the narration and the live
 * ISO 8583 message inspector.
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log("CardPay Learning Simulator: initialized ✅");

    /* ---------- Safe DOM helpers (project convention: null-checked) ---------- */
    const $ = (id) => document.getElementById(id);
    const setText = (id, value) => { const el = $(id); if (el) el.innerHTML = value; };

    /* ---------- Configuration ---------- */
    const STAGE_NAMES = ["Cardholder", "Acquirer", "Switch", "Network", "Issuer", "Response"];

    // Outcomes the learner can compare. Replaces the old Math.random() decision.
    const SCENARIOS = {
        approved: {
            label: "Approved", de39: "00", approved: true, meaning: "Approved / completed",
            issuer: "The <strong>issuer</strong> looks up the account, confirms the available balance covers the amount, verifies the card credentials and runs fraud scoring. Everything passes — it reserves the funds and returns an approval with an <strong>authorization code</strong>."
        },
        insufficient: {
            label: "Insufficient Funds", de39: "51", approved: false, meaning: "Insufficient funds",
            issuer: "The <strong>issuer</strong> finds the account, but the available balance is lower than the requested amount. It declines with response code <strong>51</strong> — no money moves and no authorization code is issued."
        },
        donothonor: {
            label: "Do Not Honor", de39: "05", approved: false, meaning: "Do not honor",
            issuer: "The <strong>issuer's</strong> risk rules refuse the transaction without a more specific reason — a generic <strong>Do Not Honor (05)</strong>. The account may work later, but this attempt is rejected."
        },
        fraud: {
            label: "Suspected Fraud", de39: "04", approved: false, meaning: "Pick up card (fraud)",
            issuer: "The <strong>issuer's</strong> fraud engine flags this authorization as suspicious and responds <strong>Pick up card (04)</strong>. The terminal is told to retain the card and the sale cannot complete."
        }
    };

    // Ordered stages. `stage` indexes the stepper; `add` = ISO fields to reveal.
    const STEPS = [
        {
            stage: 0, phase: "request",
            title: "Card presented at the terminal",
            text: "The cardholder inserts the card at the merchant's POS terminal. The terminal reads the card, packages the purchase into an <strong>ISO 8583</strong> authorization request and stamps it as message type <strong>0200</strong> (financial request).",
            iso: "MTI 0200 · DE2 PAN, DE3 processing code, DE4 amount, DE11 STAN, DE22 entry mode, DE41 terminal ID.",
            add: ["de2", "de3", "de4", "de11", "de22", "de41"]
        },
        {
            stage: 1, phase: "request",
            title: "Acquirer receives the request",
            text: "The merchant's bank — the <strong>acquirer</strong> — receives the 0200 message, checks that it is well-formed, tags it with its own institution ID and forwards it toward the card network.",
            iso: "DE32 (Acquiring Institution ID) identifies which bank is asking on the merchant's behalf.",
            add: ["de32"]
        },
        {
            stage: 2, phase: "request",
            title: "Switch routes by BIN",
            text: "A <strong>payment switch</strong> reads the first 6–8 digits of the card number (the <strong>BIN</strong>) to decide where the message should go. This is pure routing logic — the switch never sees a balance.",
            iso: "Routing uses the BIN — the leading digits of DE2 (here 411111 → Visa).",
            add: []
        },
        {
            stage: 3, phase: "request",
            title: "Card network validates & routes",
            text: "The <strong>card network</strong> (Visa, Mastercard, …) confirms the card program is valid and hands the request to the bank that issued the card.",
            iso: "The network forwards the ISO 8583 message intact to the issuer.",
            add: []
        },
        {
            stage: 4, phase: "decision",
            title: "Issuer makes the decision",
            text: "",  // filled from the selected scenario
            iso: "",   // filled from the selected scenario
            add: []
        },
        {
            stage: 5, phase: "response",
            title: "Response travels back",
            text: "The issuer's decision is packaged as an <strong>0210</strong> response and travels back along the same path — network → switch → acquirer → terminal — in a fraction of a second. The terminal then shows the outcome to the cashier and cardholder.",
            iso: "",   // filled from the selected scenario
            add: []
        }
    ];

    /* ---------- State ---------- */
    const state = {
        mode: "guided",     // "guided" | "auto"
        scenario: "approved",
        speed: 900,
        step: -1,           // -1 = not started; 0..STEPS.length-1
        amount: 25,
        stan: "",
        auth: ""
    };
    let autoTimer = null;

    /* ---------- Small utilities ---------- */
    const rand6 = () => String(Math.floor(Math.random() * 900000) + 100000);
    const isFinished = () => state.step >= STEPS.length - 1;

    /* ---------- Inspector helpers ---------- */
    function revealField(key) {
        const row = document.querySelector('.iso-row[data-field="' + key + '"]');
        if (!row) return;
        row.classList.add("show", "field-new");
        setTimeout(() => row.classList.remove("field-new"), 1200);
    }
    function setMti(v) { setText("isoMti", "MTI " + v); }

    /* ---------- Stepper + tabs ---------- */
    function markStepper(stage, failed) {
        document.querySelectorAll(".stepper-node").forEach((node) => {
            const s = parseInt(node.dataset.stage, 10);
            node.classList.toggle("done", s < stage);
            node.classList.toggle("current", s === stage);
        });
        // On a decline, flag the Response stage so the strip doesn't read as "all good".
        const last = document.querySelector('.stepper-node[data-stage="5"]');
        if (last) last.classList.toggle("fail", failed === true);
    }
    function switchTab(name) {
        document.querySelectorAll(".teach-tab").forEach((t) => t.classList.toggle("active", t.dataset.tab === name));
        document.querySelectorAll(".teach-panel").forEach((p) => p.classList.toggle("active", p.id === "tab-" + name));
    }
    document.querySelectorAll(".teach-tab").forEach((tab) => {
        tab.addEventListener("click", () => switchTab(tab.dataset.tab));
    });

    /* ---------- Run lifecycle ---------- */
    function begin() {
        state.stan = rand6();
        state.auth = "";
        setText("valDe4", String(Math.round(state.amount * 100)).padStart(12, "0"));
        setText("valDe11", state.stan);
        setMti("0200");
    }

    function applyStep(i) {
        const s = STEPS[i];
        const scn = SCENARIOS[state.scenario];

        markStepper(s.stage);

        // Narration (issuer + response steps are scenario-specific)
        let title = s.title, text = s.text, iso = s.iso;
        if (s.phase === "decision") {
            title = "Issuer decision — " + scn.label;
            text = scn.issuer;
            iso = "MTI switches to 0210 · DE39 = " + scn.de39 + " (" + scn.meaning + ")" +
                  (scn.approved ? " · DE38 authorization code issued." : ".");
        } else if (s.phase === "response") {
            iso = "MTI 0210 · DE39 = " + scn.de39 + (scn.approved ? " · DE38 = " + state.auth : "") + ".";
        }
        setText("narrStage", "Step " + (i + 1) + " / " + STEPS.length + " · " + STAGE_NAMES[s.stage]);
        setText("narrTitle", title);
        setText("narrText", text);
        setText("narrIsoText", iso);

        // Reveal request fields for this step
        (s.add || []).forEach(revealField);

        // Issuer decision: flip MTI, set DE39 / DE38
        if (s.phase === "decision") {
            setMti("0210");
            setText("valDe39", scn.de39 + " · " + scn.meaning);
            revealField("de39");
            if (scn.approved) {
                state.auth = rand6();
                setText("valDe38", state.auth);
                revealField("de38");
            }
        }

        // Response: publish the result and flag the stepper on a decline
        if (s.phase === "response") {
            markStepper(s.stage, !scn.approved);
            renderResult(scn);
            switchTab("result");
        }
    }

    function renderResult(scn) {
        const badge = $("resultStatus");
        if (badge) {
            badge.innerText = scn.approved ? "APPROVED" : "DECLINED";
            badge.className = "status-badge " + (scn.approved ? "approved" : "declined");
        }
        setText("resultAmount", "$" + state.amount.toFixed(2));
        setText("authCode", scn.approved ? state.auth : "—");
        setText("responseText", scn.de39 + " · " + scn.meaning);
        setText("resultHint", scn.approved
            ? "The issuer authorized the payment. In production the funds are now held and later cleared in settlement."
            : "The issuer refused the authorization, so no funds were moved. The terminal shows the decline to the cashier.");
    }

    /* ---------- Step / play controls ---------- */
    function stepForward() {
        if (isFinished()) return;
        if (state.step === -1) begin();
        state.step++;
        applyStep(state.step);
        updateControls();
    }

    function stepBack() {
        if (state.step <= 0) { resetSim(); return; }
        const target = state.step - 1;
        resetVisuals(false);
        begin();
        for (let i = 0; i <= target; i++) { state.step = i; applyStep(i); }
        state.step = target;
        updateControls();
    }

    function autoDelay() { return state.speed; }
    function playAuto() {
        if (isFinished()) resetSim();
        if (state.step === -1) begin();
        autoTimer = setInterval(() => {
            if (isFinished()) { pauseAuto(); updateControls(); return; }
            state.step++;
            applyStep(state.step);
            if (isFinished()) pauseAuto();
            updateControls();
        }, autoDelay());
        updateControls();
    }
    function pauseAuto() { if (autoTimer) { clearInterval(autoTimer); autoTimer = null; } }

    function onPrimary() {
        if (isFinished()) { resetSim(); return; }
        if (state.mode === "auto") { autoTimer ? pauseAuto() : playAuto(); updateControls(); return; }
        stepForward();
    }

    /* ---------- Reset ---------- */
    function resetVisuals(resetNarration) {
        document.querySelectorAll(".stepper-node").forEach((n) => n.classList.remove("done", "current", "fail"));
        document.querySelectorAll(".iso-row").forEach((r) => r.classList.remove("show", "field-new"));
        setMti("—");
        setText("valDe4", "—"); setText("valDe11", "—"); setText("valDe39", "—"); setText("valDe38", "—");

        const badge = $("resultStatus");
        if (badge) { badge.innerText = "Waiting"; badge.className = "status-badge waiting"; }
        setText("resultAmount", "-");
        setText("authCode", "----"); setText("responseText", "-");
        setText("resultHint", "Run a transaction to see the outcome the issuer returned.");

        if (resetNarration) {
            setText("narrStage", "Ready to begin");
            setText("narrTitle", "Press Start to run a transaction");
            setText("narrText", "Pick a <strong>scenario</strong> and a <strong>mode</strong> above, then press <strong>Start</strong>.");
            setText("narrIsoText", "ISO 8583 field details will appear here as the message travels. Hover a stage above to see what each party does.");
            switchTab("narration");
        }
    }

    function resetSim() {
        pauseAuto();
        resetVisuals(true);
        state.step = -1;
        state.auth = "";
        updateControls();
    }

    /* ---------- Control-bar wiring ---------- */
    function setBtn(text, icon) {
        const b = $("primaryBtn");
        if (!b) return;
        const t = b.querySelector(".btn-text"); if (t) t.innerText = text;
        const ic = b.querySelector("i"); if (ic) ic.className = "fa-solid " + icon;
    }
    function updateControls() {
        if (isFinished()) {
            setBtn("New Transaction", "fa-rotate-right");
        } else if (state.mode === "auto") {
            setBtn(autoTimer ? "Pause" : (state.step === -1 ? "Play" : "Resume"), autoTimer ? "fa-pause" : "fa-play");
        } else {
            setBtn(state.step === -1 ? "Start" : "Next Step", "fa-arrow-right");
        }
        const prev = $("prevBtn");
        if (prev) prev.style.display = (state.mode === "guided" && state.step >= 0 && !isFinished()) ? "flex" : "none";
        const speed = $("speedControl");
        if (speed) speed.style.display = (state.mode === "auto") ? "flex" : "none";
    }

    if ($("primaryBtn")) $("primaryBtn").addEventListener("click", onPrimary);
    if ($("prevBtn")) $("prevBtn").addEventListener("click", stepBack);
    if ($("resetBtn")) $("resetBtn").addEventListener("click", resetSim);

    document.querySelectorAll(".scenario-pill").forEach((pill) => {
        pill.addEventListener("click", () => {
            document.querySelectorAll(".scenario-pill").forEach((p) => p.classList.remove("active"));
            pill.classList.add("active");
            state.scenario = pill.dataset.scenario;
            resetSim();
        });
    });

    document.querySelectorAll(".mode-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            document.querySelectorAll(".mode-btn").forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");
            state.mode = btn.dataset.mode;
            resetSim();
        });
    });

    document.querySelectorAll(".speed-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            document.querySelectorAll(".speed-btn").forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");
            state.speed = parseInt(btn.dataset.speed, 10);
            if (autoTimer) { pauseAuto(); playAuto(); }  // apply new cadence immediately
        });
    });

    updateControls();

    /* ---------- Stepper tooltips (null-guarded) ---------- */
    const tooltip = $("global-tooltip");
    const ttTitle = $("tt-title");
    const ttDesc = $("tt-desc");
    const ttIso = $("tt-iso");
    let tooltipTimer;

    if (tooltip && ttTitle && ttDesc && ttIso) {
        const showTooltip = (e) => {
            const node = e.currentTarget;
            ttTitle.innerText = node.dataset.title || "";
            ttDesc.innerText = node.dataset.desc || "";
            ttIso.innerText = node.dataset.iso || "";

            const rect = node.getBoundingClientRect();
            let leftPos = rect.right + 15;
            let topPos = rect.top + (rect.height / 2) - (tooltip.offsetHeight / 2);
            if (leftPos + 240 > window.innerWidth) leftPos = rect.left - 255;   // flip left near edge
            if (leftPos < 10) { leftPos = rect.left; topPos = rect.bottom + 12; } // or drop below

            tooltip.style.left = leftPos + "px";
            tooltip.style.top = topPos + "px";
            tooltip.classList.add("visible");
            clearTimeout(tooltipTimer);
        };
        const hideTooltip = () => {
            tooltipTimer = setTimeout(() => tooltip.classList.remove("visible"), 200);
        };

        document.querySelectorAll(".stepper-node").forEach((node) => {
            node.addEventListener("mouseenter", showTooltip);
            node.addEventListener("mouseleave", hideTooltip);
        });
        tooltip.addEventListener("mouseenter", () => clearTimeout(tooltipTimer));
        tooltip.addEventListener("mouseleave", hideTooltip);
    }
});
