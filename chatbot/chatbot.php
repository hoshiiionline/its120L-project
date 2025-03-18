
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  />
  <!-- Optional: Modern Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="../css/chatbot.css">
  </head>
<body>
  <div class="chat-bubble">
    <!-- The Chat Window -->
    <div class="chat-container">
      <!-- Header with title and close icon -->
      <div class="chat-header">
        <h3><i class="fas fa-robot"></i>Cirrus Chat Bot</h3>
        <i class="fas fa-times chat-close"></i>
      </div>

      <!-- Body with message bubble(s) -->
      <div class="chat-body">
        <div class="message-bubble" id="response">
        Greetings! I'm Cirrus, your dedicated AI Assistant for Banahaw Nature Resort Circle, how may I assist you in planning your rejuvenating stay amidst the beauty of Banahaw Nature Resort Circle?
        </div>
        <div class="typing">AI is thinking...</div>
      </div>

      <!-- Input area at the bottom -->
      <div class="input-group">
        <input
          type="text"
          id="text"
          placeholder="Ask me anything!"
        />
        <button onclick="generateResponse()">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </div>

    <!-- The Floating Toggle Button -->
    <div class="chat-toggle">
      <i class="fas fa-comments"></i>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const chatToggle = document.querySelector('.chat-toggle');
      const chatContainer = document.querySelector('.chat-container');
      const chatClose = document.querySelector('.chat-close');

      chatToggle.addEventListener('click', () => {
        chatContainer.style.display = 'flex';
        chatToggle.style.display = 'none';
        document.getElementById('text').focus();
      });

      chatClose.addEventListener('click', () => {
        chatContainer.style.display = 'none';
        chatToggle.style.display = 'flex';
      });
    });
    
    function generateResponse() {
      const responseBox = document.getElementById('response');
      const userText = document.getElementById('text').value;
      responseBox.textContent = 'You asked: ' + userText;
    }
  </script>
  <script src="script.js"></script>
</body>
</html>
