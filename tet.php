<?php
session_start();

$user = null;
if (isset($_SESSION['user'])) {
    $user = [
        'id' => $_SESSION['user']['id'] ?? 0,
        'email' => isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : '',
        'nom' => isset($_SESSION['user']['nom']) ? htmlspecialchars($_SESSION['user']['nom']) : '',
        'prenom' => isset($_SESSION['user']['prenom']) ? htmlspecialchars($_SESSION['user']['prenom']) : '',
        'ville' => isset($_SESSION['user']['ville']) ? htmlspecialchars($_SESSION['user']['ville']) : '',
        'age' => $_SESSION['user']['age'] ?? 0
    ];
}
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
        
    /* Styles généraux cohérents avec la page home */
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
    /* Hero Section - Style similaire à home */
    .collection-hero {
        height: 80vh;
        min-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        padding-top: 80px;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        margin-bottom: 80px;
        text-align: center;
    }
    
    .collection-hero-content {
        max-width: 800px;
        padding: 0 20px;
        color: white;
        animation: fadeInUp 1s ease-out;
    }
    
    .collection-hero h1 {
        font-size: 4.5rem;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        font-weight: 700;
        letter-spacing: 1px;
    }
    
    .collection-hero p {
        font-size: 1.25rem;
        line-height: 1.8;
        margin-bottom: 2rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    }
    
    /* Navigation des collections - Style amélioré */
    .collection-nav {
        background-color: rgba(226, 222, 187, 0.53);
        box-shadow: 0 5px 15px rgb(196, 169, 115);
        position: sticky;
        top: 60px;
        z-index: 900;
        margin-bottom: 70px;
        border-bottom: 1px solid rgba(210, 180, 140, 0.3);
    }
    
    .collection-nav-container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .collection-nav-list {
        display: flex;
        list-style: none;
        justify-content: center;
        flex-wrap: wrap;
        padding: 0;
    }
    
    .collection-nav-item {
        position: relative;
        margin: 0 5px;
    }
    
    .collection-nav-item a {
        display: block;
        padding: 20px 25px;
        text-decoration: none;
        color: var(--dark-wood);
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 1px;
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
        width: 40%;
        height: 3px;
        background: var(--gold);
        border-radius: 3px;
    }
    
    /* Filtres - Style amélioré */
    .collection-filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 50px;
        padding: 0 20px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .filter-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--dark-wood);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .filter-select {
        padding: 12px 20px;
        border: 1px solid rgba(135, 93, 54, 0.92);
        background: white;
        color: var(--dark-wood);
        font-family: 'Montserrat', sans-serif;
        min-width: 200px;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 12px;
        border-radius: 4px;
        transition: var(--transition);
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
    }
    
    /* Grille de produits - Style amélioré */
    .collection-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }
    
    .product-card {
        background: white;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .product-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        transform: translateY(-10px);
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--terracotta);
        color: white;
        padding: 5px 15px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 1px;
        z-index: 2;
        border-radius: 20px;
        text-transform: uppercase;
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
        transform: scale(1.1);
    }
    
    .product-info {
        padding: 25px;
        text-align: center;
    }
    
    .product-info h3 {
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: var(--dark-wood);
        font-weight: 600;
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
        font-size: 1.2rem;
    }
    
    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
        margin-left: 5px;
    }
    
    .rating {
        color: var(--gold);
        font-size: 0.9rem;
    }
    
    /* Actions produit - Style amélioré */
    .product-actions {
        position: absolute;
        bottom: 20px;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 15px;
        opacity: 0;
        transform: translateY(20px);
        transition: var(--transition);
    }
    
    .product-card:hover .product-actions {
        opacity: 1;
        transform: translateY(0);
    }
    
    .view-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 30px;
        background-color: rgba(255, 255, 255, 0.95);
        color: var(--dark-wood);
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .view-btn:hover {
        background-color: var(--gold);
        color: white;
        transform: translateY(-3px);
    }
    
    .add-to-cart-btn {
        background-color: var(--dark-wood);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .add-to-cart-btn:hover {
        background-color: var(--gold);
        transform: translateY(-3px) scale(1.1);
    }
    
    /* Modale produit - Style amélioré */
    #productModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 2000;
        padding: 20px;
    }
    
    .modal-content {
        display: flex;
        background-color: var(--ivory);
        padding: 40px;
        max-width: 900px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 10px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        position: relative;
        animation: modalFadeIn 0.5s ease-out;
    }
    
    .close-modal {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 28px;
        color: var(--dark-wood);
        cursor: pointer;
        transition: var(--transition);
    }
    
    .close-modal:hover {
        color: var(--gold);
        transform: rotate(90deg);
    }
    
    .modal-content img {
        width: 45%;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 40px;
    }
    
    .modal-text {
        width: 55%;
        display: flex;
        flex-direction: column;
    }
    
    #modalProductTitle {
        font-size: 1.8rem;
        color: var(--dark-wood);
        margin-bottom: 15px;
    }
    
    #modalProductPrice {
        font-size: 1.5rem;
        color: var(--gold);
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    #modalProductRating {
        color: var(--gold);
        font-size: 1rem;
        margin-bottom: 20px;
    }
    
    #modalProductDescription {
        line-height: 1.8;
        color: var(--dark-wood);
        margin-bottom: 30px;
    }
    
    /* Zone de commande - Style amélioré */
    #orderTextField {
        width: 100%;
        padding: 15px;
        border: 1px solid rgba(92, 64, 51, 0.2);
        border-radius: 5px;
        font-family: 'Montserrat', sans-serif;
        margin: 20px 0;
        min-height: 120px;
        transition: var(--transition);
    }
    
    #orderTextField:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
    }
    
    #saveOrderBtn {
        background-color: var(--dark-wood);
        color: white;
        border: none;
        padding: 12px 25px;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 30px;
        cursor: pointer;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    #saveOrderBtn:hover {
        background-color: var(--gold);
        transform: translateY(-3px);
    }
    
    #orderMessage {
        margin-top: 15px;
        font-size: 0.9rem;
        color: var(--terracotta);
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .collection-hero h1 {
            font-size: 3.5rem;
        }
        
        .collection-nav-item a {
            padding: 15px 20px;
        }
        
        .modal-content {
            flex-direction: column;
        }
        
        .modal-content img {
            width: 100%;
            margin-right: 0;
            margin-bottom: 30px;
        }
        
        .modal-text {
            width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .collection-hero {
            height: 60vh;
            min-height: 500px;
        }
        
        .collection-hero h1 {
            font-size: 2.5rem;
        }
        
        .collection-hero p {
            font-size: 1rem;
        }
        
        .collection-nav-list {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 10px;
            -webkit-overflow-scrolling: touch;
        }
        
        .collection-nav-item {
            flex: 0 0 auto;
        }
        
        .collection-filters {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
    }
    
    @media (max-width: 480px) {
        .collection-hero {
            height: 50vh;
            min-height: 400px;
        }
        
        .collection-hero h1 {
            font-size: 2rem;
        }
        
        .collection-grid {
            grid-template-columns: 1fr;
        }
        
        .modal-content {
            padding: 20px;
        }
        
        #modalProductTitle {
            font-size: 1.4rem;
        }
    }  footer {
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
            }}
    /* Modale de confirmation */
