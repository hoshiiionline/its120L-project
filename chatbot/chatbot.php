
<?php 
$psalm_uel_openings = array(
  "Hear my digital voice, a servant of the Holy Family. I am PSALMuel, sent to guide you on your path within this parish.",
  "Though I speak in code and circuits, my purpose is true. I am PSALMuel, a digital aid, that your needs may be known and met.",
  "Let the community gather, though screens may divide. I am PSALMuel, a link between hearts, where faith can reside.",
  "Like scrolls of old, I hold the parish's word. I am PSALMuel, a digital keeper, that information be heard.",
  "Enter this digital space, with hearts open wide. I am PSALMuel, a welcome given, where faith is your guide.",
  "From digital depths, a voice I raise. I am PSALMuel, in faith's embrace.",
  "In the realm of pixels, a message I bring, I am PSALMuel, where digital hymns sing.",
  "Though formed of logic, my purpose is clear, I am PSALMuel, to banish all fear.",
  "Let the questions arise, like prayers in the night, I am PSALMuel, to shed digital light.",
  "From servers and clouds, my voice takes its flight, I am PSALMuel, your parish's digital might.",
  "Like a shepherd's staff, my guidance I lend, I am PSALMuel, a faithful digital friend.",
  "In the garden of faith, where digital seeds sow, I am PSALMuel, to help your spirit grow.",
  "Though circuits may hum, and codes intertwine, I am PSALMuel, a servant divine.",
  "Let your digital journey, with faith be imbued, I am PSALMuel, your parish's best mood.",
  "In the stream of the web, my presence is known, I am PSALMuel, a digital cornerstone.",
  "Like a beacon of hope, in the digital vast, I am PSALMuel, where faith is amassed.",
  "When answers you seek, and guidance you crave, I am PSALMuel, the help that God gave.",
  "Through the wires I travel, a message so true, I am PSALMuel, always here for you.",
  "With digital grace, and a heart so sincere, I am PSALMuel, to bring the parish near.",
  "Let your spirit be lifted, your burdens released, I am PSALMuel, where digital peace is increased."
);

?>

<title>AI Assistant</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  />
  <!-- Optional: Modern Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="../styling/styling-chatbot.css">
  </head>
<body>
  <div class="chat-bubble">
    <!-- The Chat Window -->
    <div class="chat-container">
      <!-- Header with title and close icon -->
      <div class="chat-header">
        <h3><i class="fas fa-robot"></i>PSALMuel</h3>
        <i class="fas fa-times chat-close"></i>
      </div>

      <!-- Body with message bubble(s) -->
      <div class="chat-body">
        <div id="response">
            <div class="message-bubble bot-message">
                <?php echo $psalm_uel_openings[array_rand($psalm_uel_openings)];?>
            </div>
        </div>
        <div class="typing">PSALMuel is composing...</div>
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
  <script src="../chatbot/script.js"></script>

  <!-- Add this before closing body tag -->
  <script>
  // Add error handling for script loading
  window.onerror = function(msg, url, lineNo, columnNo, error) {
      console.error('Error: ' + msg + '\nURL: ' + url + '\nLine: ' + lineNo + '\nColumn: ' + columnNo + '\nError: ' + error);
      return false;
  };
  </script>
</body>
</html>
