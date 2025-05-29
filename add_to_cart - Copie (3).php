<?php
header('Content-Type: application/json');
require_once 'data.php';
session_start();

$response = ['success' => false];

// Vérifier si la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    try {
        $pdo = Database::connect();
        
        // 1. Vérifier si l'utilisateur a un panier actif
        $cartId = null;
        
        if (!empty($data['user_id'])) {
            $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ? AND status = 'active'");
            $stmt->execute([$data['user_id']]);
            $cart = $stmt->fetch();
            
            if (!$cart) {
                // Créer un nouveau panier
                $stmt = $pdo->prepare("INSERT INTO carts (user_id, created_at) VALUES (?, NOW())");
                $stmt->execute([$data['user_id']]);
                $cartId = $pdo->lastInsertId();
            } else {
                $cartId = $cart['id'];
            }
        } else {
            // Gestion des paniers pour visiteurs non connectés (si nécessaire)
            // ...
        }
        
        // 2. Ajouter le produit au panier
        if ($cartId) {
            // Vérifier si le produit est déjà dans le panier
            $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?");
            $stmt->execute([$cartId, $data['product_id']]);
            $existingItem = $stmt->fetch();
            
            if ($existingItem) {
                // Mettre à jour la quantité
                $newQuantity = $existingItem['quantity'] + $data['quantity'];
                $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
                $stmt->execute([$newQuantity, $existingItem['id']]);
            } else {
                // Ajouter un nouvel item
                $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$cartId, $data['product_id'], $data['quantity']]);
            }
            
            // Compter le nombre total d'articles
            $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart_items WHERE cart_id = ?");
            $stmt->execute([$cartId]);
            $total = $stmt->fetch()['total'];
            
            $response = [
                'success' => true,
                'cart_count' => $total,
                'message' => 'Produit ajouté au panier'
            ];
        }
    } catch (PDOException $e) {
        $response['message'] = "Erreur base de données: " . $e->getMessage();
    }
}

echo json_encode($response);
?>