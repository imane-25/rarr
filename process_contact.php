<?php
// Configuration de l'envoi d'email
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupération des données du formulaire
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Validation des données
if (empty($name) || empty($email) || empty($message)) {
    die("Tous les champs obligatoires doivent être remplis.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("L'adresse email n'est pas valide.");
}

// Configuration de l'email
$to = "imaneoussadm10@@gmail.com"; // Remplacez par votre adresse email
$email_subject = "Nouveau message de contact: " . htmlspecialchars($subject);
$email_body = "Vous avez reçu un nouveau message depuis le formulaire de contact.\n\n".
              "Nom: ".htmlspecialchars($name)."\n".
              "Email: ".htmlspecialchars($email)."\n".
              "Téléphone: ".htmlspecialchars($phone)."\n".
              "Sujet: ".htmlspecialchars($subject)."\n\n".
              "Message:\n".htmlspecialchars($message)."\n";

$headers = "From: ".htmlspecialchars($email)."\r\n";
$headers .= "Reply-To: ".htmlspecialchars($email)."\r\n";
$headers .= "X-Mailer: PHP/".phpversion();

// Envoi de l'email
$success = mail($to, $email_subject, $email_body, $headers);

// Redirection après envoi
if ($success) {
    header('Location: contact.php?status=success');
} else {
    header('Location: contact.php?status=error');
}
exit;
?>