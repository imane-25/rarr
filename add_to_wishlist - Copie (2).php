<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Non connecté']);
    exit;
}

if (!isset($_POST['product_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Données manquantes']);
    exit;
}

$productId = intval($_POST['product_id']);
$userId = $_SESSION['user']['id'];

// Vérifier si le produit est déjà dans les favoris
$sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Déjà dans les favoris']);
} else {
    $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    echo json_encode(['status' => 'success', 'message' => 'Ajouté aux favoris']);
}
?>