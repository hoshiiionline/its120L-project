<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon104 AI Assistant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #6884ac;
            --dark-bg: #161616;
            --card-bg: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Figtree', sans-serif;
        }

        /* Chat bubble styles */
        .chat-bubble {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .chat-toggle {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .chat-toggle:hover {
            transform: translateY(-3px);
        }

        .chat-toggle i {
            color: white;
            font-size: 24px;
        }

        /* Modified existing chat container styles */
        .chat-container {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            background: var(--dark-bg);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: none; /* Hidden by default */
            overflow: hidden;
        }

        .chat-header {
            background: var(--primary-color);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h3 {
            color: white;
            margin: 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chat-close {
            color: white;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .chat-close:hover {
            transform: rotate(90deg);
        }

        /* Keep your existing styles */
        .input-group {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(22, 22, 22, 0.95);
            display: flex;
            gap: 0.5rem;
        }

        input[type="text"] {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 0.9rem;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        #response {
            height: 300px;
            padding: 1.5rem;
            border-radius: 8px;
            overflow-y: auto;
            color: white;
            white-space: pre-wrap;
            background: rgba(255, 255, 255, 0.05);
        }

        .typing {
            display: none;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .chat-container {
                width: calc(100% - 40px);
                max-height: calc(100vh - 120px);
            }
        }
    </style>
</head>
<body>
    <!-- New chat bubble structure -->
    <div class="chat-bubble">
        <div class="chat-toggle">
            <i class="fas fa-comments"></i>
        </div>
        
        <div class="chat-container">
            <div class="chat-header">
                <h3><i class="fas fa-robot"></i> Salon104 Assistant</h3>
                <i class="fas fa-times chat-close"></i>
            </div>
            
            <div class="input-group">
                <input type="text" id="text" placeholder="Ask me anything about Salon104...">
                <button onclick="generateResponse();"><i class="fas fa-paper-plane"></i></button>
            </div>

            <div class="typing">AI is thinking...</div>
            <div id="response">Hello! I'm the Salon104 AI Assistant. I can help you with information about our services, booking appointments, business hours, and more. How may I assist you today?</div>
        </div>
    </div>

    <script>
        // Add this before your existing script.js
        document.addEventListener('DOMContentLoaded', () => {
            const chatToggle = document.querySelector('.chat-toggle');
            const chatContainer = document.querySelector('.chat-container');
            const chatClose = document.querySelector('.chat-close');

            chatToggle.addEventListener('click', () => {
                chatContainer.style.display = 'block';
                chatToggle.style.display = 'none';
                document.getElementById('text').focus();
            });

            chatClose.addEventListener('click', () => {
                chatContainer.style.display = 'none';
                chatToggle.style.display = 'flex';
            });
        });
    </script>
    <script src="script.js"></script>
</body>
</html>
