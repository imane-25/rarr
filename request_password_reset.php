<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['user'];

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Générer un token sécurisé unique
    $token = bin2hex(random_bytes(32));

    // Date d'expiration du token (ex: 1h)
    $expires_at = date('Y-m-d H:i:s', time() + 3600);

    // Insère ou met à jour le token dans une table password_resets (à créer)
    $stmt = $pdo->prepare("REPLACE INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$user['id'], $token, $expires_at]);

    // Envoi de l'email (exemple simple, utilise une vraie fonction mail ou une lib comme PHPMailer)
    $resetLink = "https://ton-domaine.com/reset_password.php?token=$token";
    $to = $user['email'];
    $subject = "Réinitialisation de votre mot de passe Beldi";
    $message = "Bonjour " . htmlspecialchars($user['prenom']) . ",\n\n";
    $message .= "Vous avez demandé la réinitialisation de votre mot de passe.\n";
    $message .= "Veuillez cliquer sur ce lien pour définir un nouveau mot de passe (valide 1 heure) :\n";
    $message .= $resetLink . "\n\n";
    $message .= "Si vous n'avez pas demandé cette action, ignorez cet email.\n\nCordialement,\nL'équipe Beldi";

    $headers = "From: no-reply@ton-domaine.com\r\n";

    if (mail($to, $subject, $message, $headers)) {
        $_SESSION['flash_success'] = "Un email de réinitialisation a été envoyé à votre adresse.";
    } else {
        $_SESSION['flash_error'] = "Erreur lors de l'envoi de l'email. Veuillez réessayer plus tard.";
    }

} catch (Exception $e) {
    $_SESSION['flash_error'] = "Erreur serveur : " . $e->getMessage();
}

header("Location: edit_profile.php");
exit();
