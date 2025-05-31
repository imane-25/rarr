<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
        throw new Exception("ID de commande manquant.");
    }

    $orderId = intval($_GET['order_id']);

    // Récupérer la facture, les infos client, la commande, le livreur et la société de livraison
    $stmt = $pdo->prepare("
        SELECT f.*, 
               u.nom, u.prenom, u.age, u.ville, u.adresse, u.pays, u.code_postal, u.email, u.telephone,
               od.payment_method,
               dp.name AS delivery_person_name, dp.phone AS delivery_person_phone, dp.email AS delivery_person_email,
               dp.region AS delivery_person_region, dp.city AS delivery_person_city, dp.country AS delivery_person_country, dp.address AS delivery_person_address,
               dc.company_name AS delivery_company_name, dc.contact_number AS delivery_company_phone, dc.contact_email AS delivery_company_email,
               dc.region AS delivery_company_region, dc.city AS delivery_company_city, dc.country AS delivery_company_country, dc.address AS delivery_company_address
        FROM facture f
        INNER JOIN order_details od ON od.id = f.order_id
        INNER JOIN utilisateurs u ON u.id = od.user_id
        LEFT JOIN delivery_persons dp ON dp.delivery_person_id = od.delivery_person_id
        LEFT JOIN delivery_companies dc ON dc.delivery_company_id = od.delivery_company_id
        WHERE f.order_id = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    $facture = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$facture) {
        throw new Exception("Facture introuvable pour la commande #$orderId.");
    }

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Facture Commande #<?= htmlspecialchars($orderId) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ddd;
            color: #5C4033;
        }
        h1 {
            text-align: center;
            color: #8B5A2B;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #D4A76A;
            color: #fff;
        }
        .section-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #E2725B;
            border-bottom: 2px solid #D4A76A;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Facture pour la commande #<?= htmlspecialchars($orderId) ?></h1>

    <div class="section-title">Informations Client</div>
    <table>
        <tr><th>Nom</th><td><?= htmlspecialchars($facture['nom']) ?></td></tr>
        <tr><th>Prénom</th><td><?= htmlspecialchars($facture['prenom']) ?></td></tr>
        <tr><th>Âge</th><td><?= htmlspecialchars($facture['age']) ?></td></tr>
        <tr><th>Ville</th><td><?= htmlspecialchars($facture['ville']) ?></td></tr>
        <tr><th>Adresse</th><td><?= nl2br(htmlspecialchars($facture['adresse'])) ?></td></tr>
        <tr><th>Pays</th><td><?= htmlspecialchars($facture['pays']) ?></td></tr>
        <tr><th>Code Postal</th><td><?= htmlspecialchars($facture['code_postal']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($facture['email']) ?></td></tr>
        <tr><th>Téléphone</th><td><?= htmlspecialchars($facture['telephone']) ?></td></tr>
    </table>

    <div class="section-title">Détails de la Commande</div>
    <table>
        <tr><th>Méthode de Paiement</th><td><?= htmlspecialchars($facture['payment_method']) ?></td></tr>
        <tr><th>Montant</th><td><?= number_format($facture['montant'], 2, ',', ' ') ?> MAD</td></tr>
        <tr><th>Date Facture</th><td><?= date('d/m/Y H:i', strtotime($facture['date_facture'])) ?></td></tr>
    </table>

    <div class="section-title">Livreur</div>
    <?php if ($facture['delivery_person_name']): ?>
    <table>
        <tr><th>Nom</th><td><?= htmlspecialchars($facture['delivery_person_name']) ?></td></tr>
        <tr><th>Téléphone</th><td><?= htmlspecialchars($facture['delivery_person_phone']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($facture['delivery_person_email']) ?></td></tr>
        <tr><th>Région</th><td><?= htmlspecialchars($facture['delivery_person_region']) ?></td></tr>
        <tr><th>Ville</th><td><?= htmlspecialchars($facture['delivery_person_city']) ?></td></tr>
        <tr><th>Pays</th><td><?= htmlspecialchars($facture['delivery_person_country']) ?></td></tr>
        <tr><th>Adresse</th><td><?= nl2br(htmlspecialchars($facture['delivery_person_address'])) ?></td></tr>
    </table>
    <?php else: ?>
    <p>Pas de livreur assigné.</p>
    <?php endif; ?>

    <div class="section-title">Entreprise de Livraison</div>
    <?php if ($facture['delivery_company_name']): ?>
    <table>
        <tr><th>Nom</th><td><?= htmlspecialchars($facture['delivery_company_name']) ?></td></tr>
        <tr><th>Téléphone</th><td><?= htmlspecialchars($facture['delivery_company_phone']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($facture['delivery_company_email']) ?></td></tr>
        <tr><th>Région</th><td><?= htmlspecialchars($facture['delivery_company_region']) ?></td></tr>
        <tr><th>Ville</th><td><?= htmlspecialchars($facture['delivery_company_city']) ?></td></tr>
        <tr><th>Pays</th><td><?= htmlspecialchars($facture['delivery_company_country']) ?></td></tr>
        <tr><th>Adresse</th><td><?= nl2br(htmlspecialchars($facture['delivery_company_address'])) ?></td></tr>
    </table>
    <?php else: ?>
    <p>Pas d'entreprise de livraison assignée.</p>
    <?php endif; ?>
    <!-- ... tout le contenu de ta facture ... -->

    

</body><button id="print-btn" onclick="window.print()" style="
        display: block;
        margin: 30px auto;
        padding: 10px 25px;
        font-size: 1rem;
        background-color: #D4A76A;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    ">🖨️ Imprimer la facture</button><button id="back-btn" onclick="window.location.href='pp.php'" style="
        padding: 10px 25px;
        font-size: 1rem;
        background-color: #8B5A2B;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    ">🔙 Retour</button><style>
  /* Ton style existant ici */

  @media print {
    #print-btn, #back-btn {
      display: none !important;
    }
  }
</style>
</html>
