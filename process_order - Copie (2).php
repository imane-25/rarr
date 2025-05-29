<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artisanat_beldi";

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
    $order_details = $_POST['order_details'];
    
    // Pour chaque produit dans le panier
    $orders = explode("\n", trim($order_details));
    foreach ($orders as $order) {
        if (!empty(trim($order))) {
            // Extraire le nom du produit et le prix
            $parts = explode(' - ', $order);
            $product_name = trim($parts[0]);
            $price = str_replace(' DH', '', trim($parts[1]));
            
            // Trouver l'ID du produit dans votre tableau JavaScript
            // En pratique, vous devriez le chercher dans la base de données
            $product_id = 0; // À remplacer par la recherche réelle
            
            // Insertion dans la table commandes
            $stmt = $conn->prepare("INSERT INTO commandes 
                (produit_id, produit_nom, prix, quantite, user_id) 
                VALUES (:produit_id, :produit_nom, :prix, :quantite, :user_id)");
            
            $stmt->bindParam(':produit_id', $product_id);
            $stmt->bindParam(':produit_nom', $product_name);
            $stmt->bindParam(':prix', $price);
            $quantite = 1;
            $stmt->bindParam(':quantite', $quantite);
            $stmt->bindParam(':user_id', $user_id);
            
            $stmt->execute();
        }
    }
    
    // Envoyer un email de confirmation (optionnel)
    // ...
    
    // Redirection vers une page de confirmation
    header("Location: confirmation.php");
    exit();
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null;
?>