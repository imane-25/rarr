<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=artisanat_beldi;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les infos de l'admin (ex : admin_id = 1)
$stmt = $pdo->prepare("SELECT * FROM admins WHERE admin_id = :id");
$stmt->execute([':id' => 1]); // à remplacer par l'admin connecté si besoin
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    die("Administrateur introuvable.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Administrateur</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .profile-container h2 {
            margin: 10px 0;
        }
        .profile-info {
            margin: 15px 0;
            font-size: 16px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .email-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #d93025;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .email-link:hover {
            background-color: #b1271b;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin['name']) ?>&background=007BFF&color=fff&size=120" alt="Admin">
    <h2><?= htmlspecialchars($admin['name']) ?></h2>
    <div class="profile-info"><span class="label">Nom d'utilisateur :</span> <?= htmlspecialchars($admin['username']) ?></div>
    <div class="profile-info"><span class="label">Email :</span> <?= htmlspecialchars($admin['email']) ?></div>
    <div class="profile-info"><span class="label">Téléphone :</span> <?= htmlspecialchars($admin['phone']) ?></div>
    <div class="profile-info"><span class="label">Rôle :</span> <?= htmlspecialchars($admin['role']) ?></div>

    <a class="email-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($admin['email']) ?>" target="_blank">
        Contacter via Gmail
    </a>
</div>

</body>
</html>
