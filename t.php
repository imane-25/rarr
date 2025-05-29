<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Test EmailJS</title>
  <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
      console.log("DOM chargé");

      // Initialisation EmailJS avec ta clé publique
      emailjs.init("7zbC33g0M8dUwKkr6");
      console.log("EmailJS initialisé");

      const form = document.getElementById("test-form");

      if (!form) {
        console.error("Formulaire introuvable !");
        return;
      }

      form.addEventListener("submit", function (e) {
        e.preventDefault();
        console.log("Formulaire soumis");

        emailjs.sendForm("service_56b9pls", "template_s6cynfa", this)
          .then(function () {
            alert("✅ Message envoyé avec succès !");
          }, function (error) {
            console.error("❌ Échec de l'envoi :", error);
            alert("Erreur lors de l'envoi.");
          });
      });
    });
  </script>
</head>
<body>
  <h2>Formulaire Test EmailJS</h2>
  <form id="test-form">
    <input type="text" name="name" placeholder="Nom" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="phone" placeholder="Téléphone"><br><br>
    <input type="text" name="subject" placeholder="Sujet" required><br><br>
    <textarea name="message" placeholder="Votre message" required></textarea><br><br>
    <button type="submit">Envoyer</button>
  </form>
</body>
</html>
