<?php
session_start();

if (!isset($_SESSION['user']['email'])) {
    die("Vous devez être connecté pour voir vos factures.");
}

$email = $_SESSION['user']['email'];

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Récupérer l'ID utilisateur depuis l'email en session
    $stmtUser = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email LIMIT 1");
    $stmtUser->execute([':email' => $email]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Utilisateur non trouvé.");
    }

    $userId = $user['id'];

    // 2. Récupérer les factures liées à cet utilisateur
    $stmtFactures = $pdo->prepare("
        SELECT f.*, od.payment_method, od.delivery_person_id, od.delivery_company_id,
               dp.name AS delivery_person_name, dc.company_name AS delivery_company_name,
               u.nom, u.prenom, u.email
        FROM facture f
        INNER JOIN order_details od ON f.order_id = od.id
        LEFT JOIN delivery_persons dp ON od.delivery_person_id = dp.delivery_person_id
        LEFT JOIN delivery_companies dc ON od.delivery_company_id = dc.delivery_company_id
        INNER JOIN utilisateurs u ON f.user_id = u.id
        WHERE f.user_id = :user_id
        ORDER BY f.date_facture DESC
    ");
    $stmtFactures->execute([':user_id' => $userId]);
    $factures = $stmtFactures->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Mes Factures</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 30px auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #D4A76A; color: white; }
        h1 { color: #8B5A2B; text-align: center; }
        .btn-print {
            display: inline-block;
            margin-top: 20px;
            background: #8B5A2B;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Mes Factures</h1>
    <?php if (empty($factures)): ?>
        <p>Aucune facture trouvée pour ce compte.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Référence Facture</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Méthode Paiement</th>
                    <th>Livreur</th>
                    <th>Entreprise Livraison</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($factures as $facture): ?>
                    <tr>
                        <td><?= htmlspecialchars($facture['id']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($facture['date_facture'])) ?></td>
                        <td><?= number_format($facture['montant'], 2, ',', ' ') ?> MAD</td>
                        <td><?= htmlspecialchars($facture['payment_method'] ?? 'Non renseigné') ?></td>
                        <td><?= htmlspecialchars($facture['delivery_person_name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($facture['delivery_company_name'] ?? 'N/A') ?></td>
                        <td><a class="btn-print" href="facture_detail.php?facture_id=<?= $facture['id'] ?>" target="_blank">Voir Détails</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
