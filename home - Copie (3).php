<?php
// Début absolu du fichier - avant tout code HTML


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
]);session_start();

// Vérifie si l'utilisateur n'est pas connecté

// Vérifiez si l'utilisateur est connecté
$user = isset($_SESSION['user']) ? [
    'id' => $_SESSION['user']['id'],
    'email' => htmlspecialchars($_SESSION['user']['email']),
    'nom' => htmlspecialchars($_SESSION['user']['nom']),
    'prenom' => htmlspecialchars($_SESSION['user']['prenom']),
    'ville' => htmlspecialchars($_SESSION['user']['ville']),
    'age' => $_SESSION['user']['age']
] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisanat Marocain | Bijoux de l'Artisanat Traditionnel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37; /* Or marocain */
            --deep-blue: #1E3A8A; /* Bleu profond */
            --terracotta: #E2725B; /* Terre cuite */
            --ivory: #FFFFF0; /* Ivoire */
            --dark-wood: #5C4033; /* Bois foncé */
            --light-gold: #F0E68C; /* Or clair */
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
            color: rgb(125, 30, 30); /* Rouge foncé pour la première lettre */
            font-size: 32px; /* Légèrement plus grand pour l'effet */
        }

        h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        /* Header Luxe */
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

        /* Hero Section Luxe */
        .hero {
            height: 110vh;
            min-height: 800px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('bb.jpg');
            background-size: cover;
            z-index: -1;
        }

        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            color: white;
            width: 100%;
        }

        .hero-text {
            background-color: #c2996f72;
            max-width: 600px;
        }

        .hero h2 {
            font-size: 72px;
            line-height: 1.1;
            margin-bottom: 25px;
            text-shadow: 0 2px 10px rgb(152, 98, 50);
            text-decoration: underline;
        }

        .hero p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .btn {
            display: inline-block;
            padding: 18px 45px;
            background-color: #cc9748af;
            color: white;
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 1px;
            border-radius: 0;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 15px;
            text-transform: uppercase;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .scroll-down {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 24px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-20px) translateX(-50%);
            }
            60% {
                transform: translateY(-10px) translateX(-50%);
            }
        }

        /* Marquee Brands */
        .marquee {
            background-color: #cb000017;
            color: #92321e;
            padding: 20px 0;
            overflow: hidden;
        }

        .marquee-content {
            display: flex;
            animation: scroll 30s linear infinite;
        }

        .marquee-item {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            white-space: nowrap;
            margin: 0 40px;
            position: relative;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        /* Featured Collections */
        .section {
            padding: 100px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .section-header h2 {
            font-size: 42px;
            color: #5C4033;
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX (-50%);
            width: 80px;
            height: 3px;
            background: var(--gold);
        }

        .section-header p {
            max-width: 700px;
            margin: 0 auto;
            font-size: 18px;
            line-height: 1.8;
            color: var(--dark-wood);
        }

        .collections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .collection-card {
            position: relative;
            height: 500px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .collection-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .collection-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .collection-card:hover .collection-image {
            transform: scale(1.05);
        }

        .collection-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 30px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
            color: white;
        }

        .collection-overlay h3 {
            font-size: 28px;
            margin-bottom: 10px;
            transform: translateY(20px);
            opacity: 0;
            transition: var(--transition);
        }

        .collection-overlay p {
            font-size: 16px;
            margin-bottom: 20px;
            transform: translateY(20px);
            opacity: 0;
            transition: var(--transition);
            transition-delay: 0.1s;
        }

        .collection-card:hover .collection-overlay h3,
        .collection-card:hover .collection-overlay p {
            transform: translateY(0);
            opacity: 1;
        }

        /* Artisans Spotlight */
        .artisans {
            background: linear-gradient(
                135deg, 
                rgba(146, 49, 30, 0.366) 0%, 
                rgba(204, 119, 34, 0.301) 50%, 
                rgba(212, 175, 55, 0.236) 100%
            );
            color: white;
            position: relative;
            overflow: hidden;
        }

        .artisans::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('pp.jpg');
            opacity: 0.05;
            pointer-events: none;
        }

        .artisans .section-header h2 {
            color: rgba(128, 50, 50, 0.894);
        }

        .artisans .section-header h2::after {
            background: var(--terracotta);
        }

        .artisans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .artisan-card {
            background: white;
            color: var(--dark-wood);
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .artisan-card:hover {
            transform: translateY(-10px);
        }

        .artisan-image {
            width: 230px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--gold);
            margin: 0 auto 20px;
        }

        .artisan-card h3 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #7b4830;
        }

        .artisan-card p.specialty {
            color: var(--terracotta);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .artisan-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .artisan-social a {
            color: var(--deep-blue);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(212, 175, 55, 0.2);
            transition: var(--transition);
 }

        .artisan-social a:hover {
            background: var(--gold);
            color: white;
        }

        /* Featured Products */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--terracotta);
            color: white;
            padding: 5px 15px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            z-index: 2;
        }

        .product-image-container {
            height: 350px;
            overflow: hidden;
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-actions {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            color: var(--deep-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--gold);
            color: white;
        }

        .product-info {
            padding: 25px;
        }

        .product-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--deep-blue);
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .price {
            font-weight: 700;
            color: var(--gold);
            font-size: 20px;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 14px;
            margin-left: 5px;
        }

        .rating {
            color: var(--gold);
            font-size: 14px;
        }

        /* Call to Action */
        .cta {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://example.com/moroccan-market.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
            padding: 120px 40px;
            color: white;
        }

        .cta h2 {
            font-size: 48px;
            margin-bottom: 30px;
        }

        .cta p {
            max-width: 700px;
            margin: 0 auto 40px;
            font-size: 18px;
            line-height: 1.8;
        }

        /* Footer Luxe */
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
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34 , 53.67,583, 72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="%23FFFFF0" opacity=".25"/><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="%23FFFFF0" opacity=".5"/><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23FFFFF0"/></svg>');
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
        @media (max-width: 1024px) {
            .hero h2 {
                font-size: 56px;
            }

            .section {
                padding: 80px 30px;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                padding: 15px 20px;
            }

            nav {
                margin: 20px 0;
            }

            nav ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px 25px;
            }

            .header-actions {
                margin-top: 15px;
            }

            .hero {
                min-height: 700px;
            }

            .hero h2 {
                font-size: 42px;
            }

            .hero p {
                font-size: 16px;
            }

            .btn {
                padding: 15px 30px;
            }

            .section-header h2 {
                font-size: 36px;
            }
        }

        @media (max-width: 480px) {
            .hero h2 {
                font-size: 32px;
            }

            .hero-buttons {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .btn-outline {
                margin-left: 0;
            }

            .section {
                padding: 60px 20px;
            }

            .section-header h2 {
                font-size: 28px;
            }

            .collection-card {
                height: 400px;
            }
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            overflow: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #ddd;
            width: 80%;
            max-width: 700px;
            position: relative;
            animation: modalopen 0.5s;
        }

        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px)}
            to {opacity: 1; transform: translateY(0)}
        }

        .close-modal {
            position: absolute;
            right: 25px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close-modal:hover {
            color: var(--terracotta);
        }

        .form-container {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }

        .form-column {
            flex: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-wood);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
        }

        .form-group textarea {
            height: 80px;
            resize: vertical;
        }

        .form-group input[type="file"] {
            padding : 5px;
        }

        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
            }
            
            .modal-content {
                width: 90%;
                margin: 10% auto;
            }
        }
    </style>
