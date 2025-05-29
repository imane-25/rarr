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
}.product-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.view-btn, .order-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s;
}

.view-btn {
    background-color: #f0f0f0;
    color: #333;
}

.order-btn {
    background-color: #2a5a78;
    color: white;
}

.view-btn:hover {
    background-color: #ddd;
}

.order-btn:hover {
    background-color: #1d4357;
}
.product-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            width: 200px;
            display: inline-block;
        }
        .commander-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
        }
        #commandes-textarea {
            display: block;
            margin: 20px auto;
            padding: 10px;
            width: 80%;
        }
  body {
    font-family: Arial, sans-serif;
    margin: 10px;
  }
  .collection-nav-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
    display: flex;
    gap: 10px;
  }
  .collection-nav-item a {
    text-decoration: none;
    color: #333;
    padding: 6px 12px;
    border-radius: 4px;
    border: 1px solid transparent;
  }
  .collection-nav-item a.active,
  .collection-nav-item a:hover {
    border-color: #4CAF50;
    background-color: #d4f1d4;
    color: #2b6a2b;
  }
  .collection-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
  }
  .product-card {
    border: 1px solid #ddd;
    padding: 15px;
    width: 220px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 6px;
    background: white;
  }
  .product-card img {
    max-width: 100%;
    height: 130px;
    object-fit: cover;
    border-radius: 4px;
  }
  .price {
    font-weight: bold;
    color: #4CAF50;
    margin: 10px 0;
  }
  .commander-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    font-weight: bold;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    width: 100%;
  }
  .commander-btn:hover {
    background-color: #388e3c;
  }
  #commandes-container {
    max-width: 500px;
    margin: 30px auto 10px auto;
    background: #f9fff9;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #4CAF50;
    box-shadow: 0 0 10px #a5d6a7;
  }
  #commandes-container h2 {
    margin-top: 0;
    color: #256029;
  }
  #commandes-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  #commandes-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #ddd;
    font-size: 16px;
  }
  #commandes-list li:last-child {
    border-bottom: none;
  }
  .quantity-controls {
    display: flex;
    gap: 5px;
  }
  .quantity-controls button {
    background-color: #4caf50;
    color: white;
    border: none;
    width: 28px;
    height: 28px;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
  }
  .quantity-controls button:hover {
    background-color: #388e3c;
  }
  .remove-btn {
    margin-left: 10px;
    background-color: #e53935;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    font-weight: bold;
    font-size: 18px;
    line-height: 28px;
    text-align: center;
    cursor: pointer;
    color: white;
    border: none;
  }
  .remove-btn:hover {
    background-color: #ab000d;
  }
  @media (max-width: 600px) {
    .collection-grid {
      justify-content: center;
    }
    .product-card {
      width: 48%;
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

        <!-- Zone d'affichage des commandes -->
        <section id="commandes-container">
  <h2>Vos commandes</h2>
  <ul id="commandes-list">
    <!-- Commandes s’affichent ici -->
  </ul>
  <div id="commandes-total" style="font-weight:bold; text-align:right; margin-top:10px;"></div>
  <button id="finalize-btn">Finaliser la commande</button>
  <div id="message"></div>
</section>

<main>
  <div id="productGrid"></div> <!-- Assurez-vous que cet élément existe -->
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
        </div>
      </div>
    </div>
  </div>
</div>

<script>
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
  let commandes = [];

  document.addEventListener('DOMContentLoaded', function() {
    displayProducts();
    document.getElementById('finalize-btn').addEventListener('click', finaliserCommande);
  });

  function displayProducts(productsToDisplay = products) {
    const productGrid = document.getElementById('productGrid');
    productGrid.innerHTML = '';

    if (!productsToDisplay || productsToDisplay.length === 0) {
      productGrid.innerHTML = '<p class="no-products">Aucun produit disponible</p>';
      return;
    }

    productsToDisplay.forEach(product => {
      const card = document.createElement('div');
      card.className = 'product-card';
      card.innerHTML = `
        <img src="images/${product.image}" alt="${product.title}" loading="lazy">
        <h3>${product.title}</h3>
        <div class="price">${product.price} DH</div>
        <button class="commander-btn" data-id="${product.id}">Commander</button>
      `;
      productGrid.appendChild(card);
    });

    document.querySelectorAll('.commander-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        const product = products.find(p => p.id === id);
        if (product) ajouterCommande(product);
      });
    });
  }

  function ajouterCommande(product) {
    const existing = commandes.find(c => c.product.id === product.id);
    if (existing) {
      existing.quantity++;
    } else {
      commandes.push({ product: product, quantity: 1 });
    }
    mettreAJourCommandesAffichage();
  }

  function diminuerQuantite(productId) {
    const index = commandes.findIndex(c => c.product.id === productId);
    if (index !== -1) {
      if (commandes[index].quantity > 1) {
        commandes[index].quantity--;
      } else {
        commandes.splice(index, 1);
      }
      mettreAJourCommandesAffichage();
    }
  }

  function augmenterQuantite(productId) {
    const existing = commandes.find(c => c.product.id === productId);
    if (existing) {
      existing.quantity++;
      mettreAJourCommandesAffichage();
    }
  }

  function supprimerCommande(productId) {
    const index = commandes.findIndex(c => c.product.id === productId);
    if (index !== -1) {
      commandes.splice(index , 1);
      mettreAJourCommandesAffichage();
    }
  }

  function mettreAJourCommandesAffichage() {
    const list = document.getElementById('commandes-list');
    const totalDiv = document.getElementById('commandes-total');
    
    list.innerHTML = '';
    let total = 0;

    if (commandes.length === 0) {
      list.innerHTML = '<li>Aucune commande pour l\'instant.</li>';
      totalDiv.textContent = '';
      return;
    }

    commandes.forEach(({ product, quantity }) => {
      const li = document.createElement('li');
      const prixTotalProduit = product.price * quantity;
      total += prixTotalProduit;

      li.innerHTML = `
        <span>${product.title} (${quantity} × ${product.price} DH) = <strong>${prixTotalProduit} DH</strong></span>
        <div class="quantity-controls">
          <button aria-label="Diminuer quantité" title="Diminuer">-</button>
          <button aria-label="Augmenter quantité" title="Augmenter">+</button>
        </div>
        <button class="remove-btn" aria-label="Supprimer produit" title="Supprimer">&times;</button>
      `;

      const btns = li.querySelectorAll('.quantity-controls button');
      btns[0].addEventListener('click', () => diminuerQuantite(product.id));
      btns[1].addEventListener('click', () => augmenterQuantite(product.id));
      li.querySelector('.remove-btn').addEventListener('click', () => supprimerCommande(product.id));

      list.appendChild(li);
    });

    totalDiv.textContent = `Total commande: ${total} DH`;
  }

  async function finaliserCommande() {
    const messageDiv = document.getElementById('message');
    const finalizeBtn = document.getElementById('finalize-btn');
    
    // Désactiver le bouton pendant le traitement
    finalizeBtn.disabled = true;
    messageDiv.textContent = "Traitement en cours...";
    messageDiv.style.color = "black";

    if (commandes.length === 0) {
        messageDiv.style.color = "red";
        messageDiv.textContent = "Votre panier est vide.";
        finalizeBtn.disabled = false;
        return;
    }

    try {
        // Préparation des données optimisée
        const commandesData = commandes.map(({product, quantity}) => ({
            produit_id: product.id,
            produit_nom: product.title,
            prix: product.price,
            quantite: quantity
        }));

        const response = await fetch('enregistrer_commande.php', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' // Pour identification AJAX
            },
            body: JSON.stringify({ commandes: commandesData })
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => null);
            throw new Error(errorData?.message || `Erreur HTTP: ${response.status}`);
        }

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.message || 'Erreur lors de la finalisation');
        }

        // Succès
        messageDiv.style.color = "green";
        messageDiv.textContent = `Commande #${result.commande_id || ''} enregistrée avec succès!`;
        
        // Réinitialisation
        commandes = [];
        mettreAJourCommandesAffichage();
        
        // Option: Redirection ou affichage du récapitulatif
        // window.location.href = `/recapitulatif.php?id=${result.commande_id}`;

    } catch (error) {
        console.error("Erreur:", error);
        messageDiv.style.color = "red";
        messageDiv.textContent = `Échec: ${error.message}`;
        
        // Option: Log supplémentaire pour le débogage
        if (typeof error === 'object' && error !== null) {
            console.error('Détails:', {
                name: error.name,
                message: error.message,
                stack: error.stack
            });
        }
    } finally {
        finalizeBtn.disabled = false;
    }
}
  document.querySelectorAll('.collection-nav-item a').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      document.querySelectorAll('.collection-nav-item a').forEach(a => a.classList.remove('active'));
      link.classList.add('active');

      const category = link.getAttribute('data-category');
      const filtered = category === 'all' ? products : products.filter(p => p.category.toLowerCase() === category.toLowerCase());
      displayProducts(filtered);
    });
  });

  document.getElementById('sortSelect').addEventListener('change', function() {
    const sortBy = this.value;
    const copy = [...products];
    switch (sortBy) {
      case 'price-asc': copy.sort((a, b) => a.price - b.price); break;
      case 'price-desc': copy.sort((a, b) => b.price - a.price); break;
      case 'popular': copy.sort((a, b) => b.rating - a.rating); break;
      default: break;
    }
    displayProducts(copy);
  });
