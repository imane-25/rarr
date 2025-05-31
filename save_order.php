<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

$user_id = $_SESSION['user']['id'];

if (!isset($_POST['orders'])) {
    echo json_encode(['success' => false, 'message' => 'Données de commande manquantes.']);
    exit;
}

$orders = json_decode($_POST['orders'], true);

if (!is_array($orders) || count($orders) === 0) {
    echo json_encode(['success' => false, 'message' => 'Format de commande invalide.']);
    exit;
}

$dsn = 'mysql:host=localhost;dbname=artisanat_beldi;charset=utf8mb4';
$username = 'root';
$password = '';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->beginTransaction();

    $stmtOrder = $pdo->prepare("INSERT INTO order_details (user_id, product_id, quantite, total, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmtFacture = $pdo->prepare("INSERT INTO facture (order_id, user_id, montant, date_facture) VALUES (?, ?, ?, NOW())");

    $validPaymentMethods = ['online', 'delivery'];

    foreach ($orders as $order) {
        if (!isset($order['id'], $order['quantite'], $order['total'], $order['payment_method'])) continue;

        $paymentMethod = strtolower($order['payment_method']);
        if (!in_array($paymentMethod, $validPaymentMethods)) continue;

        // Insert order line
        $stmtOrder->execute([
            $user_id,
            $order['id'],
            $order['quantite'],
            $order['total'],
            $paymentMethod
        ]);

        // Récupérer l'id inséré
        $order_id = $pdo->lastInsertId();

        // Insert facture liée
        $stmtFacture->execute([
            $order_id,
            $user_id,
            $order['total']
        ]);
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Commandes et factures insérées avec succès.']);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
?>