</head>
<body>
    <!-- Header Luxe -->
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
                    <li><a href="savoir-faire.php">Savoir-Faire</a></li>
                    <li><a href="evenements.php">Événements</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            
          
    <div class="header-actions">
            <div class="profile-dropdown">
                <a href="#" class="header-icon">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu">
                    <?php if ($user): ?>
                        <a href="profile.php">Mon profil</a>
                        <a href="logout.php">Déconnexion</a>
                    <?php else: ?>
                        <a href="login.php">Connexion</a>
                        <a href="inscription.php">S'inscrire</a>
                    <?php endif; ?>
                </div>
            </div>
           
        </div>
    </div>
    </header>
    <!-- Hero Section Luxe -->
    <section class="hero">
        <video autoplay muted loop class="hero-video">
            <source src="moroccan-craft-video.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        
        <div class="hero-content">
            <div class="hero-text">
                <h2>L'Artisanat du Maroc Réinventé</h2>
                <p>Découvrez des pièces uniques où tradition ancestrale rencontre design contemporain. Chaque création raconte une histoire, portée par le savoir-faire de nos maîtres artisans.</p>
                <div class="hero-buttons">
                    <a href="collecti.php" class="btn">Explorer les Collections</a>
              <a href="#artisans" class="btn btn-outline">Rencontrer nos Artisans</a>
  </div>
            </div>
        </div>
        
        <div class="scroll-down">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>
    
    <!-- Marquee Brands -->
    <section class="marquee">
        <div class="marquee-content">
            <div class="marquee-item">Agadir</div>
            <div class="marquee-item">Marrakech</div>
            <div class="marquee-item">Safi</div>
            <div class="marquee-item">Tétouan</div>
            <div class="marquee-item">Rabat</div>
            <div class="marquee-item">Essaouira</div>
            <div class="marquee-item">Meknès</div>
            <div class="marquee-item">Chefchaouen</div>
        </div>
    </section>
    
    <!-- Featured Collections -->
    <section class="section">
        <div class="section-header">
            <h2>Nos Collections Signature</h2>
            <p>Des pièces exclusives créées en collaboration avec les plus talentueux artisans du Maroc, alliant tradition et modernité.</p>
        </div>
        
        <div class="collections-grid">
            <div class="collection-card">
                <img src="zz.jpg" alt="Collection Zellige" class="collection-image">
                <div class="collection-overlay">
                    <h3>Zellige Contemporain</h3>
                    <p>Une réinterprétation moderne des motifs traditionnels</p>
                    <a href="collecti.php" class="btn">Découvrir</a>
                </div>
            </div>
            
            <div class="collection-card">
                <img src="ll.jpg" alt="Collection Berbère" class="collection-image">
                <div class="collection-overlay">
                    <h3>Lignes Berbères</h3>
                    <p>Symboles ancestraux tissés avec des matériaux nobles</p>
                    < <a href="collecti.php" class="btn">Découvrir</a>
                </div>
            </div>
            
            <div class="collection-card">
                <img src="lu.jpg" alt="Collection Lumière" class="collection-image">
                <div class="collection-overlay">
                    <h3>Lumières du Sud</h3>
                    <p>Luminaires sculptés dans le laiton et le cuivre</p>
                    <a href="collecti.php" class="btn">Découvrir</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Artisans Spotlight -->
