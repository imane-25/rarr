<?php
// Début absolu du fichier - avant tout code HTML
session_start();

// Vérifie si l'utilisateur n'est pas connecté
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
    <title>Collections | Artisanat Marocain Beldi</title>
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
        }   .dropdown-menu {
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
        
        h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        /* Header */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
            position: fixed;
            width: 100%;
            z-index: 1000;
            border-bottom: 1px solid rgba(163, 145, 86, 0.39);
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
        
        .logo-text {
            display: flex;
            flex-direction: column;
        }
        
        .logo h1 {
            font-size: 28px;
            color: #9e7f70;
            line-height: 1;
            letter-spacing: 1px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        .logo h1 .first-letter {
            color: rgb(125, 30, 30);
            font-size: 32px;
        }
        
        .logo p {
            font-size: 12px;
            color: var(--gold);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 3px;
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
        
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: var(--transition);
        }
        
        nav ul li a:hover {
            color: var(--gold);
        }
        
        nav ul li a:hover::after {
            width: 100%;
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
            display: none;
        }
        
        /* Hero Collection */
        .collection-hero {
            height: 60vh;
            min-height: 500px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://example.com/moroccan-craft-banner.jpg');
            background-size: cover;
            background-position: center;
            margin-bottom: 80px;
        }
        
        .collection-hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            color: white;
            width: 100%;
            text-align: center;
        }
        
        .collection-hero h1 {
            font-size: 72px;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .collection-hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        /* Collection Navigation */
        .collection-nav {
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 80px;
            z-index: 900;
            margin-bottom: 50px;
        }
        
        .collection-nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }
        
        .collection-nav-list {
            display: flex;
            list-style: none;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .collection-nav-item {
            position: relative;
        }
        
        .collection-nav-item a {
            display: block;
            padding: 25px 30px;
            text-decoration: none;
            color: var(--dark-wood);
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
        }
        
        .collection-nav-item a:hover,
        .collection-nav-item a.active {
            color: var(--gold);
        }
        
        .collection-nav-item a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 3px;
            background: var(--gold);
        }
        
        /* Collection Grid */
        .collection-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px 100px;
        }
        
        .collection-filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .filter-label {
            font-weight: 600;
            font-size: 14px;
            color: var(--dark-wood);
        }
        
        .filter-select {
            padding: 12px 20px;
            border: 1px solid #ddd;
            background: white;
            color: var(--dark-wood);
            font-family: 'Montserrat', sans-serif;
            min-width: 200px;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: var(--gold);
        }
        
        .collection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 40px;
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
            text-align: center;
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
        
        /* Modal Styles */
        .product-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            overflow: auto;
        }
        
        .modal-content {
            background-color: var(--ivory);
            margin: 5% auto;
            padding: 40px;
            width: 80%;
            max-width: 1000px;
            position: relative;
            border-radius: 5px;
            box-shadow: var(--shadow);
        }
        
        .close-modal {
            position: absolute;
            right: 25px;
            top: 25px;
            font-size: 28px;
            font-weight: bold;
            color: var(--dark-wood);
            cursor: pointer;
        }
        
        .modal-product-container {
            display: flex;
            gap: 40px;
        }
        
        .modal-product-images {
            flex: 1;
        }
        
        .modal-product-images img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: contain;
        }
        
        .modal-product-info {
            flex: 1;
        }
        
        .modal-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .add-to-cart, .add-to-wishlist {
            padding: 15px 30px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .add-to-cart {
            background-color: var(--gold);
            color: white;
        }
        
        .add-to-wishlist {
            background-color: white;
            color: var(--dark-wood);
            border: 1px solid var(--dark-wood);
        }
        
        .add-to-cart:hover {
            background-color: var(--dark-wood);
        }
        
        .add-to-wishlist:hover {
            background-color: var(--gold);
            color: white;
            border-color: var(--gold);
        }
        
        .add-to-wishlist.in-wishlist {
            background-color: var(--gold);
            color: white;
            border-color: var(--gold);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 70px;
        }
        
        .pagination-list {
            display: flex;
            list-style: none;
            gap: 10px;
        }
        
        .pagination-item a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-decoration: none;
            color: var(--dark-wood);
            font-weight: 600;
            transition: var(--transition);
        }
        
        .pagination-item a:hover,
        .pagination-item a.active {
            background: var(--gold);
            color: white;
        }
        
        /* Footer */
        footer {
            margin-top: 120px;
            background-color: var(--dark-wood);
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
            color: white;
        }
        
        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--gold);
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
            color: var(--gold);
            padding-left: 5px;
        }
        
        .footer-contact i {
            color: var(--gold);
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
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        
        .footer-social a:hover {
            background-color: var(--gold);
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
            .collection-hero h1 {
                font-size: 56px;
            }
            
            .collection-nav-item a {
                padding: 20px 15px;
            }
            
            .modal-product-container {
                flex-direction: column;
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
                margin-left: 0;
            }
            
            .header-actions {
                margin-top: 15px;
            }
            
            .collection-hero {
                min-height: 400px;
            }
            
            .collection-hero h1 {
                font-size: 42px;
            }
            
            .collection-hero p {
                font-size: 16px;
            }
            
            .collection-filters {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        
        @media (max-width: 480px) {
            .collection-hero h1 {
                font-size: 32px;
            }
            
            .collection-nav-list {
                flex-wrap: wrap;
            }
            
            .collection-nav-item {
                flex: 1 0 50%;
                text-align: center;
            }
            
            .collection-nav-item a {
                padding: 15px 10px;
                font-size: 14px;
            }
            
            .collection-grid {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                width: 95%;
                padding: 20px;
            }
        }/* Login Modal Styles */
.login-modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.8);
    overflow: auto;
}

.login-modal-content {
    background-color: var(--ivory);
    margin: 5% auto;
    padding: 40px;
    width: 90%;
    max-width: 500px;
    position: relative;
    border-radius: 5px;
    box-shadow: var(--shadow);
}

.close-login-modal {
    position: absolute;
    right: 25px;
    top: 25px;
    font-size: 28px;
    font-weight: bold;
    color: var(--dark-wood);
    cursor: pointer;
}

.login-iframe {
    width: 100%;
    height: 500px;
    border: none;
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
                    <li><a href="home.php">Accueil</a></li>
                    <li><a href="collection.php" class="active">Collections</a></li>
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
                        <a href="wishlist.php">Mes favoris</a>

                    <?php else: ?>
                        <a href="login.php">Connexion</a>
                        <a href="inscription.php">S'inscrire</a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="order.php" class="header-icon">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-count"><?= $user ? '3' : '0' ?></span>
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="collection-hero">
        <div class="collection-hero-content">
            <h1>Nos Collections d'Exception</h1>
            <p>Découvrez des pièces uniques créées par les maîtres artisans marocains, où tradition et modernité se rencontrent.</p>
        </div>
    </section>

    <!-- Navigation Collections -->
    <div class="collection-nav">
        <div class="collection-nav-container">
            <ul class="collection-nav-list">
                <li class="collection-nav-item"><a href="#" class="active" data-category="all">Toutes</a></li>
                <li class="collection-nav-item"><a href="#" data-category="zellige & céramique">Zellige & Céramique</a></li>
                <li class="collection-nav-item"><a href="#" data-category="tapis berbères">Tapis Berbères</a></li>
                <li class="collection-nav-item"><a href="#" data-category="luminaires">Luminaires</a></li>
                <li class="collection-nav-item"><a href="#" data-category="marqueterie">Marqueterie</a></li>
                <li class="collection-nav-item"><a href="#" data-category="bijoux">Bijoux</a></li>
                <li class="collection-nav-item"><a href="#" data-category="textiles">Textiles</a></li>
            </ul>
        </div>
    </div>

    <!-- Filtres -->
    <main class="collection-main">
        <div class="collection-filters">
            <div class="filter-group">
                <span class="filter-label">Trier par :</span>
                <select class="filter-select" id="sortSelect">
                    <option value="newest">Nouveautés</option>
                    <option value="price-asc">Prix (croissant)</option>
                    <option value="price-desc">Prix (décroissant)</option>
                    <option value="popular">Plus populaires</option>
                </select>
            </div>
        </div>

        <!-- Grille produits -->
        <div class="collection-grid" id="productGrid">
            <!-- Les produits seront générés dynamiquement par JavaScript -->
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <ul class="pagination-list">
                <li class="pagination-item"><a href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="pagination-item"><a href="#" class="active">1</a></li>
                <li class="pagination-item"><a href="#">2</a></li>
                <li class="pagination-item"><a href="#">3</a></li>
                <li class="pagination-item"><a href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>
    </main>

    <!-- Product Modal -->
    <div class="product-modal" id="productModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-product-container">
                <div class="modal-product-images">
                    <img src="" alt="" id="modalMainImage">
                </div>
                <div class="modal-product-info">
                    <h2 id="modalProductTitle"></h2>
                    <div class="modal-price" id="modalProductPrice"></div>
                    <div class="modal-rating" id="modalProductRating"></div>
                    <p id="modalProductDescription"></p>
                    <div class="modal-actions">
                        <button class="add-to-cart" id="modalAddToCart">Ajouter au panier</button>
                        <button class="add-to-wishlist" id="modalAddToWishlist"><i class="far fa-heart"></i> Favoris</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-wave"></div>
        <div class="footer-content">
            <div class="footer-col">
                <h3>Beldi Artisanat</h3>
                <p>Depuis 1985, nous préservons et promouvons l'artisanat marocain traditionnel à travers des pièces uniques et authentiques.</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Liens utiles</h3>
                <a href="#">Notre histoire</a>
                <a href="#">Artisans partenaires</a>
                <a href="#">Processus de fabrication</a>
                <a href="#">Expositions</a>
                <a href="#">Blog</a>
            </div>
            <div class="footer-col">
                <h3>Service client</h3>
                <a href="#">FAQ</a>
                <a href="#">Livraison & retours</a>
                <a href="#">Paiement sécurisé</a>
                <a href="#">Guide des tailles</a>
                <a href="#">Contactez-nous</a>
            </div>
            <div class="footer-col footer-contact">
                <h3>Contact</h3>
                <p><i class="fas fa-map-marker-alt"></i> Rue des Artisans, Marrakech 40000, Maroc</p>
                <p><i class="fas fa-phone"></i> +212 6 12 34 56 78</p>
                <p><i class="fas fa-envelope"></i> contact@beldi-artisanat.com</p>
                <p><i class="fas fa-clock"></i> Lun-Sam : 9h-19h</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 Beldi Artisanat Marocain. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
const isUserLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false'; ?>;

    document.addEventListener('DOMContentLoaded', () => {
        // Données des produits
        const products = [
            {
                id: 1,
                title: "Vase en Zellige 'Étoile de Fès'",
                price: 1450,
                oldPrice: null,
                rating: 4.5,
                category: "zellige & céramique",
                region: "fes",
                image: "vv.jpg",
                badge: "Nouveauté",
                description: "Magnifique vase en zellige traditionnel de Fès, fabriqué à la main par nos maîtres artisans. Chaque pièce est unique avec ses motifs géométriques complexes et ses couleurs vibrantes."
            },
            {
                id: 2,
                title: "Tapis Berbère 'Lignes du désert'",
                price: 3200,
                oldPrice: 3800,
                rating: 4.0,
                category: "tapis berbères",
                region: "sahara",
                image: "bbb.jpg",
                badge: null,
                description: "Tapis berbère authentique tissé à la main par les femmes du Sahara. Laine naturelle teintée avec des pigments végétaux. Dimensions : 200x140 cm."
            },
            {
                id: 3,
                title: "Plateau Marqueterie 'Arabesque'",
                price: 2150,
                oldPrice: null,
                rating: 5.0,
                category: "marqueterie",
                region: "essaouira",
                image: "pp.jpg",
                badge: "Édition Limitée",
                description: "Plateau en marqueterie de thuya réalisé par des artisans d'Essaouira. Motifs arabesques traditionnels avec incrustations de nacre."
            },
            {
                id: 4,
                title: "Luminaire en Cuivre 'Lune du Sud'",
                price: 1890,
                oldPrice: null,
                rating: 4.0,
                category: "luminaires",
                region: "marrakech",
                image: "luu.jpg",
                badge: null,
                description: "Luminaire artisanal en cuivre martelé, inspiré des lanternes traditionnelles des riads marocains. Diamètre : 45 cm."
            },
            {
                id: 5,
                title: "Collier Berbère en Argent",
                price: 850,
                oldPrice: null,
                rating: 4.0,
                category: "bijoux",
                region: "atlas",
                image: "co.jpg",
                badge: null,
                description: "Collier berbère en argent 925, orné de motifs traditionnels et de pierres semi-précieuses. Longueur : 50 cm."
            },
            {
                id: 6,
                title: "Set de 2 Coussins Brodés",
                price: 690,
                oldPrice: null,
                rating: 3.0,
                category: "textiles",
                region: "atlas",
                image: "ci.jpg",
                badge: null,
                description: "Set de deux coussins en coton brodé à la main par des artisanes de l'Atlas. Dimensions : 40x40 cm."
            },
            {
                id: 7,
                title: "Pot en Céramique Bleue de Fès",
                price: 1250,
                oldPrice: null,
                rating: 4.5,
                category: "zellige & céramique",
                region: "fes",
                image: "poti.jpg",
                badge: "Meilleure Vente",
                description: "Pot en céramique émaillée bleue typique de Fès, décoré à la main avec des motifs traditionnels. Hauteur : 35 cm."
            },
            {
                id: 8,
                title: "Tasse en Zellige de Fès",
                price: 320,
                oldPrice: null,
                rating: 4.2,
                category: "zellige & céramique",
                region: "fes",
                image: "tasse.jpg",
                badge: null,
                description: "Tasse artisanale décorée avec des carreaux de zellige typiques de Fès. Idéale pour le café ou le thé marocain."
            },
            {
                id: 9,
                title: "Tapis Taznakht en Laine Naturelle",
                price: 3400,
                oldPrice: 3900,
                rating: 4.4,
                category: "tapis berbères",
                region: "sud marocain",
                image: "taznakht.jpg",
                badge: "Édition Limitée",
                description: "Tapis traditionnel Taznakht tissé à la main avec laine naturelle. Motifs berbères complexes et couleurs chaleureuses. 220x150 cm."
            },
            {
                id: 10,
                title: "Coffret en Marqueterie de Thuya",
                price: 990,
                oldPrice: null,
                rating: 4.7,
                category: "marqueterie",
                region: "essaouira",
                image: "coffret.jpg",
                badge: null,
                description: "Coffret raffiné en bois de thuya avec incrustations géométriques en citronnier et nacre. Parfait pour bijoux ou souvenirs."
            },
            {
                id: 11,
                title: "Suspension en Laiton 'Éclat du Désert'",
                price: 2050,
                oldPrice: 2400,
                rating: 4.5,
                category: "luminaires",
                region: "marrakech",
                image: "suspension.jpg",
                badge: "Nouveauté",
                description: "Suspension artisanale en laiton ciselé, inspirée des formes lunaires marocaines. Diamètre : 50 cm. Fait main à Marrakech."
            },
            {
                id: 12,
                title: "Bracelet Berbère en Argent Gravé",
                price: 670,
                oldPrice: null,
                rating: 4.3,
                category: "bijoux",
                region: "atlas",
                image: "bracelet.jpg",
                badge: null,
                description: "Bracelet ouvert en argent massif 925 gravé de motifs berbères ancestraux. Artisanat de l'Atlas central."
            }
        ];
    });
        // Variables globales
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let currentCategory = "all";
        let currentSort = "newest";
        
        // Éléments DOM
        const productGrid = document.getElementById('productGrid');
        const modal = document.getElementById('productModal');
        const modalTitle = document.getElementById('modalProductTitle');
        const modalPrice = document.getElementById('modalProductPrice');
        const modalRating = document.getElementById('modalProductRating');
        const modalMainImage = document.getElementById('modalMainImage');
        const modalDescription = document.getElementById('modalProductDescription');
        const modalAddToCart = document.getElementById('modalAddToCart');
        const modalAddToWishlist = document.getElementById('modalAddToWishlist');
        const closeModal = document.querySelector('.close-modal');
        const sortSelect = document.getElementById('sortSelect');
        const categoryLinks = document.querySelectorAll('.collection-nav-item a');
        
        // Initialisation
        renderProducts();
        updateCartCount();
        
        // Fonction pour afficher les produits
        function renderProducts() {
            let filteredProducts = [...products];
            
            // Filtrage par catégorie
            if (currentCategory !== "all") {
                filteredProducts = filteredProducts.filter(
                    product => product.category === currentCategory
                );
            }
            
            // Tri
            switch (currentSort) {
                case "price-asc":
                    filteredProducts.sort((a, b) => a.price - b.price);
                    break;
                case "price-desc":
                    filteredProducts.sort((a, b) => b.price - a.price);
                    break;
                case "popular":
                    filteredProducts.sort((a, b) => b.rating - a.rating);
                    break;
                default: // "newest"
                    filteredProducts.sort((a, b) => b.id - a.id);
            }
            
            // Génération du HTML
            productGrid.innerHTML = filteredProducts.map(product => `
                <div class="product-card" data-id="${product.id}">
                    ${product.badge ? `<span class="product-badge">${product.badge}</span>` : ''}
                    <div class="product-image-container">
                        <img src="${product.image}" alt="${product.title}" class="product-image">
                        <div class="product-actions">
                            <a href="#" class="action-btn view-btn" data-id="${product.id}"><i class="fas fa-eye"></i></a>
                            <a href="#" class="action-btn like-btn" data-id="${product.id}">
                                <i class="${wishlist.some(item => item.id === product.id) ? 'fas' : 'far'} fa-heart"></i>
                            </a>
                            <a href="#" class="action-btn cart-btn" data-id="${product.id}">
                                <i class="fas fa-shopping-bag"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>${product.title}</h3>
                        <div class="product-meta">
                            <div class="price">
                                ${product.price} DH
                                ${product.oldPrice ? `<span class="old-price">${product.oldPrice} DH</span>` : ''}
                            </div>
                            <div class="rating">
                                ${'<i class="fas fa-star"></i>'.repeat(Math.floor(product.rating))}
                                ${product.rating % 1 ? '<i class="fas fa-star-half-alt"></i>' : ''}
                                ${'<i class="far fa-star"></i>'.repeat(5 - Math.ceil(product.rating))}
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
            
            // Ajout des écouteurs d'événements pour les nouveaux produits
            addProductEventListeners();
        }
        
        // Fonction pour ajouter les écouteurs d'événements aux produits
        function addProductEventListeners() {
            // Bouton "Voir"
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = parseInt(this.getAttribute('data-id'));
                    showProductModal(productId);
                });
            });
            
            // Bouton "Favoris"
            document.querySelectorAll('.like-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = parseInt(this.getAttribute('data-id'));
                    toggleWishlist(productId);
                });
            });
            
            // Bouton "Panier"
            document.querySelectorAll('.cart-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = parseInt(this.getAttribute('data-id'));
                    addToCart(productId);
                });
            });
        }
        
        // Fonction pour afficher la modal du produit
        function showProductModal(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            
            modalTitle.textContent = product.title;
            modalPrice.innerHTML = `
                ${product.price} DH
                ${product.oldPrice ? `<span class="old-price">${product.oldPrice} DH</span>` : ''}
            `;
            modalRating.innerHTML = `
                ${'<i class="fas fa-star"></i>'.repeat(Math.floor(product.rating))}
                ${product.rating % 1 ? '<i class="fas fa-star-half-alt"></i>' : ''}
                ${'<i class="far fa-star"></i>'.repeat(5 - Math.ceil(product.rating))}
                <span>(${product.rating})</span>
            `;
            modalMainImage.src = product.image;
            modalMainImage.alt = product.title;
            modalDescription.textContent = product.description;
            
            // Mettre à jour l'état du bouton favoris dans la modal
            const isInWishlist = wishlist.some(item => item.id === productId);
            modalAddToWishlist.innerHTML = `<i class="${isInWishlist ? 'fas' : 'far'} fa-heart"></i> Favoris`;
            if (isInWishlist) {
                modalAddToWishlist.classList.add('in-wishlist');
            } else {
                modalAddToWishlist.classList.remove('in-wishlist');
            }
            
            // Configurer les boutons de la modal
            modalAddToCart.onclick = () => {
                addToCart(productId);
                modal.style.display = "none";
            };
            
            modalAddToWishlist.onclick = () => {
                toggleWishlist(productId);
                modal.style.display = "none";
            };
            
            // Afficher la modal
            modal.style.display = "block";
        }
        
        // Fonction pour basculer un produit dans la wishlist
        function toggleWishlist(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            
            const index = wishlist.findIndex(item => item.id === productId);
            
            if (index === -1) {
                // Ajouter à la wishlist
                wishlist.push(product);
                // Mettre à jour l'icône dans la grille
                document.querySelector(`.like-btn[data-id="${productId}"] i`).classList.replace('far', 'fas');
                // Mettre à jour l'icône dans la modal si ouverte
                if (modalAddToWishlist) {
                    modalAddToWishlist.innerHTML = '<i class="fas fa-heart"></i> Favoris';
                    modalAddToWishlist.classList.add('in-wishlist');
                }
            } else {
                // Retirer de la wishlist
                wishlist.splice(index, 1);
                // Mettre à jour l'icône dans la grille
                document.querySelector(`.like-btn[data-id="${productId}"] i`).classList.replace('fas', 'far');
                // Mettre à jour l'icône dans la modal si ouverte
                if (modalAddToWishlist) {
                    modalAddToWishlist.innerHTML = '<i class="far fa-heart"></i> Favoris';
                    modalAddToWishlist.classList.remove('in-wishlist');
                }
            }
            
            // Sauvegarder dans le localStorage
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
        }
        
        // Fonction pour ajouter un produit au panier
        // Variable JS pour savoir si l'utilisateur est connecté, définie par PHP
        
// Vérifie si l'utilisateur est connecté (injection PHP correcte)
const isUserLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;

// Fonction pour ajouter un produit au panier
function addToCart(productId){
    if (!isUserLoggedIn) {
        // Afficher la modale de connexion
        const loginModal = document.getElementById('loginModal');
        loginModal.style.display = "block";
        sessionStorage.setItem('pendingProductId', productId);
        return;
    }

    const product = products.find(p => p.id === productId);
    if (!product) return;

    const existingItem = cart.find(item => item.id === productId);
    const quantity = existingItem ? existingItem.quantity + 1 : 1;

    if (existingItem) {
        existingItem.quantity = quantity;
    } else {
        cart.push({
            ...product,
            quantity: 1
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    
    // Appel à la fonction pour sauvegarder en base
    saveToDatabase(productId, quantity);
    
    alert(`${product.title} a été ajouté à votre panier`);
};
           
    // Le reste de la fonction existante pour les utilisateurs connectés...
    const product = products.find(p => p.id === productId);
    if (!product) return;

    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            ...product,
            quantity: 1
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    alert(`${product.title} a été ajouté à votre panier`);

// Fermer la modale de connexion
document.querySelector('.close-login-modal').addEventListener('click', () => {
    document.getElementById('loginModal').style.display = "none";
});

// Fermer la modale en cliquant à l'extérieur
window.addEventListener('click', (e) => {
    if (e.target === document.getElementById('loginModal')) {
        document.getElementById('loginModal').style.display = "none";
    }
});


        // Fonction pour enregistrer dans la base de données
        function saveToDatabase(productId, quantity) {
            fetch('save_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    user_id: <?= isset($_SESSION['user']) ? $_SESSION['user']['id'] : 'null' ?>
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Erreur:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        }
        
        // Fonction pour mettre à jour le compteur du panier
        function updateCartCount() {
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            const cartCount = document.querySelector('.cart-count');
            
            if (count > 0) {
                cartCount.textContent = count;
                cartCount.style.display = 'flex';
            } else {
                cartCount.style.display = 'none';
            }
        }
        
        // Écouteurs d'événements
        // Fermer la modal
        closeModal.addEventListener('click', () => {
            modal.style.display = "none";
        });
        
        // Fermer la modal en cliquant à l'extérieur
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
        
        // Changer de catégorie
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Retirer la classe active de tous les liens
                categoryLinks.forEach(l => l.classList.remove('active'));
                
                // Ajouter la classe active au lien cliqué
                this.classList.add('active');
                
                // Mettre à jour la catégorie courante
                currentCategory = this.getAttribute('data-category');
                
                // Re-rendre les produits
                renderProducts();
            });
        });
        
        // Changer le tri
        sortSelect.addEventListener('change', function() {
            currentSort = this.value;
            renderProducts();
        });
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

     
    </script><!-- Login Modal -->
<div class="login-modal" id="loginModal">
    <div class="login-modal-content">
        <span class="close-login-modal">&times;</span>
        <iframe src="login.html" class="login-iframe" id="loginIframe"></iframe>
    </div>
</div>
</body>
</html>