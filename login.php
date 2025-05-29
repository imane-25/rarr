<?php
session_start();
ini_set('session.cookie_lifetime', 86400); // 1 jour
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
// Activer le débogage (à désactiver en production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=artisanat_beldi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ajoutez tous les champs nécessaires à la requête
        $stmt = $pdo->prepare("SELECT id, email, nom, prenom, ville, age, adresse, code_postal, pays, telephone, password, photo FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Stockez toutes les informations de l'utilisateur dans la session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'age' => $user['age'],
                'ville' => $user['ville'],
                'adresse' => $user['adresse'] ?? null, // Assurez-vous que ces champs existent
                'pays' => $user['pays'] ?? null,
                'code_postal' => $user['code_postal'] ?? null, // Utilisez un underscore au lieu d'un espace
                'telephone' => $user['telephone'] ?? null,
                'photo' => $user['photo'] ?? null,
                'date_inscription' => date('Y-m-d H:i:s'),
            ];  if ($user['email'] === 'imaneoussadm1095@gmail.com') {
        header("Location: h.php");
        exit();
    }
            // Redirection en cas de succès
            header("Location: profile.php");
            exit();
        } else {
            // Retourner une erreur JSON si échec
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Email ou mot de passe incorrect']);
            exit();
        }
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erreur technique : ' . $e->getMessage()]);
        exit();
    }
} else {
    header("Location: login.html");
    exit();
}
?>