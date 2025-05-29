<?php
// stats.php

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "artisanat_beldi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Nombre total d'utilisateurs
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM utilisateurs");
    $totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Nombre d'utilisateurs par pays
    $stmt = $pdo->query("SELECT pays, COUNT(*) AS total FROM utilisateurs GROUP BY pays");
    $usersByCountry = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Moyenne d'âge
    $stmt = $pdo->query("SELECT AVG(age) AS moyenne_age FROM utilisateurs");
    $averageAge = round($stmt->fetch(PDO::FETCH_ASSOC)['moyenne_age'], 1);

    // Statistiques des ventes
    $stmt = $pdo->query("SELECT COUNT(*) AS total_commandes FROM order_details");
    $totalCommandes = $stmt->fetch(PDO::FETCH_ASSOC)['total_commandes'];

    $stmt = $pdo->query("SELECT SUM(quantity) AS total_quantite FROM order_details");
    $totalQuantite = $stmt->fetch(PDO::FETCH_ASSOC)['total_quantite'];

    $stmt = $pdo->query("SELECT SUM(total_price) AS chiffre_affaires FROM order_details");
    $chiffreAffaires = $stmt->fetch(PDO::FETCH_ASSOC)['chiffre_affaires'];

} catch (PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Tableau de Bord | Artisanat Beldi</title>
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

        /* Main Content Styles */
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 40px;
            position: relative;
            text-align: center;
        }

        h1::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--secondary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(139, 90, 43, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--secondary);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .stat-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-value {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--primary);
            margin: 20px 0 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-value i {
            color: var(--secondary);
            font-size: 2.2rem;
        }

        .stat-card p {
            color: var(--dark-wood);
            opacity: 0.8;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .country-list {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
            max-height: 200px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .country-list::-webkit-scrollbar {
            width: 5px;
        }

        .country-list::-webkit-scrollbar-thumb {
            background: var(--secondary);
            border-radius: 10px;
        }

        .country-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed rgba(139, 90, 43, 0.2);
        }

        .country-item:last-child {
            border-bottom: none;
        }

        .country-name {
            font-weight: 600;
            color: var(--dark-wood);
        }

        .country-count {
            background: var(--secondary);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            min-width: 40px;
            text-align: center;
        }

        .revenue {
            color: #27ae60;
            font-weight: 700;
        }

        /* Footer Styles */
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
        @media (max-width: 768px) {
            body {
                padding-top: 80px;
            }
            
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
            
            .dashboard-container {
                padding: 20px 15px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .stat-value {
                font-size: 2.2rem;
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
                <ul>                    <li><a href="h.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>

                    <li><a href="das.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="pro.php"><i class="fas fa-box-open"></i> Produits</a></li>
                    <li><a href="pp.php"><i class="fas fa-credit-card"></i> Paiements</a></li>
                    <li><a href="cont.php"><i class="fas fa-envelope"></i> Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="dashboard-container">
        <h1><i class="fas fa-chart-pie"></i> Tableau de Bord</h1>
        
        <div class="stats-grid">
            <!-- Statistiques utilisateurs -->
            <div class="stat-card">
                <h2><i class="fas fa-users"></i> Utilisateurs</h2>
                <div class="stat-value">
                    <?php echo $totalUsers; ?>
                </div>
                <p>Nombre total de clients inscrits sur notre plateforme</p>
            </div>
            
            <div class="stat-card">
                <h2><i class="fas fa-globe-africa"></i> Répartition par Pays</h2>
                <ul class="country-list">
                    <?php foreach ($usersByCountry as $country): ?>
                        <li class="country-item">
                            <span class="country-name"><?php echo htmlspecialchars($country['pays']); ?></span>
                            <span class="country-count"><?php echo $country['total']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="stat-card">
                <h2><i class="fas fa-user-clock"></i> Âge Moyen</h2>
                <div class="stat-value">
                    <?php echo $averageAge; ?> ans
                </div>
                <p>Âge moyen de notre communauté d'acheteurs</p>
            </div>

            <!-- Statistiques ventes -->
            <div class="stat-card">
                <h2><i class="fas fa-shopping-bag"></i> Commandes</h2>
                <div class="stat-value">
                    <?php echo $totalCommandes; ?>
                </div>
                <p>Nombre total de commandes passées</p>
            </div>

            <div class="stat-card">
                <h2><i class="fas fa-boxes"></i> Articles Vendus</h2>
                <div class="stat-value">
                    <?php echo $totalQuantite; ?>
                </div>
                <p>Quantité totale d'articles vendus</p>
            </div>

            <div class="stat-card">
                <h2><i class="fas fa-coins"></i> Chiffre d'Affaires</h2>
                <div class="stat-value revenue">
                    <?php echo number_format($chiffreAffaires, 2, ',', ' '); ?> MAD
                </div>
                <p>Revenu total généré par les ventes</p>
            </div>
        </div>
    </div>
    
    <footer>
        <p>Artisanat Beldi &copy; <?php echo date('Y'); ?> - Tous droits réservés</p>
    </footer>
</body>
</html>