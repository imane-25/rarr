<?php
session_start();
include 'connexion.php'; // Inclure votre fichier de connexion à la base de données

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'];
$product_id = $data['product_id'];
$quantity = $data['quantity'];
$order_date = $data['order_date'];
$status = $data['status'];

// Vérifier si le produit existe déjà dans le panier
$query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mettre à jour la quantité et le prix total
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;
    $total_price = $new_quantity * $row['total_price'] / $row['quantity']; // Calculer le nouveau prix total

    $updateQuery = "UPDATE cart SET quantity = ?, total_price = ? WHERE user_id = ? AND product_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("idii", $new_quantity, $total_price, $user_id, $product_id);
    $updateStmt->execute();
} else {function getProductPrice($product_id) {
    global $conn; // Connexion MySQLi

    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return (float)$row['price'];
    }

    return 0; // Si le produit n’est pas trouvé
}


    // Insérer un nouvel enregistrement
    $insertQuery = "INSERT INTO cart (user_id, product_id, quantity, total_price, order_date, status) VALUES (?, ?, ?, ?, ?, ?)";
    $total_price = $quantity * getProductPrice($product_id); // Fonction pour obtenir le prix du produit
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iiidsi", $user_id, $product_id, $quantity, $total_price, $order_date, $status);
    $insertStmt->execute();
}

echo json_encode(['success' => true]);
?>
