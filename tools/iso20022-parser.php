<?php include '../includes/header.php'; ?>


<div class="page-wrapper">
    <section class="tools-page-section">
        <div class="container">

            <!-- TOOL HEADER -->
            <header class="tools-header" style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-gradient">ISO 20022 Message Parser</h1>
                <p class="tools-subtitle">Decode ISO 20022 XML messages (pacs, pain, camt...). Identify the message type and inspect every element at a glance.</p>
            </header>

            <div class="tool-main-container" style="max-width: 900px; margin: 0 auto;">

                <!-- INPUT PANEL -->
                <div class="glass-panel tool-input-card">
                    <div class="tool-card-header">
                        <i class="fa-solid fa-file-code"></i>
                        <span>XML Message Input</span>
                    </div>

                    <div class="parser-input-area">
                        <textarea id="msg" placeholder="Paste an ISO 20022 XML message here... (e.g. a pacs.008 credit transfer)" rows="10"></textarea>
                        <button onclick="parseMessage()" id="parseBtn" class="btn-primary">
                            <span id="btnText">Analyze Message</span>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <p class="input-hint">Works with any ISO 20022 message. No sample handy? <a href="#" onclick="loadSample(); return false;" style="color: var(--accent-primary);">Load a sample pacs.008</a>.</p>
                </div>

                <!-- RESULT PANEL (Hidden by default) -->
                <div id="resultPanel" class="glass-panel result-card" style="display: none; margin-top: 30px;">
                    <div class="result-card-header">
                        <h3 style="margin:0;">Parsed Message Analysis</h3>
                        <span class="status-badge approved">Decoded Successfully</span>
                    </div>

                    <!-- Header Info (Message Type & Business Area) -->
                    <div class="analysis-header-grid">
                        <div class="analysis-box">
                            <span class="res-label">Message Identifier</span>
                            <span class="res-value" id="resMsgType">-</span>
                        </div>
                        <div class="analysis-box">
                            <span class="res-label">Business Area</span>
                            <span class="res-value" id="resBizArea">-</span>
                        </div>
                    </div>

                    <!-- Elements Table -->
                    <div class="fields-table-wrapper">
                        <table class="fields-table">
                            <thead>
                                <tr>
                                    <th>Element</th>
                                    <th>Path</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody id="fieldsBody">
                                <!-- JS will inject rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ERROR MESSAGE -->
                <div id="errorMsg" class="error-banner" style="display: none;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span id="errorText">Invalid ISO 20022 XML</span>
                </div>

            </div>
        </div>
    </section>
</div>


<script>
// Friendly names for the four-letter business areas
const BUSINESS_AREAS = {
    "pain": "Payments Initiation",
    "pacs": "Payments Clearing & Settlement",
    "camt": "Cash Management",
    "acmt": "Account Management",
    "remt": "Remittance Advice",
    "auth": "Authorities",
    "head": "Business Application Header",
    "seev": "Securities Events",
    "sese": "Securities Settlement",
    "setr": "Securities Trade"
};

// Friendly names for the most common leaf elements
const ELEMENT_NAMES = {
    "MsgId": "Message Identification",
    "CreDtTm": "Creation Date & Time",
    "NbOfTxs": "Number of Transactions",
    "SttlmMtd": "Settlement Method",
    "InstrId": "Instruction Identification",
    "EndToEndId": "End-to-End Identification",
    "TxId": "Transaction Identification",
    "UETR": "Unique End-to-End Transaction Reference",
    "IntrBkSttlmAmt": "Interbank Settlement Amount",
    "IntrBkSttlmDt": "Interbank Settlement Date",
    "InstdAmt": "Instructed Amount",
    "ChrgBr": "Charge Bearer",
    "BICFI": "BIC (Financial Institution)",
    "Nm": "Name",
    "IBAN": "IBAN",
    "Ustrd": "Unstructured Remittance Info",
    "Ccy": "Currency",
    "CtctDtls": "Contact Details",
    "Ctry": "Country",
    "PmtMtd": "Payment Method",
    "ReqdExctnDt": "Requested Execution Date",
    "SvcLvl": "Service Level",
    "Cd": "Code",
    "Prtry": "Proprietary"
};

function esc(str) {
    return String(str).replace(/[&<>"']/g, function (c) {
        return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
    });
}