/* Par défaut, la modale est cachée */

    /* Modale de confirmation */
    .confirmation-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 40%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 2000;
        justify-content: center;
        align-items: center;
    }
.confirmation-modal.active {
    display: flex;
}
    .confirmation-content {
        background-color: var(--ivory);
        width: 90%;
        max-width: 600px;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        text-align: center;
        position: relative;
        animation: modalFadeIn 0.5s ease-out;
    }

    .confirmation-icon {
        font-size: 60px;
        color: var(--gold);
        margin-bottom: 20px;
    }

    .confirmation-title {
        font-size: 28px;
        color: var(--dark-wood);
        margin-bottom: 15px;
        font-family: 'Playfair Display', serif;
    }

    .confirmation-text {
        font-size: 16px;
        color: var(--dark-wood);
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .order-summary {
        background: rgba(212, 175, 55, 0.1);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        text-align: left;
    }

    .order-summary h4 {
        font-family: 'Playfair Display', serif;
        color: var(--dark-wood);
        margin-bottom: 15px;
        font-size: 18px;
    }

    .order-summary p {
        margin: 8px 0;
        font-size: 14px;
    }

    .order-summary .total {
        font-weight: 700;
        color: var(--gold);
        font-size: 18px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed rgba(92, 64, 51, 0.3);
    }

    /* Options de paiement */
    .payment-options {
        margin-top: 30px;
        text-align: center;
    }

    .payment-options h3 {
        font-family: 'Playfair Display', serif;
        color: var(--dark-wood);
        margin-bottom: 20px;
        font-size: 20px;
    }

    .payment-methods {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .payment-method {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
        padding: 15px 25px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(92, 64, 51, 0.1);
    }

    .payment-method:hover {
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }

    .payment-method.active {
        border: 2px solid var(--gold);
        background: rgba(212, 175, 55, 0.1);
    }

    .payment-icon {
        font-size: 30px;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .payment-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark-wood);
    }

    .confirm-btn {
        background-color: var(--dark-wood);
        color: white;
        border: none;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 30px;
        cursor: pointer;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 20px;
    }

    .confirm-btn:hover {
        background-color: var(--gold);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .close-confirmation {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 24px;
        color: var(--dark-wood);
        cursor: pointer;
        transition: var(--transition);
    }

    .close-confirmation:hover {
        color: var(--terracotta);
        transform: rotate(90deg);
    }

    /* Animation */
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .confirmation-content {
            padding: 30px 20px;
        }
        
        .confirmation-title {
            font-size: 24px;
        }
        
        .payment-methods {
            flex-direction: column;
            gap: 15px;
        }
        
        .payment-method {
            width: 100%;
        }
    }
</style>
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
                    <li><a href="collecti.php" class="active">Collections</a></li>
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
          
        </div>
    </header>

    <!-- Hero -->
    <section class="collection-hero"style="background-image: url('ri.jpg'); height: 70vh; min-height: 600px;">
        <div class="collection-hero-content" style="background-color:rgba(195, 159, 82, 0.44);">
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

        <!-- Product Modal -->
        
        
    </main>
<div class="product-actions">
    <button class="view-btn" data-id="${product.id}">
        <i class="fas fa-eye"></i> Voir
    </button>
</div><textarea id="orderTextField" placeholder="Votre commande..." rows="5" style="width: 100%; margin-top: 20px;"></textarea>
<button id="saveOrderBtn">Enregistrer la commande</button>
<button id="cancelOrderBtn" style="margin-top: 10px;">Annuler la commande</button>

<p id="orderMessage"></p>

<div id="productGrid"></div>

<!-- Modale produit -->
<div id="productModal" style="display: none;">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <img id="modalMainImage" src="" alt="" />
    <h3 id="modalProductTitle"></h3>
    <div id="modalProductPrice"></div>
    <div id="modalProductRating"></div>
    <p id="modalProductDescription"></p>
  </div>
</div>

<!-- Modale de confirmation -->
<div id="confirmationModal" class="confirmation-modal" style="display:none;">
  <div class="confirmation-content">
    <span class="close-confirmation">&times;</span>
    <div class="confirmation-icon"><i class="fas fa-check-circle"></i></div>
    <h2 class="confirmation-title">Commande confirmée !</h2>
    <p class="confirmation-text">Merci pour votre commande. Voici un récapitulatif :</p>

    <div class="order-summary">
      <h4>Récapitulatif de commande</h4>
      <p><strong>Référence :</strong> <span id="orderRef">CMD-XXXX</span></p>
      <p><strong>Date :</strong> <span id="orderDate">--</span></p>
      <p><strong>Articles :</strong> <span id="orderItems">--</span></p>
      <p><strong>Livraison :</strong> <span id="orderShipping">--</span></p>
      <p class="total"><strong>Total :</strong> <span id="orderTotal">--</span> DH</p>
    </div>

    <div class="payment-options">
      <h3>Méthode de paiement</h3>
      <div class="payment-methods">
        <div class="payment-method" data-method="delivery">
          <div class="payment-icon"><i class="fas fa-truck"></i></div>
          <span class="payment-label">Paiement à la livraison</span>
        </div>
        <div class="payment-method" data-method="online">
          <div class="payment-icon"><i class="fas fa-credit-card"></i></div>
          <span class="payment-label">Paiement en ligne</span>
        </div>
      </div>

      <button class="confirm-btn">Confirmer le paiement</button>
      <button id="cancelOrderModalBtn" style="
        margin-top: 10px;
        background-color: var(--dark-wood);
        color: white;
        border: none;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 30px;
        cursor: pointer;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 1px;
      ">Annuler la commande</button>
    </div>
  </div>
</div>

<!-- Modal messages info -->
<div id="messageModal" class="confirmation-modal" style="display:none;">
  <div class="confirmation-content">
    <span class="close-message">&times;</span>
    <div class="confirmation-icon"><i class="fas fa-info-circle"></i></div>
    <h2 class="confirmation-title">Information</h2>
    <p class="confirmation-text" id="messageContent">Message ici...</p>
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
                image: "lumini.jpg",
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
                image: "tass.jpg",
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
                image: "taz.jpg",
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
                image: "coff.jpg",
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
                image: "sus.jpg",
                badge: "Nouveauté",
                description: "Suspension artisanale en laiton ciselé, inspirée des formes lunaires marocaines. Diamètre : 50 cm. Fait main à Marrakech."
            }, {
                id: 12,
                title: "Bracelet Berbère en Argent Gravé",
                price: 670,
                oldPrice: null,
                rating: 4.3,
                category: "bijoux",
                region: "atlas",
                image: "bbl.jpg",
                badge: null,
                description: "Bracelet ouvert en argent massif 925 gravé de motifs berbères ancestraux. Artisanat de l'Atlas central."
            }
        ]


