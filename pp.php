<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mise à jour commande
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
        $orderId = intval($_POST['order_id']);
        $deliveryStatus = $_POST['delivery_status'] ?? 'En attente';
        $deliveryPersonId = !empty($_POST['delivery_person_id']) ? intval($_POST['delivery_person_id']) : null;
        $deliveryCompanyId = !empty($_POST['delivery_company_id']) ? intval($_POST['delivery_company_id']) : null;

        $stmtUpdate = $pdo->prepare("UPDATE order_details SET delivery_status = :status, delivery_person_id = :person_id, delivery_company_id = :company_id WHERE order_id = :order_id");
        $stmtUpdate->execute([
            ':status' => $deliveryStatus,
            ':person_id' => $deliveryPersonId,
            ':company_id' => $deliveryCompanyId,
            ':order_id' => $orderId
        ]);
    }

    // Récupérer commandes
    $stmt = $pdo->query("
        SELECT od.*, dp.name AS delivery_person_name, dc.company_name 
        FROM order_details od
        LEFT JOIN delivery_persons dp ON od.delivery_person_id = dp.delivery_person_id
        LEFT JOIN delivery_companies dc ON od.delivery_company_id = dc.delivery_company_id
        ORDER BY od.order_date DESC
    ");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer livreurs et entreprises pour listes déroulantes
    $deliveryPersons = $pdo->query("SELECT * FROM delivery_persons")->fetchAll(PDO::FETCH_ASSOC);
    $deliveryCompanies = $pdo->query("SELECT * FROM delivery_companies")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Gestion Livraison Commandes</title>
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 1200px; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        form { margin: 0; }
        select { width: 100%; padding: 5px; box-sizing: border-box; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Gestion des commandes et livraison</h1>

    <table>
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>ID Utilisateur</th>
                <th>ID Produit</th>
                <th>Quantité</th>
                <th>Prix Total</th>
                <th>Date Commande</th>
                <th>Statut Livraison</th>
                <th>Livreur</th>
                <th>Entreprise Livraison</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <form method="post">
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['user_id']) ?></td>
                        <td><?= htmlspecialchars($order['product_id']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td><?= number_format($order['total_price'], 2, ',', ' ') ?> MAD</td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>

                        <td>
                            <select name="delivery_status" required>
                                <?php
                                $statuses = ['En attente', 'En préparation', 'Expédiée', 'Livrée', 'Annulée'];
                                foreach ($statuses as $status) {
                                    $selected = ($order['delivery_status'] === $status) ? 'selected' : '';
                                    echo "<option value=\"$status\" $selected>$status</option>";
                                }
                                ?>
                            </select>
                        </td>

                        <td>
                            <select name="delivery_person_id">
                                <option value="">-- Aucun --</option>
                                <?php foreach ($deliveryPersons as $person): 
                                    $selected = ($order['delivery_person_id'] == $person['delivery_person_id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $person['delivery_person_id'] ?>" <?= $selected ?>><?= htmlspecialchars($person['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                        <td>
                            <select name="delivery_company_id">
                                <option value="">-- Aucun --</option>
                                <?php foreach ($deliveryCompanies as $company): 
                                    $selected = ($order['delivery_company_id'] == $company['delivery_company_id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $company['delivery_company_id'] ?>" <?= $selected ?>><?= htmlspecialchars($company['company_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                        <td>
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <button type="submit">Mettre à jour</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