<section class="section artisans" id="artisans">
<div class="section-header">
            <h2>Rencontrez nos Artisans</h2>
            <p>Derrière chaque pièce se cache une personne, une histoire et un savoir-faire transmis de génération en génération.</p>
        </div>
        
        <div class="artisans-grid">
            <div class="artisan-card">
                <img src="h.jpg" alt="Mohammed" class="artisan-image">
                <h3>Mohammed Alami</h3>
                <p class="specialty">Maître Zelligeur</p>
                <p>35 ans d'expérience dans la création de motifs géométriques complexes selon les règles ancestrales.</p>
                <div class="artisan-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            
            <div class="artisan-card">
                <img src="ff.jpg" alt="Fatima" class="artisan-image">
                <h3>Fatima Zahra</h3>
                <p class="specialty">Tisseuse de Tapis</p>
                <p>Spécialiste des motifs berbères du Haut Atlas, utilisant uniquement des colorants naturels.</p>
                <div class="artisan-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="artisan-card">
                <img src="fff.jpg" alt="Hassan" class="artisan-image">
                <h3>Hassan Benbrahim</h3>
                <p class="specialty">Forgeron sur Cuivre</p>
                <p>Crée des luminaires et objets décoratifs selon les techniques traditionnelles de martelage.</p>
                <div class="artisan-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="artisan-card">
                <img src="cc.jpg" alt="Amina" class="artisan-image">
                <h3>Amina Toufiq</h3>
                <p class="specialty">Céramiste</p>
                <p>Perpétue l'art de la céramique bleue de Fès avec des touches contemporaines.</p>
                <div class="artisan-social">
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Products -->
    <section class="section">
        <div class="section-header">
            <h2>Nos Pièces d'Exception</h2>
            <p>Des créations uniques et limitées, sélectionnées pour leur qualité artisanale et leur design remarquable.</p>
        </div>
        
        <div class="products-grid">
            <div class="product-card">
                <span class="product-badge">Nouveauté</span>
                <div class="product-image-container">
                    <img src="vv.jpg" alt="Vase en Zellige" class="product-image">
                    <div class="product-actions">
                       
                    </div>
                </div>
                <div class="product-info">
                    <h3>Vase en Zellige "Étoile de Fès"</h3>
                    <div class="product-meta">
                        <div class="price">1 450 MAD</div>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image-container">
                    <img src="bbb.jpg" alt="Tapis Berbère" class="product-image">
                    <div class="product-actions">
                        
                    </div>
                </div>
                <div class="product-info">
                    <h3>Tapis Berbère "Lignes du désert"</h3>
                    <div class="product-meta">
                        <div class="price">3 200 MAD <span class="old-price">3 800 MAD</span></div>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <span class="product-badge">Édition Limitée</span>
                <div class="product-image-container">
                    <img src="pp.jpg" alt="Plateau Marqueterie" class="product-image">
                    <div class="product-actions">
                     
                    </div>
                </div>
                <div class="product-info">
                    <h3>Plateau Marqueterie "Arabesque"</h3>
                    <div class="product-meta">
                        <div class="price">2 150 MAD</div>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image-container">
                    <img src="luu.jpg" alt="Luminaire Cuivre" class="product-image">
                    <div class="product-actions">
                     
                    </div>
                </div>
                <div class="product-info">
                    <h3>Luminaire en Cuivre "Lune du Sud"</h3>
                    <div class="product-meta">
                        <div class="price">1 890 MAD</div>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 50px;">
            <a href="collecti.php" class="btn">Voir Toutes Nos Créations</a>
        </div>
    </section>
    
  <section class="cta">
    <h2>L'Artisanat au Service de Votre Intérieur</h2>
    <p>Chaque pièce que nous créons est conçue pour apporter une touche d'authenticité et de chaleur à votre espace de vie. Découvrez comment intégrer ces œuvres uniques dans votre décoration.</p>
    <button id="consultationBtn" class="btn">Demander une Consultation</button>
    
    <!-- Formulaire caché initialement -->
    <div id="consultationForm" style="display: none; margin-top: 20px;">
        <form id="contactForm">
            <div class="form-group">
                <label for="name">Nom complet*</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="message">Votre demande*</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn">Envoyer la demande</button>
        </form>
    </div>
