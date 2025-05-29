<?php
// enregistrer_commande.php

session_start();
header('Content-Type: application/json');

// Configuration de la base de données
$config = [
    'host' => 'localhost',
    'dbname' => 'artisanat_beldi',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];

try {
    // Connexion PDO
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $conn = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    // Vérification authentification
    if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
        throw new Exception("Authentification requise", 401);
    }

    $user_id = (int)$_SESSION['user']['id'];

    // Récupération du payload JSON
    $input = file_get_contents('php://input');
    if (empty($input)) {
        throw new Exception("Données manquantes", 400);
    }

    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON invalide: " . json_last_error_msg(), 400);
    }

    // Validation des commandes
    if (empty($data['commandes']) || !is_array($data['commandes'])) {
        throw new Exception("Aucune commande valide", 400);
    }

    // Préparation requête
    $stmt = $conn->prepare("
        INSERT INTO commandes (
            user_id, 
            produit_id, 
            produit_nom, 
            prix, 
            quantite, 
            date_commande
        ) VALUES (
            :user_id, 
            :produit_id, 
            :produit_nom, 
            :prix, 
            :quantite, 
            NOW()
        )
    ");

    // Traitement transactionnel
    $conn->beginTransaction();

    $commandes_enregistrees = 0;
    $errors = [];

    foreach ($data['commandes'] as $index => $commande) {
        try {
            // Validation des données
            $produit_id = filter_var($commande['produit_id'] ?? null, FILTER_VALIDATE_INT);
            $produit_nom = trim(strip_tags($commande['produit_nom'] ?? ''));
            $prix = filter_var($commande['prix'] ?? null, FILTER_VALIDATE_FLOAT);
            $quantite = filter_var($commande['quantite'] ?? 1, FILTER_VALIDATE_INT);

            // Vérification des données
            if ($produit_id === false || $produit_id <= 0) {
                throw new Exception("ID produit invalide à l'index $index");
            }

            if (empty($produit_nom)) {
                throw new Exception("Nom produit vide à l'index $index");
            }

            if ($prix === false || $prix <= 0) {
                throw new Exception("Prix invalide à l'index $index");
            }

            if ($quantite === false || $quantite <= 0) {
                throw new Exception("Quantité invalide à l'index $index");
            }

            // Exécution
            $stmt->execute([
                ':user_id' => $user_id,
                ':produit_id' => $produit_id,
                ':produit_nom' => $produit_nom,
                ':prix' => $prix,
                ':quantite' => $quantite
            ]);

            $commandes_enregistrees++;

        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }

    // Validation finale
    if (!empty($errors)) {
        $conn->rollBack();
        throw new Exception("Erreurs lors de l'enregistrement:\n- " . implode("\n- ", $errors), 400);
    }

    $conn->commit();

    // Réponse succès
    echo json_encode([
        'success' => true,
        'message' => "$commandes_enregistrees commande(s) enregistrée(s) avec succès",
        'count' => $commandes_enregistrees
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur base de données',
        'error' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
} catch (Exception $e) {
    http_response_code($e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
}