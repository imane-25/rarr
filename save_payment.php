<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

$user_id = $_SESSION['user']['id'];

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['orders']) || !is_array($data['orders']) || count($data['orders']) === 0) {
    echo json_encode(['success' => false, 'message' => 'Données de commande manquantes ou invalides.']);
    exit;
}

if (!isset($data['payment_method']) || !in_array($data['payment_method'], ['delivery', 'online'])) {
    echo json_encode(['success' => false, 'message' => 'Mode de paiement invalide.']);
    exit;
}

$orders = $data['orders'];
$payment_method = $data['payment_method'];

// Connexion BDD
$dsn = 'mysql:host=localhost;dbname=artisanat_beldi;charset=utf8mb4';
$username = 'root';
$password = '';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO order_details (user_id, product_id, payment_method, quantity, total_price, order_date, delivery_person_id, delivery_company_id) VALUES (?, ?, ?, ?, ?, NOW(), NULL, NULL)");

    foreach ($orders as $item) {
        if (!isset($item['id'], $item['quantite'], $item['total'])) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Données produit invalides.']);
            exit;
        }

        $stmt->execute([
            $user_id,
            $item['id'],
            $payment_method,
            $item['quantite'],
            $item['total']
        ]);
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Commande enregistrée avec succès.']);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Erreur BDD : ' . $e->getMessage()]);
}
?>
