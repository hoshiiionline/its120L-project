function generateResponse() {
    const text = document.getElementById("text");
    const response = document.getElementById("response");
    const typing = document.querySelector(".typing");
    const button = document.querySelector("button");

    // Don't proceed if input is empty
    if (!text.value.trim()) return;

    // Disable input and button while processing
    text.disabled = true;
    button.disabled = true;
    typing.style.display = "block";

    fetch("response.php", {
        method: "post",
        body: JSON.stringify({
            text: text.value,
        }),
    })
    .then(res => res.text())
    .then(res => {
        response.innerHTML = res;
    })
    .catch(error => {
        response.innerHTML = "I apologize, but I encountered an error. Please try again.";
        console.error("Error:", error);
    })
    .finally(() => {
        // Re-enable input and button
        text.disabled = false;
        button.disabled = false;
        typing.style.display = "none";
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