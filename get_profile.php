<?php
session_start();
header('Content-Type: application/json');

require 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die(json_encode(['error' => 'Non authentifié']));
}

try {
    // Récupérer les infos de base
    $stmt = $db->prepare("SELECT name, email, address, phone, created_at FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        http_response_code(404);
        die(json_encode(['error' => 'Utilisateur non trouvé']));
    }
    
    // Compter les commandes
    $stmt = $db->prepare("SELECT COUNT(*) as orders_count FROM orders WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $orders = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode(array_merge($user, $orders));
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données: ' . $e->getMessage()]);
}
?>