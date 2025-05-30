<?php
// Configuration robuste de la session
ini_set('session.cookie_lifetime', 86400); // 1 jour
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// Vérifie si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur | Artisanat Marocain Beldi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --deep-blue: #1E3A8A;
            --terracotta: #E2725B;
            --ivory: #FFFFF0;
            --dark-wood: #5C4033;
            --light-gold: #F0E68C;
            --shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--ivory);
            color: var(--dark-wood);
            overflow-x: hidden;
        }

        .logo h1 {
            font-size: 28px;
            color: #9e7f70;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        .logo h1 .first-letter {
            color: rgb(125, 30, 30);
            font-size: 32px;
        }

        h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        /* Header */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: #c49a6f;
            position: fixed;
            width: 100%;
            z-index: 1000;
            border-bottom: 1px solid rgba(163, 145, 86, 0.39);
            margin-bottom: 50px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 15px 15px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            height: 50px;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.1));
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 27px;
            margin-left: 150px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--dark-wood);
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 1px;
            position: relative;
            padding: 5px 0;
            transition: var(--transition);
        }

        nav ul li a:hover {
            color: var(--gold);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .header-icon {
            color: var(--dark-wood);
            font-size: 18px;
            position: relative;
            transition: var(--transition);
        }

        .header-icon:hover {
            color: var(--gold);
            transform: translateY(-2px);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--terracotta);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        /* Profile Styles */
        .profile-hero {
            height: 50vh;
            min-height: 400px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('bb.jpg');
            background-size: cover;
            background-position: center;
            margin-bottom: 80px;
        }

        .profile-hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            color: white;
            width: 100%;
            text-align: center;
        }

        .profile-hero h2 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .profile-container {
            max-width: 1000px;
            margin: -100px auto 50px;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            position: relative;
            z-index: 2;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            margin-right: 30px;
            border: 3px solid white;
            box-shadow: var(--shadow);
        }

        .profile-info h1 {
            color: var(--dark-wood);
            margin: 0;
            font-size: 32px;
        }

        .profile-info p {
            color: #777;
            font-size: 16px;
        }

        .profile-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .detail-card {
            background: rgba(212, 175, 55, 0.05);
            padding: 25px;
            border-radius: 8px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            transition: var(--transition);
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .detail-card h3 {
            color: var(--dark-wood);
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .detail-card h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--gold);
        }

        .detail-row {
            display: flex;
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            width: 150px;
            color: var(--dark-wood);
        }

        .detail-value {
            color: #555;
        }

        .profile-photo-container {
            text-align: center;
            margin-top: 40px;
        }

        .profile-photo {
            max-width: 250px;
            border-radius: 8px;
            border: 3px solid var(--gold);
            box-shadow: var(--shadow);
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
            color: var(--gold);
            padding-left: 20px;
        }

        .profile-trigger {
            cursor: pointer;
        }

        /* Footer */
        footer {
            margin-top: 120px;
            background-color: #ad7b35ac;
            color: white;
            position: relative;
            padding-top: 100px;
        }

        .footer-wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="%23FFFFF0" opacity=".25"/><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="%23FFFFF0" opacity=".5"/><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23FFFFF0"/></svg>');
            background-size: cover;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            padding-bottom: 80px;
        }

        .footer-col h3 {
            font-size: 20px;
            margin-bottom: 25px;
            position: relative;
            color: #5C4033;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: #b67d57;
        }

        .footer-col p, .footer-col a {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 15px;
            line-height: 1.8;
            transition: var(--transition);
            text-decoration: none;
            display: block;
        }

        .footer-col a:hover {
            color: var(--ivory);
            padding-left: 5px;
        }

        .footer-contact i {
            color: #7b4830;
            margin-right: 10px;
            width: 20px;
        }

        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgb(154, 99, 52);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .footer-social a:hover {
            background-color: #bd985aac;
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding: 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .profile-hero {
                height: 40vh;
                min-height: 300px;
            }

            .profile-hero h2 {
                font-size: 36px;
            }

            .profile-container {
                padding: 30px 20px;
                margin-top: -80px;
            }
        }

        @media (max-width: 480px) {
            .profile-hero {
                height: 35vh;
                min-height: 250px;
            }

            .profile-hero h2 {
                font-size: 28px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="log.png" alt="Artisanat Marocain">
                <div class="logo">
                    <div>
                        <h1 style="font-size: 28px; color:#9e6d6d; font-family: 'Playfair Display', serif; font-weight: 700;">
                            <span class="first-letter">B</span>eldi
                        </h1>
                        <p>Artisanat du Maroc</p>
                    </div>
                </div>
            </div>
            
            <nav>
                <ul>
                    <li><a href="home.php">Accueil</a></li>
                    <li><a href="collecti.php">Collections</a></li>
                    <li><a href="#">Savoir-Faire</a></li>
                    <li><a href="#">Événements</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <div class="profile-dropdown">
                    <a href="#" class="header-icon profile-trigger">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="profile.php">Mon profil</a>
                        <a href="logout.php">Déconnexion</a>
                    </div>
                </div>
               
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="profile-hero">
        <div class="profile-hero-content">
            <h2>Votre Profil Beldi</h2>
            <p>Gérez vos informations personnelles et vos préférences</p>
        </div>
    </section>
    
    <!-- Profile Container -->
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php if (!empty($user['photo'])): ?>
                    <img src="uploads/profiles/<?= htmlspecialchars($user['photo']) ?>" alt="Photo de profil" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                <?php else: ?>
                    <?php
                    $initiales = strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1));
                    echo $initiales;
                    ?>
                <?php endif; ?>
            </div>
            
            <div class="profile-info">
                <h1><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h1>
                <p>Membre depuis <?= date('d/m/Y', strtotime($user['date_inscription'] ?? 'now')) ?></p>
            </div>
        </div>
        
        <div class="profile-details">
            <div class="detail-card">
                <h3>Informations personnelles</h3>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Téléphone:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['telephone'] ?? 'Non renseigné') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Âge:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['age']) ?> ans</span>
                </div>
            </div>
            
            <div class="detail-card">
                <h3>Adresse</h3>
                <div class="detail-row">
                    <span class="detail-label">Pays:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['pays']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ville:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['ville']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Code postal:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['code_postal']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Adresse:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['adresse']) ?></span>
                </div>
            </div>
        </div>
        
        <?php if (!empty($user['photo'])): ?>
        <div class="profile-photo-container">
            <img src="uploads/profiles/<?= htmlspecialchars($user['photo']) ?>" alt="Photo de profil" class="profile-photo">
        </div>
        <?php endif; ?>
    </div>
    <a href="edit_profile.php" class="edit-btn">✏️ Modifier mon profil</a>

