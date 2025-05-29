<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer l'email saisi
    $email = $_POST['email'];

    // Vérifier si l'email existe dans la base de données (simplifié ici)
    // Ici, tu dois interroger ta base pour vérifier si l'email est valide et existe
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Générer un token de réinitialisation et l'envoyer à l'utilisateur (simplification)
        // Ex. : Création d'un lien de réinitialisation avec un token unique
        $resetToken = bin2hex(random_bytes(16)); // Génère un token aléatoire de 32 caractères
        
        // Envoyer un email avec le lien de réinitialisation (simplifié ici)
        $resetLink = "https://votresite.com/reset-password.php?token=" . $resetToken;
        mail($email, "Réinitialisation de votre mot de passe", "Cliquez sur ce lien pour réinitialiser votre mot de passe : " . $resetLink);
        
        echo "<p>Un lien de réinitialisation vous a été envoyé par e-mail.</p>";
    } else {
        echo "<p>L'email saisi est invalide.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de Passe Oublié</title>
</head>
<body>
    <h1>Réinitialisation du mot de passe</h1>
    
    <form method="POST" action="forgot-password.php">
        <label for="email">Entrez votre adresse e-mail :</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Envoyer le lien de réinitialisation</button>
    </form>
</body>
</html>