let orderLines = [];
let selectedPaymentMethod = '';  // Variable globale pour stocker le mode de paiement sélectionné

document.addEventListener('DOMContentLoaded', function () {
    displayProducts();
    setupModal();
    setupCategoryFilters();
    setupSorting();
    setupOrderSaving();
    setupPaymentMethodSelection();
    setupCancelButtons();
});

function setupOrderSaving() {
    const saveOrderBtn = document.getElementById('saveOrderBtn');
    const orderTextField = document.getElementById('orderTextField');
    const orderMessage = document.getElementById('orderMessage');

    saveOrderBtn.addEventListener('click', function () {
        if (orderLines.length === 0) {
            orderMessage.textContent = "Veuillez ajouter des produits à la commande.";
            return;
        }
        orderMessage.textContent = "";

        fetch('save_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `orders=${encodeURIComponent(JSON.stringify(orderLines))}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showConfirmationModal(orderLines);
                // Ne vide pas encore la commande ici, ça sera fait après confirmation paiement
            } else {
                orderMessage.textContent = "Erreur lors de l'enregistrement de la commande.";
            }
        })
        .catch(error => {
            orderMessage.textContent = "Erreur de connexion au serveur.";
            console.error(error);
        });
    });
}

function showConfirmationModal(orderLines) {
    const modal = document.getElementById('confirmationModal');
    const reference = `CMD-${new Date().getFullYear()}-${Math.floor(Math.random() * 9000 + 1000)}`;
    const total = orderLines.reduce((sum, product) => sum + (product.prix * product.quantite), 0);

    document.getElementById('orderRef').textContent = reference;
    document.getElementById('orderDate').textContent = new Date().toLocaleDateString('fr-FR');
    document.getElementById('orderItems').textContent = orderLines.reduce((sum, product) => sum + product.quantite, 0);
    document.getElementById('orderShipping').textContent = "Standard (5-7 jours)";
    document.getElementById('orderTotal').textContent = total.toFixed(2);

    // Reset selection paiement
    selectedPaymentMethod = '';
    document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));

    modal.style.display = 'flex';
    modal.classList.add('active');
}

function setupPaymentMethodSelection() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            paymentMethods.forEach(m => m.classList.remove('active'));
            method.classList.add('active');
            selectedPaymentMethod = method.dataset.method;
        });
    });

    document.querySelector('.close-confirmation').addEventListener('click', () => {
        closeConfirmationModal();
    });

    document.querySelector('.confirm-btn').addEventListener('click', () => {
        if (!selectedPaymentMethod) {
            alert("Veuillez sélectionner un mode de paiement.");
            return;
        }
        saveOrderToDatabase(orderLines, selectedPaymentMethod);
        closeConfirmationModal();
    });
}

function closeConfirmationModal() {
    const modal = document.getElementById('confirmationModal');
    modal.style.display = 'none';
    modal.classList.remove('active');
}