function parseMessage() {
    const msg = document.getElementById("msg").value.trim();
    const btn = document.getElementById("parseBtn");
    const btnText = document.getElementById("btnText");
    const resultPanel = document.getElementById("resultPanel");
    const errorMsg = document.getElementById("errorMsg");
    const fieldsBody = document.getElementById("fieldsBody");

    if (!msg) {
        showError("Please paste an XML message to parse.");
        return;
    }

    // UI Loading State
    errorMsg.style.display = "none";
    resultPanel.style.display = "none";
    btn.disabled = true;
    btnText.innerText = "Analyzing...";

    try {
        // 1. Parse the XML
        const doc = new DOMParser().parseFromString(msg, "application/xml");
        if (doc.getElementsByTagName("parsererror").length > 0) {
            throw new Error("Not valid XML — check for unclosed tags or stray characters.");
        }

        const root = doc.documentElement;

        // 2. Identify the message from the namespace
        // e.g. urn:iso:std:iso:20022:tech:xsd:pacs.008.001.08
        let msgType = "Unknown";
        let bizArea = "Unknown";
        const ns = root.namespaceURI || "";
        const nsMatch = ns.match(/([a-z]{4})\.(\d{3})\.(\d{3})\.(\d{2,3})/);
        if (nsMatch) {
            msgType = nsMatch[0];
            bizArea = BUSINESS_AREAS[nsMatch[1]] || nsMatch[1].toUpperCase();
        } else if (root.localName !== "Document") {
            msgType = root.localName;
        }

        document.getElementById("resMsgType").innerText = msgType;
        document.getElementById("resBizArea").innerText = bizArea;

        // 3. Walk the tree and collect every leaf element (element with text only)
        const leaves = [];
        collectLeaves(root, [], leaves);

        if (leaves.length === 0) {
            throw new Error("XML parsed, but no data elements were found inside it.");
        }

        // 4. Render rows
        let fieldsHtml = "";
        leaves.forEach(function (leaf) {
            const friendly = ELEMENT_NAMES[leaf.name] || leaf.name;
            let value = leaf.value;
            if (leaf.attrs) value += " " + leaf.attrs;
            fieldsHtml += "<tr>" +
                "<td class=\"field-id\">&lt;" + esc(leaf.name) + "&gt;</td>" +
                "<td>" + esc(friendly) + "<br><small style=\"color: var(--text-muted);\">" + esc(leaf.path) + "</small></td>" +
                "<td>" + esc(value) + "</td>" +
                "</tr>";
        });

        fieldsBody.innerHTML = fieldsHtml;
        resultPanel.style.display = "block";

    } catch (e) {
        showError(e.message);
    } finally {
        btn.disabled = false;
        btnText.innerText = "Analyze Message";
    }
}

function collectLeaves(node, pathParts, out) {
    const children = [];
    for (let i = 0; i < node.children.length; i++) {
        children.push(node.children[i]);
    }

    if (children.length === 0) {
        const value = (node.textContent || "").trim();
        if (!value) return;

        // Currency etc. arrive as attributes, e.g. <IntrBkSttlmAmt Ccy="EUR">
        let attrs = "";
        for (let i = 0; i < node.attributes.length; i++) {
            const a = node.attributes[i];
            if (a.name.indexOf("xmlns") !== 0) {
                attrs += a.name + "=" + a.value + " ";
            }
        }

        out.push({
            name: node.localName,
            path: pathParts.slice(-3).join(" > ") || node.localName,
            value: value.length > 120 ? value.substring(0, 120) + "..." : value,
            attrs: attrs.trim() ? "(" + attrs.trim() + ")" : ""
        });
        return;
    }

    children.forEach(function (child) {
        collectLeaves(child, pathParts.concat(child.localName), out);
    });
}

function loadSample() {
    document.getElementById("msg").value =
'<' + '?xml version="1.0" encoding="UTF-8"?' + '>\n' +
'<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pacs.008.001.08">\n' +
'  <FIToFICstmrCdtTrf>\n' +
'    <GrpHdr>\n' +
'      <MsgId>MSG-20260705-0001</MsgId>\n' +
'      <CreDtTm>2026-07-05T10:30:00</CreDtTm>\n' +
'      <NbOfTxs>1</NbOfTxs>\n' +
'      <SttlmInf>\n' +
'        <SttlmMtd>CLRG</SttlmMtd>\n' +
'      </SttlmInf>\n' +
'    </GrpHdr>\n' +
'    <CdtTrfTxInf>\n' +
'      <PmtId>\n' +
'        <EndToEndId>INVOICE-4521</EndToEndId>\n' +
'        <TxId>TXN-88213</TxId>\n' +
'      </PmtId>\n' +
'      <IntrBkSttlmAmt Ccy="EUR">1500.00</IntrBkSttlmAmt>\n' +
'      <ChrgBr>SLEV</ChrgBr>\n' +
'      <Dbtr>\n' +
'        <Nm>Acme Trading GmbH</Nm>\n' +
'      </Dbtr>\n' +
'      <DbtrAgt>\n' +
'        <FinInstnId>\n' +
'          <BICFI>DEUTDEFFXXX</BICFI>\n' +
'        </FinInstnId>\n' +
'      </DbtrAgt>\n' +
'      <CdtrAgt>\n' +
'        <FinInstnId>\n' +
'          <BICFI>BNPAFRPPXXX</BICFI>\n' +
'        </FinInstnId>\n' +
'      </CdtrAgt>\n' +
'      <Cdtr>\n' +
'        <Nm>Lumière Distribution SA</Nm>\n' +
'      </Cdtr>\n' +
'      <RmtInf>\n' +
'        <Ustrd>Payment for invoice 4521</Ustrd>\n' +
'      </RmtInf>\n' +
'    </CdtTrfTxInf>\n' +
'  </FIToFICstmrCdtTrf>\n' +
'</Document>';
}

function showError(text) {
    const errorMsg = document.getElementById("errorMsg");
    const resultPanel = document.getElementById("resultPanel");
    resultPanel.style.display = "none";
    errorMsg.style.display = "flex";
    document.getElementById("errorText").innerText = text;
}
</script>

<?php include '../includes/footer.php'; ?>
