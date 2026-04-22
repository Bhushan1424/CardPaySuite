document.addEventListener("DOMContentLoaded", function () {
    const trigger = document.getElementById("ai-trigger");
    const windowEl = document.getElementById("ai-window");
    const closeBtn = document.getElementById("close-ai");
    const sendBtn = document.getElementById("send-ai-btn");
    const inputField = document.getElementById("ai-input");
    const messagesContainer = document.getElementById("ai-messages");
    const typingIndicator = document.getElementById("ai-typing");

    // 1. Toggle Window
    trigger.addEventListener("click", () => {
        windowEl.style.display = windowEl.style.display === "flex" ? "none" : "flex";
    });

    closeBtn.addEventListener("click", () => {
        windowEl.style.display = "none";
    });

    // 2. Handle Sending Messages
    async function sendMessage() {
        const text = inputField.value.trim();
        if (!text) return;

        // Append User Message
        appendMessage(text, 'user');
        inputField.value = "";

        // Show Typing Indicator
        typingIndicator.style.display = "flex";
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        try {
            // This is where we will call ai-proxy.php
            const response = await fetch("/ai-proxy.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ question: text })
            });

            const data = await response.json();
            
            typingIndicator.style.display = "none";
            appendMessage(data.answer || "I'm sorry, I couldn't process that request.", 'ai');

        } catch (error) {
            typingIndicator.style.display = "none";
            appendMessage("Connection error. Please try again later.", 'ai');
        }
    }

    function appendMessage(text, sender) {
        const msgDiv = document.createElement("div");
        msgDiv.className = `msg-bubble ${sender === 'user' ? 'user-msg' : 'ai-msg'}`;
        msgDiv.innerText = text;
        messagesContainer.appendChild(msgDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    sendBtn.addEventListener("click", sendMessage);

    // Allow "Enter" key to send
    inputField.addEventListener("keypress", (e) => {
        if (e.key === "Enter") sendMessage();
    });
});
