<?php
session_start();

if (!isset($_GET['id'])) {
    echo "ID paiement manquant.";
    exit();
}

$id = intval($_GET['id']);
$conn = new mysqli("localhost", "root", "", "artisanat_beldi");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM paiements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Paiement introuvable.";
    exit();
}

$paiement = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Facture</title>
  <style>
    body { font-family: Arial; padding: 30px; background: #f5f5f5; }
    .facture { background: #fff; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { color: #4a6bff; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    td { padding: 10px; border-bottom: 1px solid #ddd; }
    .footer { margin-top: 30px; font-style: italic; text-align: center; }
  </style>
</head>
<body>

<div class="facture">
  <h2>Facture de paiement</h2>
  <table>
    <tr><td><strong>Nom :</strong></td><td><?= htmlspecialchars($paiement['prenom_utilisateur']) ?> <?= htmlspecialchars($paiement['nom_utilisateur']) ?></td></tr>
    <tr><td><strong>Méthode :</strong></td><td><?= htmlspecialchars($paiement['methode_paiement']) ?></td></tr>
    <tr><td><strong>Date :</strong></td><td><?= htmlspecialchars($paiement['date_paiement']) ?></td></tr>
    <tr><td><strong>Statut :</strong></td><td><?= htmlspecialchars($paiement['statut']) ?></td></tr>
    <tr><td><strong>Carte :</strong></td><td>**** **** **** <?= substr($paiement['numero_carte'], -4) ?></td></tr>
  </table>

  <div class="footer">
    Merci pour votre achat !
  </div>
</div>

</body>
</html>
