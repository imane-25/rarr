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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin | Beldi Artisanat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
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
            margin: 10px;
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
        .admin-home {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 30px;
            min-height: calc(100vh - 200px);
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 60px;
        }

        .welcome-section h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .welcome-section h1::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--secondary);
        }

        .welcome-section p {
            font-size: 1.1rem;
            color: var(--dark-wood);
            max-width: 700px;
            margin: 0 auto 30px;
            line-height: 1.8;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .action-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(139, 90, 43, 0.1);
            text-align: center;
            cursor: pointer;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-color: var(--secondary);
        }

        .action-icon {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .action-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .action-card p {
            color: var(--dark-wood);
            opacity: 0.8;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 30px;
            background: var(--primary);
            color: white;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
            display: inline-block;
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
            overflow: hidden;
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
            color: var(--secondary);
            padding-left: 20px;
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
            
            .welcome-section h1 {
                font-size: 2.2rem;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
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
                                <a href="cont.php">Mon profil</a>
                                <a href="logout.php">Déconnexion</a>
                            <?php else: ?>
                                <a href="login.php">Connexion</a>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="admin-home">
        <section class="welcome-section">
            <h1>Bienvenue, <?php echo $user ? htmlspecialchars($user['prenom']) : 'Administrateur'; ?></h1>
            <p>Gérez facilement votre boutique d'artisanat marocain depuis cette interface intuitive.</p>
        </section>

        <div class="quick-actions">
            <div class="action-card" onclick="window.location.href='pro.php'">
                <div class="action-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>Gérer les Produits</h3>
                <p>Ajoutez, modifiez ou supprimez des produits de votre catalogue</p>
            </div>

            <div class="action-card" onclick="window.location.href='pp.php'">
                <div class="action-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Commandes</h3>
                <p>Suivez et gérez les commandes de vos clients</p>
            </div>

            <div class="action-card" onclick="window.location.href='liste_utilisateurs.php'">
                <div class="action-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Clients</h3>
                <p>Consultez et gérez les comptes clients</p>
            </div>

            <div class="action-card" onclick="window.location.href='das.php'">
                <div class="action-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Statistiques</h3>
                <p>Analysez les performances de votre boutique</p>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Beldi Artisanat. Tous droits réservés.</p>
    </footer>
</body>
</html>