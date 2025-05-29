<?php
// Configuration de la session (identique à home.php)
ini_set('session.cookie_lifetime', 86400);
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
    <title>Contactez-nous | Beldi Artisanat Marocain</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
 <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js">
  </script>
    
     


   

    <style>

        /* Utilisez le même CSS que home.php */
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
        
        /* Styles spécifiques à la page Contact */
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            margin-top: 50px;
        }
        
        .contact-info {
            background: white;
            padding: 40px;
            box-shadow: var(--shadow);
            border-top: 5px solid var(--gold);
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        
        .contact-icon {
            font-size: 24px;
            color: var(--gold);
            margin-right: 20px;
            margin-top: 5px;
        }
        
        .contact-text h4 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--deep-blue);
        }
        
        .contact-form {
            background: white;
            padding: 40px;
            box-shadow: var(--shadow);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark-wood);
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
            transition: var(--transition);
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }
        
        .form-group textarea {
            height: 150px;
            resize: vertical;
        }
        
        .submit-btn {
            background: var(--gold);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .submit-btn:hover {
            background: var(--dark-wood);
            transform: translateY(-3px);
        }
        
        .map-container {
            margin-top: 80px;
            height: 400px;
            box-shadow: var(--shadow);
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .business-hours {
            margin-top: 40px;
        }
        
        .hours-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .hours-table tr {
            border-bottom: 1px solid #eee;
        }
        
        .hours-table tr:last-child {
            border-bottom: none;
        }
        
        .hours-table td {
            padding: 12px 0;
        }
        
        .hours-table td:last-child {
            text-align: right;
            font-weight: 600;
        }
        
        @media (max-width: 1024px) {
            .contact-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Même header que home.php -->
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
                    <li><a href="contact.php" class="active">Contact</a></li>
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

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('cont.jpg'); height: 60vh; min-height: 650px;">
        <div class="hero-content">
            <div class="hero-text">
                <h2>Contactez-nous</h2>
                <p>Une question sur nos produits, une demande spéciale ou simplement envie d'en savoir plus ? Notre équipe est à votre écoute.</p>
            </div> 
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section" >
        <div class="section-header">
            <h2>Nos Coordonnées</h2>
            <p>Visitez notre boutique à Marrakech ou contactez-nous par téléphone ou email. Nous serons ravis de répondre à vos questions.</p>
        </div>
        
        <div class="contact-container">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Notre Boutique</h4>
                        <p>Rue de la Kasbah, 40000 Marrakech, Maroc</p>
                        <p>À côté de la Place des Épices</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Téléphone</h4>
                        <p>+212 6 12 34 56 78</p>
                        <p>Service disponible de 9h à 19h</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Email</h4>
                        <p>beldi@gmail.com</p>
                        <p>Réponse sous 24h</p>
                    </div>
                </div>
                
                <div class="business-hours">
                    <h4>Heures d'Ouverture</h4>
                    <table class="hours-table">
                        <tr>
                            <td>Lundi - Vendredi</td>
                            <td>9h - 19h</td>
                        </tr>
                        <tr>
                            <td>Samedi</td>
                            <td>10h - 20h</td>
                        </tr>
                        <tr>
                            <td>Dimanche</td>
                            <td>11h - 18h</td>
                        </tr>
                    </table>
                </div>
            </div>
            
  
        
        
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3399.676646963717!2d-7.991799924044654!3d31.62618424287098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8d96179e51%3A0x5950b6534f87adb8!2sMarrakech%2C%20Maroc!5e0!3m2!1sfr!2sfr!4v1620000000000!5m2!1sfr!2sfr" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section" style="background-color: #f9f5f0; margin-top: 80px;">
        <div class="section-header">
            <h2>Questions Fréquentes</h2>
            <p>Retrouvez ici les réponses aux questions les plus posées par nos clients.</p>
        </div>
        
        <div class="faq-container" style="max-width: 800px; margin: 0 auto;">
            <div class="faq-item" style="margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                <h3 style="font-family: 'Playfair Display', serif; color: var(--deep-blue); margin-bottom: 10px;">Quels sont les délais de livraison ?</h3>
                <p>Les délais varient selon la destination et le type de produit. Pour le Maroc, comptez 2-5 jours ouvrés. Pour les livraisons internationales, 7-15 jours ouvrés. Les pièces sur mesure peuvent nécessiter un délai supplémentaire.</p>
            </div>
            
            <div class="faq-item" style="margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                <h3 style="font-family: 'Playfair Display', serif; color: var(--deep-blue); margin-bottom: 10px;">Proposez-vous la livraison internationale ?</h3>
                <p>Oui, nous expédions dans le monde entier via des transporteurs spécialisés. Les frais de port et délais dépendent de la destination.</p>
            </div>
            
            <div class="faq-item" style="margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                <h3 style="font-family: 'Playfair Display', serif; color: var(--deep-blue); margin-bottom: 10px;">Puis-je visiter vos ateliers ?</h3>
                <p>Nous organisons des visites guidées de nos ateliers sur rendez-vous. Contactez-nous pour planifier votre visite.</p>
            </div>
        </div>
    </section>
    
    <!-- Même footer que home.php -->
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
    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>

    <script>
        // Mêmes scripts que home.php
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

     
        
        // Script spécifique pour la page Contact
        document.querySelectorAll('.faq-item h3').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                answer.style.display = answer.style.display === 'none' ? 'block' : 'none';
            });
        });
    
    
   
    // Initialiser EmailJS avec votre clé publique



</script>

    
</body>
</html>