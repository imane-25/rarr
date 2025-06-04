<?php
session_start();

if (!isset($_SESSION['user']['id'])) {
    die("Vous devez être connecté pour voir vos factures.");
}

$userId = $_SESSION['user']['id'];

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les factures de l'utilisateur
    $stmtFactures = $pdo->prepare("
        SELECT f.*, u.nom, u.prenom, u.email
        FROM factures f
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
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($factures as $facture): ?>
                    <tr>
                        <td><?= htmlspecialchars($facture['id']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($facture['date_facture'])) ?></td>
                        <td><?= number_format($facture['montant'], 2, ',', ' ') ?> MAD</td>
                        <td><?= htmlspecialchars($facture['nom']) ?></td>
                        <td><?= htmlspecialchars($facture['prenom']) ?></td>
                        <td><?= htmlspecialchars($facture['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
