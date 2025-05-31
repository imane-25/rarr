<?php
// modifier_utilisateur.php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer l'ID de l'utilisateur
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID utilisateur invalide.");
}
$id = (int) $_GET['id'];

// Initialisation des variables pour le formulaire
$user = null;
$errors = [];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyer et valider les données reçues
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $age = (int)($_POST['age'] ?? 0);
    $ville = trim($_POST['ville'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $pays = trim($_POST['pays'] ?? '');
    $code_postal = trim($_POST['code_postal'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    // Validation basique
    if ($nom === '') $errors[] = "Le nom est obligatoire.";
    if ($prenom === '') $errors[] = "Le prénom est obligatoire.";
    if ($age <= 0) $errors[] = "L'âge doit être un nombre positif.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide.";

    if (empty($errors)) {
        // Mettre à jour la base
        $sql = "UPDATE utilisateurs SET nom = :nom, prenom = :prenom, age = :age, ville = :ville, adresse = :adresse, pays = :pays, code_postal = :code_postal, email = :email, telephone = :telephone WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':age' => $age,
            ':ville' => $ville,
            ':adresse' => $adresse,
            ':pays' => $pays,
            ':code_postal' => $code_postal,
            ':email' => $email,
            ':telephone' => $telephone,
            ':id' => $id
        ]);

        // Redirection après mise à jour
        header("Location: utilisateurs.php?success=1");
        exit();
    }
} else {
    // Récupérer les données actuelles de l'utilisateur pour pré-remplir le formulaire
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Utilisateur non trouvé.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Modifier utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f1e5;
            padding: 20px;
            color: #5C4033;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 6px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(139,90,43,0.2);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            margin-top: 20px;
            background: #8B5A2B;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        button:hover {
            background: #D4A76A;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
            color: #8B5A2B;
        }
    </style>
</head>
<body>

<h1>Modifier l'utilisateur</h1>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($_POST['nom'] ?? $user['nom'] ?? '') ?>" required>

    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? $user['prenom'] ?? '') ?>" required>

    <label for="age">Âge :</label>
    <input type="number" name="age" id="age" min="1" value="<?= htmlspecialchars($_POST['age'] ?? $user['age'] ?? '') ?>" required>

    <label for="ville">Ville :</label>
    <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($_POST['ville'] ?? $user['ville'] ?? '') ?>">

    <label for="adresse">Adresse :</label>
    <textarea name="adresse" id="adresse" rows="3"><?= htmlspecialchars($_POST['adresse'] ?? $user['adresse'] ?? '') ?></textarea>

    <label for="pays">Pays :</label>
    <input type="text" name="pays" id="pays" value="<?= htmlspecialchars($_POST['pays'] ?? $user['pays'] ?? '') ?>">

    <label for="code_postal">Code Postal :</label>
    <input type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($_POST['code_postal'] ?? $user['code_postal'] ?? '') ?>">

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? $user['email'] ?? '') ?>" required>

    <label for="telephone">Téléphone :</label>
    <input type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($_POST['telephone'] ?? $user['telephone'] ?? '') ?>">

    <button type="submit">Enregistrer</button>
</form>

</body>
</html>
