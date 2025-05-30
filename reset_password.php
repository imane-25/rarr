<?php
session_start();

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

$token = $_GET['token'] ?? '';
$valid = false;
$user_id = null;
$error = '';

if ($token) {
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT user_id, expires_at FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (strtotime($row['expires_at']) > time()) {
                $valid = true;
                $user_id = $row['user_id'];
            } else {
                $error = "Le lien de réinitialisation a expiré.";
            }
        } else {
            $error = "Lien invalide.";
        }
    } catch (Exception $e) {
        $error = "Erreur serveur : " . $e->getMessage();
    }
} else {
    $error = "Lien invalide.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid) {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (strlen($new_password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Mise à jour du mot de passe en base
        $hash = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
        $stmt->execute([$hash, $user_id]);

        // Supprimer le token après utilisation
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $_SESSION['flash_success'] = "Votre mot de passe a bien été modifié. Vous pouvez maintenant vous connecter.";
        header("Location: login.html");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe | Beldi</title>
    <style>
        body { font-family: Arial; background: #f8f4f1; margin: 40px; }
        form { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #9e6d6d; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #7e4f4f; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Réinitialisation du mot de passe</h2>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($valid): ?>
<form method="post">
    <label>Nouveau mot de passe</label>
    <input type="password" name="new_password" required minlength="8">

    <label>Confirmer le mot de passe</label>
    <input type="password" name="confirm_password" required minlength="8">

    <button type="submit">Changer mon mot de passe</button>
</form>
<?php else: ?>
    <p>Le lien est invalide ou expiré. Veuillez redemander une réinitialisation.</p>
<?php endif; ?>

</body>
</html>
