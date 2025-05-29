<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuration de la base de données
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "artisanat_beldi";

    try {
        // Validation des données
        $required = ['nom', 'prenom', 'age', 'ville', 'adresse', 'pays', 'code_postal', 'email'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis.");
            }
        }

        if ($_POST['age'] < 18) {
            throw new Exception("Vous devez avoir au moins 18 ans.");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide.");
        }

        // Traitement du fichier photo
        $photoName = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/profiles/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photoName = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);
        }
        if (empty($_POST['password'])) {
            throw new Exception("Le mot de passe est requis.");
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            throw new Exception("Les mots de passe ne correspondent pas.");
        }

        if (strlen($_POST['password']) < 8) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères.");
        }

        // Hash du mot de passe
        $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        // Connexion à la base
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
        ;

        // Insertion
        $stmt = $pdo->prepare("INSERT INTO utilisateurs 
        (nom, prenom, age, ville, adresse, pays, code_postal, email, telephone, photo, password, date_inscription) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");


$stmt->execute([
    $_POST['nom'],
    $_POST['prenom'],
    $_POST['age'],
    $_POST['ville'],
    $_POST['adresse'],
    $_POST['pays'],
    $_POST['code_postal'],
    $_POST['email'],
    $_POST['telephone'] ?? null,
    $photoName,
    $passwordHash
]);

        // Création de la session utilisateur
   // Après l'insertion réussie en base de données
$_SESSION['user'] = [
    'id' => $pdo->lastInsertId(),
    'email' => $_POST['email'],
    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'age' => $_POST['age'],
    'ville' => $_POST['ville'],
    'adresse' => $_POST['adresse'],
    'pays' => $_POST['pays'],
    'code_postal' => $_POST['code_postal'],
    'telephone' => $_POST['telephone'] ?? null,
    'photo' => $photoName ?? null,
    'date_inscription' => date('Y-m-d H:i:s'),
];
        // Redirection vers le profil
        header("Location: profile.php");
        // Redirection vers home.html
        header("Location: home.php");
        exit();

    } catch (PDOException $e) {
        die("Erreur de base de données: " . $e->getMessage());
    } catch (Exception $e) {
        die("Erreur: " . $e->getMessage());
    }
} else {
    header("Location: inscription.php");
    exit();
}
?>