</section>

<!-- Modale de confirmation -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div class="modal-icon">✓</div>
        <h3>Demande envoyée avec succès !</h3>
        <p>Nous avons bien reçu votre demande de consultation et vous contacterons rapidement.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
<script>
    // Initialisation d'EmailJS avec vos identifiants
    (function() {
        emailjs.init("7zbC33g0M8dUwKkr6"); // Votre clé publique
    })();
    
    // Elements modale
    const modal = document.getElementById("successModal");
    const closeModal = document.getElementsByClassName("close-modal")[0];
    const modalBtn = document.getElementsByClassName("modal-btn")[0];
    
    // Afficher/masquer le formulaire
    document.getElementById('consultationBtn').addEventListener('click', function() {
        const form = document.getElementById('consultationForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
    
    // Gestion de l'envoi du formulaire
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Ajout de la date automatiquement
        const now = new Date();
        this.date = now.toLocaleString('fr-FR');
        
        emailjs.sendForm('service_56b9pls', 'template_b1uxevp', this)
            .then(function() {
                // Succès : afficher la modale
                modal.style.display = "block";
                // Réinitialiser le formulaire
                document.getElementById('contactForm').reset();
                // Masquer le formulaire
                document.getElementById('consultationForm').style.display = 'none';
            }, function(error) {
                alert('Une erreur est survenue : ' + JSON.stringify(error));
            });
    });
    
    // Fermer la modale
    closeModal.onclick = function() {
        modal.style.display = "none";
    }
    
    modalBtn.onclick = function() {
        modal.style.display = "none";
    }
    
    // Fermer si clic en dehors de la modale
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<style>
    /* Styles de base */
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: inherit;
    }
    
    textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .btn {
        background-color:rgb(127, 93, 31);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    
    .btn:hover {
        background-color:rgb(193, 143, 67);
    }
    
    #consultationForm {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    /* Styles de la modale */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }
    
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        position: relative;
    }
    
    .modal-icon {
        width: 80px;
        height: 80px;
        background-color:rgb(146, 107, 71);
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 40px;
        font-weight: bold;
    }
    
    .close-modal {
        position: absolute;
        right: 20px;
        top: 15px;
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close-modal:hover {
        color: #333;
    }
    
    .modal-btn {
        margin-top: 20px;
        background-color:rgb(219, 146, 94);
    }
    
    .modal-btn:hover {
        background-color:rgb(209, 175, 106);
    }
    
    @keyframes fadeIn {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    
    @media screen and (max-width: 600px) {
        .modal-content {
            margin: 20% auto;
            width: 85%;
        }
    }
</style>
    <!-- Formulaire caché initialement -->


<!-- Ajoutez ces scripts avant la fermeture du body -->

    
    <!-- Footer Luxe -->
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
        
        // Animation fluide pour les liens
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Chargement des images avec lazy loading
        document.addEventListener('DOMContentLoaded', function() {
            const lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));
            
            if ('IntersectionObserver' in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = entry.target;
                            lazyImage.src = lazyImage.dataset.src;
                            lazyImage.classList.remove('lazy');
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });
                
                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
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