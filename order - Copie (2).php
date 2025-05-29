<?php
// Connexion à la base de données
$servername = "localhost";
$username = "votre_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "votre_base_de_donnees";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupération des données du formulaire
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $user_id = $_POST['user_id'];
    $total = $_POST['total'];
    $orders = explode("\n", $_POST['orders']);
    
    // Pour chaque plat commandé
    foreach ($orders as $order) {
        if (!empty(trim($order))) {
            // Extraire le nom du produit et le prix
            $parts = explode(' - ', $order);
            $produit_nom = $parts[0];
            $prix = str_replace(' DH', '', $parts[1]);
            
            // Ici vous devriez normalement récupérer le produit_id depuis la base
            // Pour cet exemple, nous allons utiliser 0 comme placeholder
            $produit_id = 0;
            
            // Insertion dans la table commandes
            $stmt = $conn->prepare("INSERT INTO commandes 
                (produit_id, produit_nom, prix, quantite, user_id) 
                VALUES (:produit_id, :produit_nom, :prix, :quantite, :user_id)");
            
            $stmt->bindParam(':produit_id', $produit_id);
            $stmt->bindParam(':produit_nom', $produit_nom);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':user_id', $user_id);
            $quantite = 1;
$stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT); // Quantité par défaut à 1

            $stmt->execute();
        }
    }
    
    // Redirection vers une page de confirmation
    header("Location: confirmation.php");
    exit();
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null;
?>