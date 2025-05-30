<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['user'];
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "artisanat_beldi";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $fields = ['prenom', 'nom', 'email', 'telephone', 'age', 'ville', 'adresse', 'pays', 'code_postal'];
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "Le champ $field est requis.";
            }
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("UPDATE utilisateurs SET prenom = ?, nom = ?, email = ?, telephone = ?, age = ?, ville = ?, adresse = ?, pays = ?, code_postal = ? WHERE id = ?");
            $stmt->execute([
                $_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['telephone'],
                $_POST['age'], $_POST['ville'], $_POST['adresse'], $_POST['pays'], $_POST['code_postal'],
                $user['id']
            ]);

            // MAJ session
            foreach ($fields as $f) {
                $_SESSION['user'][$f] = $_POST[$f];
            }

            $success = "Profil mis à jour avec succès.";
        }
    } catch (Exception $e) {
        $errors[] = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le profil | Beldi</title>
    <style>
        body { font-family: Arial; margin: 40px; background-color: #f8f4f1; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; }
        input, select { width: 100%; padding: 10px; margin: 8px 0; }
        .btn { background-color: #9e6d6d; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background-color: #7e4f4f; }
        .success { color: green; margin: 10px 0; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Modifier mon profil</h2>

<?php if ($success): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<?php foreach ($errors as $error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endforeach; ?>

<form method="post">
    <label>Prénom</label>
    <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>">

    <label>Nom</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">

    <label>Téléphone</label>
    <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>">

    <label>Âge</label>
    <input type="number" name="age" value="<?= htmlspecialchars($user['age']) ?>">

    <label>Ville</label>
    <input type="text" name="ville" value="<?= htmlspecialchars($user['ville']) ?>">

    <label>Adresse</label>
    <input type="text" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?>">

    <label>Pays</label>
    <input type="text" name="pays" value="<?= htmlspecialchars($user['pays']) ?>">

    <label>Code Postal</label>
    <input type="text" name="code_postal" value="<?= htmlspecialchars($user['code_postal']) ?>">

    <button type="submit" class="btn">Enregistrer les modifications</button>
</form>

</body>
</html>
