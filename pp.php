<?php
session_start();

$user = null;
if (isset($_SESSION['user'])) {
    $user = [
        'id' => $_SESSION['user']['id'] ?? 0,
        'email' => htmlspecialchars($_SESSION['user']['email'] ?? ''),
        'nom' => htmlspecialchars($_SESSION['user']['nom'] ?? ''),
        'prenom' => htmlspecialchars($_SESSION['user']['prenom'] ?? ''),
        'ville' => htmlspecialchars($_SESSION['user']['ville'] ?? ''),
        'age' => $_SESSION['user']['age'] ?? 0
    ];
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
        $orderId = intval($_POST['order_id']);
        $deliveryPersonId = !empty($_POST['delivery_person_id']) ? intval($_POST['delivery_person_id']) : null;
        $deliveryCompanyId = !empty($_POST['delivery_company_id']) ? intval($_POST['delivery_company_id']) : null;

        $stmtUpdate = $pdo->prepare("UPDATE order_details SET delivery_person_id = :person_id, delivery_company_id = :company_id WHERE id = :order_id");
        $stmtUpdate->execute([
            ':person_id' => $deliveryPersonId,
            ':company_id' => $deliveryCompanyId,
            ':order_id' => $orderId
        ]);
    }

    // Récupérer les commandes
    $stmt = $pdo->query("
        SELECT od.*, dp.name AS delivery_person_name, dc.company_name 
        FROM order_details od
        LEFT JOIN delivery_persons dp ON od.delivery_person_id = dp.delivery_person_id
        LEFT JOIN delivery_companies dc ON od.delivery_company_id = dc.delivery_company_id
        ORDER BY od.order_date DESC
    ");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer livreurs et entreprises
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Livraison Commandes | Artisanat Beldi</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #8B5A2B; /* Marron bois */
            --secondary: #D4A76A; /* Or marocain */
            --terracotta: #E2725B; /* Terre cuite */
            --ivory: #FFFFF0; /* Fond ivoire */
            --dark-wood: #5C4033; /* Texte foncé */
            --light-bg: #F8F1E5; /* Fond clair */
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
.dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            z-index: 1;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            border-radius: 4px;
            overflow: hidden;    flex-direction: column; /* ← disposition verticale */

        }

        .profile-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            color: var(--dark-wood);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: all 0.3s;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .dropdown-menu a:hover {
            background-color: #f8f8f8;
            color: var(--gold);
            padding-left: 20px;
        }

        .profile-trigger {
            cursor: pointer;
        }
    
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-wood);
            line-height: 1.6;
            padding-top: 90px;
        }

        /* Header Styles */
        header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 1px solid rgba(139, 90, 43, 0.15);
            box-shadow: var(--shadow);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 15px 30px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            height: 50px;
            transition: var(--transition);
        }

        .logo:hover img {
            transform: rotate(-5deg);
        }

        .logo-text h1 {
            font-size: 28px;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .logo-text h1 .first-letter {
            color: var(--terracotta);
            font-size: 32px;
        }

        .logo-text p {
            font-size: 12px;
            color: var(--dark-wood);
            margin: 0;
            letter-spacing: 1px;
            font-weight: 500;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--dark-wood);
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            position: relative;
            padding: 5px 0;
            transition: var(--transition);
        }

        nav ul li a:hover {
            color: var(--secondary);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: var(--transition);
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        /* Main Content */
        .main-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 30px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--secondary);
        }

        /* Table Styles */
        .orders-table-container {
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 20px;
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        .orders-table thead {
            background: var(--primary);
            color: white;
        }

        .orders-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .orders-table td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(139, 90, 43, 0.1);
            vertical-align: middle;
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .orders-table tr:hover {
            background: rgba(212, 167, 106, 0.05);
        }

        .form-row {
            margin: 0;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            color: var(--primary);
            pointer-events: none;
        }

        select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: white;
            appearance: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            color: var(--dark-wood);
            transition: var(--transition);
        }

        select:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(212, 167, 106, 0.2);
        }

        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .btn:hover {
            background: var(--dark-wood);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn i {
            margin-right: 8px;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary {
            background: rgba(139, 90, 43, 0.1);
            color: var(--primary);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 30px;
            margin-top: 60px;
            background: var(--primary);
            color: white;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .header-container {
                flex-direction: column;
                padding: 15px;
            }
            
            nav ul {
                margin-top: 15px;
                gap: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 120px;
            }
            
            .main-container {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                       <img src="log.png" alt="Artisanat Marocain">
         <div class="logo-text">
                    <h1><span class="first-letter">B</span>eldi</h1>
                    <p>Artisanat du Maroc</p>
                </div>
            </div>
            
            <nav>
                <ul>
                    <li><a href="h.php"><i class="fas fa-home"></i> Home</a></li>

                    <li><a href="das.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="pro.php"><i class="fas fa-box-open"></i> Produits</a></li>
                    <li><a href="pp.php"><i class="fas fa-credit-card"></i> Orders</a></li>
              
                    <li class="profile-dropdown">
                        <a href="#" class="header-icon"><i class="fas fa-user"></i></a>
                        <ul class="dropdown-menu">
                            <?php if ($user): ?>
                                <li><a href="cont.php">Mon profil</a></li>
                                <li><a href="logout.php">Déconnexion</a></li>
                            <?php else: ?>
                                <li><a href="login.php">Connexion</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>  </ul>
            </nav>
        </div>
    </header>
    
    <div class="main-container">
        <h1 class="page-title"><i class="fas fa-truck"></i> Gestion des Livraisons</h1>
        
        <div class="orders-table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Commande</th>
                        <th>ID Client</th>
                        <th>ID Produit</th>
                        <th>Quantité</th>
                        <th>Prix Total</th>
                        <th>Date</th>
                        <th>Livreur</th>
                        <th>Entreprise</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <form method="post" class="form-row">
                            <td><?= htmlspecialchars($order['id']) ?></td>
                            <td><?= htmlspecialchars($order['user_id']) ?></td>
                            <td><?= htmlspecialchars($order['product_id']) ?></td>
                            <td><?= htmlspecialchars($order['quantite']) ?></td>
                            <td><?= number_format($order['total'], 2, ',', ' ') ?> MAD</td>
                            <td><?= date('d/m/Y', strtotime($order['order_date'])) ?></td>
                            
                            <td>
                                <div class="select-wrapper">
                                    <select name="delivery_person_id">
                                        <option value="">-- Sélectionner --</option>
                                        <?php foreach ($deliveryPersons as $person): 
                                            $selected = ($order['delivery_person_id'] == $person['delivery_person_id']) ? 'selected' : '';
                                        ?>
                                            <option value="<?= $person['delivery_person_id'] ?>" <?= $selected ?>>
                                                <?= htmlspecialchars($person['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            
                            <td>
                                <div class="select-wrapper">
                                    <select name="delivery_company_id">
                                        <option value="">-- Sélectionner --</option>
                                        <?php foreach ($deliveryCompanies as $company): 
                                            $selected = ($order['delivery_company_id'] == $company['delivery_company_id']) ? 'selected' : '';
                                        ?>
                                            <option value="<?= $company['delivery_company_id'] ?>" <?= $selected ?>>
                                                <?= htmlspecialchars($company['company_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            
                            <td>
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <button type="submit" class="btn"><i class="fas fa-save"></i> Mettre à jour</button>
                          <a href="facture.php?order_id=<?= $order['id'] ?>" target="_blank" class="btn" style="background-color:#D4A76A; margin-top:10px;">
    <i class="fas fa-file-invoice" style="background-color: #8B5A2B;"></i> Afficher Facture
</a>
  </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <footer>
        <p>Artisanat Beldi &copy; <?= date('Y') ?> - Tous droits réservés</p>
    </footer>
</body>
</html>