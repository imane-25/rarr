<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User  not logged in']);
    exit;
}

$userId = $_SESSION['user']['id'];
$data = json_decode(file_get_contents('php://input'), true);

$productId = $data['product_id'];
$quantity = $data['quantity'];

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=artisanat_beldi', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Récupérer le prix du produit
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = :product_id");
    $stmt->execute(['product_id' => $productId]);
    $product = $stmt->fetch();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    $totalPrice = $product['price'] * $quantity;

    // Insérer la commande dans la table commande
    $stmt = $pdo->prepare("INSERT INTO commande (user_id, product_id, quantity, total_price, order_date) VALUES (:user_id, :product_id, :quantity, :total_price, NOW())");
    $stmt->execute([
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => $quantity,
        'total_price' => $totalPrice
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
