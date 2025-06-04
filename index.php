<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Chatbot IA - Artisanat Marocain</title>
<style>
  body {
    font-family: Arial, sans-serif;
    max-width: 600px;
    margin: 40px auto;
    padding: 0 20px;
  }
  #chatbox {
    border: 1px solid #ddd;
    padding: 15px;
    height: 400px;
    overflow-y: auto;
    background: #f9f9f9;
  }
  .message {
    margin: 10px 0;
  }
  .user {
    text-align: right;
    color: blue;
  }
  .bot {
    text-align: left;
    color: green;
  }
  #inputForm {
    margin-top: 20px;
    display: flex;
  }
  #inputForm input {
    flex: 1;
    padding: 10px;
    font-size: 1rem;
  }
  #inputForm button {
    padding: 10px 15px;
    font-size: 1rem;
  }
</style>
</head>
<body>

<h1>Assistant Virtuel - Artisanat Marocain</h1>

<div id="chatbox"></div>

<form id="inputForm">
  <input type="text" id="userInput" placeholder="Pose ta question..." autocomplete="off" required />
  <button type="submit">Envoyer</button>
</form>

<script>
  const chatbox = document.getElementById('chatbox');
  const inputForm = document.getElementById('inputForm');
  const userInput = document.getElementById('userInput');

  function appendMessage(text, sender) {
    const msg = document.createElement('div');
    msg.classList.add('message', sender);
    msg.textContent = text;
    chatbox.appendChild(msg);
    chatbox.scrollTop = chatbox.scrollHeight;
  }

  inputForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const message = userInput.value.trim();
    if (!message) return;
    appendMessage(message, 'user');
    userInput.value = '';

    try {
      const res = await fetch('chatbot.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({message})
      });

      const data = await res.json();

      if (data.error) {
        appendMessage("Erreur : " + data.error, 'bot');
      } else {
        appendMessage(data.answer, 'bot');
      }
    } catch (err) {
      appendMessage("Erreur de connexion au serveur.", 'bot');
    }
  });
</script>

</body>
</html>
