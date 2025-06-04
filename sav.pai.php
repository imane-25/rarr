<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artisanat_beldi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Lire les données envoyées via POST (en JSON)
$input = json_decode(file_get_contents('php://input'), true);

// Vérifier si les données nécessaires existent
if (!isset($input['user_id']) || !isset($input['order_lines']) || !isset($input['payment_method'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit();
}

$user_id = $input['user_id'];
$order_lines = $input['order_lines'];
$payment_method = $input['payment_method'];

// Commencer une transaction pour assurer que tout se passe bien
$conn->begin_transaction();

try {
    // Boucle à travers chaque ligne de commande (produit)
    foreach ($order_lines as $line) {
        $product_id = $line['id'];
        $quantity = $line['quantite'];
        $total_price = $line['total'];

        // Préparer et exécuter l'insertion dans la table order_details
        $stmt = $conn->prepare("INSERT INTO order_details (user_id, product_id, payment_method, quantite, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdi", $user_id, $product_id, $payment_method, $quantity, $total_price);
        $stmt->execute();
    }

    // Commit de la transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Commande enregistrée avec succès']);
} catch (Exception $e) {
    // Si une erreur se produit, annuler la transaction
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de la commande : ' . $e->getMessage()]);
}

// Fermer la connexion
$conn->close();
?><script>
  const userId = <?= isset($user['id']) ? intval($user['id']) : 'null'; ?>;
</script>
