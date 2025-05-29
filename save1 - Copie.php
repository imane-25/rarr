<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artisanat_beldi"; // Remplacez par votre nom de base de données

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

header('Content-Type: application/json');

// Vérifier si les données ont été envoyées
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['orders']) && isset($_POST['paymentMethod']) && isset($_POST['userId'])) {
    // Récupérer les données envoyées
    $orders = json_decode($_POST['orders'], true);
    $paymentMethod = $_POST['paymentMethod'];
    $userId = $_POST['userId'];  // Récupérer l'id de l'utilisateur (assurez-vous qu'il est valide)

    // Boucle pour insérer chaque ligne de commande dans la base de données
    foreach ($orders as $order) {
        $productId = $order['id'];       // ID du produit
        $produit_nom = $order['nom'];    // Nom du produit
        $quantite = $order['quantite'];  // Quantité commandée
        $prix = $order['prix'];          // Prix du produit
        $total = $order['total'];        // Total de la commande (quantité * prix)

        // Préparer la requête SQL pour insérer les données
        $sql = "INSERT INTO commande (user_id, product_id, produit_nom, quantite, prix, total, paiement_method) 
                VALUES ('$userId', '$productId', '$produit_nom', '$quantite', '$prix', '$total', '$paymentMethod')";

        if ($conn->query($sql) === TRUE) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false, 'message' => 'Erreur d\'insertion dans la base de données: ' . $conn->error);
        }
    }

    // Fermer la connexion
    $conn->close();

    // Retourner la réponse en JSON
    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Données manquantes.'));
}
?>
