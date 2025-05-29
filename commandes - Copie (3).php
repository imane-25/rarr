<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
$host = 'localhost';
$dbname = 'artisanat';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement de la commande
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commander'])) {
    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'] ?? 1;
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    
    // Récupérer les infos du produit
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$produit_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($produit) {
        $prix_total = $produit['price'] * $quantite;
        
        // Enregistrer la commande
        $stmt = $pdo->prepare("INSERT INTO commandes 
                              (user_id, produit_id, produit_nom, quantite, prix_unitaire, prix_total, adresse_livraison, telephone) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $produit_id,
            $produit['title'],
            $quantite,
            $produit['price'],
            $prix_total,
            $adresse,
            $telephone
        ]);
        
        // Redirection avec message de succès
        $_SESSION['message'] = "Votre commande a été enregistrée avec succès!";
        header('Location: produits.php');
        exit();
    }
}