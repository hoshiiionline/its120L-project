function generateResponse() {
    const text = document.getElementById("text");
    const response = document.getElementById("response");
    const typing = document.querySelector(".typing");
    const button = document.querySelector("button");

    // Don't proceed if input is empty
    if (!text.value.trim()) return;

    // Show user's message
    const userMessage = text.value;
    response.innerHTML += `<div class="message-bubble user-message">${userMessage}</div>`;

    // Disable input and button while processing
    text.disabled = true;
    button.disabled = true;
    typing.style.display = "block";

    fetch("../chatbot/response.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            text: userMessage
        }),
    })
    .then(res => res.json()) // Change to json()
    .then(res => {
        typing.style.display = "none";
        // Only display the message part
        response.innerHTML += `<div class="message-bubble bot-message">${res.message}</div>`;
        // Scroll to bottom of chat
        response.scrollTop = response.scrollHeight;
    })
    .catch(error => {
        console.error("Error:", error);
        typing.style.display = "none";
        response.innerHTML += `<div class="message-bubble bot-message">I apologize, but I encountered an error. Please try again.</div>`;
    })
    .finally(() => {
        // Re-enable input and button
        text.disabled = false;
        button.disabled = false;
        text.value = "";
        text.focus();
    });
}

// Add enter key support
document.getElementById("text").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        generateResponse();
    }
});