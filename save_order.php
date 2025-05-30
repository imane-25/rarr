<?php
session_start();
header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

$user_id = $_SESSION['user']['id'];

// Vérifier si les données sont bien envoyées
if (!isset($_POST['orders'])) {
    echo json_encode(['success' => false, 'message' => 'Données de commande manquantes.']);
    exit;
}

$orders = json_decode($_POST['orders'], true);

if (!is_array($orders) || count($orders) === 0) {
    echo json_encode(['success' => false, 'message' => 'Format de commande invalide.']);
    exit;
}

// Connexion à la base de données (à adapter)
$dsn = 'mysql:host=localhost;dbname=artisanat_beldi;charset=utf8mb4';
$username = 'root';
$password = ''; // ou ton mot de passe MySQL
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    $stmt = $pdo->prepare("INSERT INTO order_details (user_id, product_id, quantite, total) VALUES (?, ?, ?, ?)");

    foreach ($orders as $order) {
        // Vérifier les données minimales
        if (!isset($order['id'], $order['quantite'], $order['total'])) continue;

        $stmt->execute([
            $user_id,
            $order['id'],          // product_id
            $order['quantite'],
            $order['total']
        ]);
    }

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur BDD : ' . $e->getMessage()]);
}
?>