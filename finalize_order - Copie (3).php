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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    // Récupérer l'ID de la commande
    $orderId = $_POST['order_id'];
    
    // Vérification de l'existence de la commande
    $sqlCheck = "SELECT * FROM commande WHERE id = '$orderId' AND statut = 'pending'";
    $result = $conn->query($sqlCheck);

    if ($result->num_rows > 0) {
        // Mise à jour de la commande pour la marquer comme 'completed'
        $sqlUpdate = "UPDATE commande SET statut = 'completed' WHERE id = '$orderId'";
        
        if ($conn->query($sqlUpdate) === TRUE) {
            // Retourner une réponse de succès
            $response = array('success' => true, 'message' => 'La commande a été finalisée avec succès.');
        } else {
            // Retourner une réponse d'erreur si la mise à jour échoue
            $response = array('success' => false, 'message' => 'Erreur lors de la finalisation de la commande.');
        }
    } else {
        // Si la commande n'est pas trouvée ou déjà finalisée
        $response = array('success' => false, 'message' => 'Commande invalide ou déjà finalisée.');
    }

    // Fermer la connexion
    $conn->close();
} else {
    // Si les paramètres ne sont pas fournis correctement
    $response = array('success' => false, 'message' => 'Données manquantes.');
}

// Retourner la réponse en JSON
echo json_encode($response);
?>
