<?php
session_start(); // Démarrer la session

// Vérifier si les informations de l'utilisateur sont disponibles
if (!isset($_SESSION['user_info'])) {
    header("Location: register.php"); // Rediriger vers le formulaire si aucune info
    exit();
}

$user_info = $_SESSION['user_info'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations de l'utilisateur</title>
</head>
<body>
    <h1>Informations de l'utilisateur</h1>
    <p><strong>Nom complet :</strong> <?php echo htmlspecialchars($user_info['name']); ?></p>
    <p><strong>Adresse e-mail :</strong> <?php echo htmlspecialchars($user_info['email']); ?></p>
    <p><strong>Adresse :</strong> <?php echo htmlspecialchars($user_info['address']); ?></p>
    <p><strong>Numéro de téléphone :</strong> <?php echo htmlspecialchars($user_info['phone']); ?></p>

    <a href="register.php">Retour à l'inscription</a>
</body>
</html>