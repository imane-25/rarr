<?php
// Configuration de la base de données
define('DB_HOST', 'localhost'); // Adresse du serveur MySQL
define('DB_USER', 'root');      // Nom d'utilisateur MySQL
define('DB_PASS', '');          // Mot de passe MySQL
define('DB_NAME', 'artisanat_beldi'); // Nom de la base de données

// Tentative de connexion à la base de données
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Vérifier la connexion
    if ($conn->connect_error) {
        throw new Exception("Échec de la connexion à la base de données: " . $conn->connect_error);
    }
    
    // Définir le jeu de caractères
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    // Enregistrer l'erreur et afficher un message générique
    error_log($e->getMessage());
    die("Une erreur est survenue lors de la connexion à la base de données. Veuillez réessayer plus tard.");
}

// Configuration du site
define('SITE_NAME', 'Artisanat Marocain Beldi');
define('SITE_URL', 'http://localhost/beldi'); // URL de base du site
define('ADMIN_EMAIL', 'contact@beldi-artisanat.com');

// Configuration des sessions
session_set_cookie_params([
    'lifetime' => 86400, // 1 jour
    'path' => '/',
    'domain' => '', // Laissez vide pour le domaine actuel
    'secure' => false, // Mettez à true en production avec HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fonction pour sécuriser les données
function sanitize($data) {
    global $conn;
    return htmlspecialchars(strip_tags($conn->real_escape_string(trim($data))));
}

// Fonction pour rediriger
function redirect($url) {
    header("Location: $url");
    exit;
}

// Fonction pour générer un token CSRF
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Vérifier le token CSRF
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
