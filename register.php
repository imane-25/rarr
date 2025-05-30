<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "artisanat_beldi";

    try {
        // Champs requis
        $required = ['nom', 'prenom', 'age', 'ville', 'adresse', 'pays', 'code_postal', 'email'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis.");
            }
        }

        // Vérifications spécifiques
        if ($_POST['age'] < 18) throw new Exception("Vous devez avoir au moins 18 ans.");
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) throw new Exception("Format d'email invalide.");
        if (empty($_POST['password'])) throw new Exception("Le mot de passe est requis.");
        if ($_POST['password'] !== $_POST['confirm_password']) throw new Exception("Les mots de passe ne correspondent pas.");
        if (strlen($_POST['password']) < 8) throw new Exception("Mot de passe trop court.");

        // Traitement de la photo
        $photoName = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/profiles/';
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photoName = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);
        }

        // Hash du mot de passe
        $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Connexion à la base
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertion en base
        $stmt = $pdo->prepare("INSERT INTO utilisateurs 
            (nom, prenom, age, ville, adresse, pays, code_postal, email, telephone, photo, password, date_inscription) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        $stmt->execute([
            $_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['ville'],
            $_POST['adresse'], $_POST['pays'], $_POST['code_postal'],
            $_POST['email'], $_POST['telephone'] ?? null, $photoName, $passwordHash
        ]);

        // Sauvegarde des données utilisateur en session
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

        // 🔁 Redirection spéciale selon l'email
        $email = trim($_POST['email']);

        if ($email === 'ahmed@example.com') {
            $_SESSION['role'] = 'Super Admin';
            header("Location: h.php");
            exit();
        } elseif ($email === 'fatimaa@example.com') {
            $_SESSION['role'] = 'Responsable produits';
            header("Location: h.php");
            exit();
        } elseif ($email === 'youssef@example.com') {
            $_SESSION['role'] = 'Gestionnaire commandes';
            header("Location: h.php");
            exit();
        }

        // 🎯 Redirection standard pour les autres
        header("Location: home.php");
        exit();

    } catch (PDOException $e) {
        die("Erreur de base de données: " . $e->getMessage());
    } catch (Exception $e) {
        die("Erreur: " . $e->getMessage());
    }

} else {
    // Accès direct interdit
    header("Location: inscription.php");
    exit();
}
?>