</script>

</body>
</html>

<?php 
// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artisanat_beldi";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Vérification de l'authentification
    if (!isset($_SESSION['user'])) {
        throw new Exception("Utilisateur non connecté", 401);
    }

    $user_id = $_SESSION['user']['id'] ?? null;
    if (!$user_id || !is_numeric($user_id)) {
        throw new Exception("ID utilisateur invalide", 400);
    }

    // Récupération et validation des données
    $json = file_get_contents('php://input');
    if (empty($json)) {
        throw new Exception("Aucune donnée reçue", 400);
    }

    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Données JSON invalides", 400);
    }

    if (!isset($data['commandes']) || !is_array($data['commandes']) || empty($data['commandes'])) {
        throw new Exception("Aucune commande fournie ou format incorrect", 400);
    }

    // Préparation de la requête
    $stmt = $conn->prepare("INSERT INTO commandes 
        (user_id, produit_id, produit_nom, prix, quantite, date_commande) 
        VALUES (:user_id, :produit_id, :produit_nom, :prix, :quantite, NOW())");

    // Traitement des commandes
    $conn->beginTransaction();
    
    foreach ($data['commandes'] as $commande) {
        // Validation des données de la commande
        $produit_id = filter_var($commande['produit_id'] ?? null, FILTER_VALIDATE_INT);
        $produit_nom = htmlspecialchars(strip_tags($commande['produit_nom'] ?? ''));
        $prix = filter_var($commande['prix'] ?? null, FILTER_VALIDATE_FLOAT);
        $quantite = filter_var($commande['quantite'] ?? 1, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1]
        ]);

        if (!$produit_id || !$produit_nom || $prix === false || $prix <= 0 || !$quantite) {
            throw new Exception("Données de commande incomplètes ou incorrectes", 400);
        }

        // Exécution de la requête
        $stmt->execute([
            ':user_id' => $user_id,
            ':produit_id' => $produit_id,
            ':produit_nom' => $produit_nom,
            ':prix' => $prix,
            ':quantite' => $quantite
        ]);
    }

    $conn->commit();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Commandes enregistrées avec succès',
        'count' => count($data['commandes'])
    ]);

} catch (PDOException $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode([
        "success" => false, 
        "message" => "Erreur base de données",
        "error" => $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code($e->getCode() >= 400 ? $e->getCode() : 400);
    echo json_encode([
        "success" => false, 
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ]);
}