<style>
.edit-btn {
    display: inline-block;
    margin: 20px 0;
    padding: 10px 20px;
    background-color: #9e6d6d;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}
.edit-btn:hover {
    background-color: #7e4f4f;
}
</style>
    <!-- Footer -->
        <footer>
        <div class="footer-wave"></div>
        <div class="footer-content ">
            <div class="footer-col">
                <h3>Beldi</h3>
                <p>Depuis 1987, nous mettons en valeur le savoir-faire artisanal marocain à travers des créations contemporaines qui honorent les traditions.</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Nos Collections</h3>
                <a href="collecti.php">Zellige Contemporain</a>
                <a href="collecti.php">Lignes Berbères</a>
                <a href="collecti.php">Luminaires Traditionnels</a>
                <a href="collecti.php">Céramique de Fès</a>
                <a href="collecti.php">Tapis du Haut Atlas</a>
                <a href="collecti.php">Marqueterie d'Essaouira</a>
            </div>
            
            <div class="footer-col">
                <h3>Informations</h3>
                <a href="savoir-faire.php">À propos de nous</a>
                <a href="#artisans">Nos artisans</a>
                <a href="evenements.php">Événements</a>
            </div>
            
            <div class="footer-col footer-contact">
                <h3>Contactez-nous</h3>
                <p><i class="fas fa-map-marker-alt"></i> Rue de la Kasbah, Marrakech 40000, Maroc</p>
                <p><i class="fas fa-phone"></i> +212 6 12 34 56 78</p>
                <p><i class="fas fa-envelope"></i> beldi@gmail.com</p>
                <p><i class="fas fa-clock"></i> Lun-Sam : 9h-19h</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 Beldi Artisanat d'Exception. Tous droits réservés.</p>
        </div>
    </footer>
    <script>
        // Animation pour le header au scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.1)';
            }
        });

        // Gestion du dropdown profile
        const profileTrigger = document.querySelector('.profile-trigger');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        profileTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            const isMobile = window.matchMedia("(max-width: 768px)").matches;
            
            if (isMobile) {
                const isOpen = dropdownMenu.style.opacity === '1';
                dropdownMenu.style.opacity = isOpen ? '0' : '1';
                dropdownMenu.style.visibility = isOpen ? 'hidden' : 'visible';
                dropdownMenu.style.transform = isOpen ? 'translateY(10px)' : 'translateY(0)';
            }
        });

        // Fermer le dropdown quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown')) {
                dropdownMenu.style.opacity = '0';
                dropdownMenu.style.visibility = 'hidden';
                dropdownMenu.style.transform = 'translateY(10px)';
            }
        });
    </script>
</body>
</html>