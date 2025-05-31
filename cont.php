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
?><?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=artisanat_beldi;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les infos de l'admin (ex : admin_id = 1)
$stmt = $pdo->prepare("SELECT * FROM admins WHERE admin_id = :id");
$stmt->execute([':id' => 1]); // à remplacer par l'admin connecté si besoin
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    die("Administrateur introuvable.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Administrateur | Artisanat Beldi</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>.dropdown-menu {
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

        /* Profile Container */
        .profile-container {
            max-width: 600px;
            margin: 120px auto 60px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(139, 90, 43, 0.1);
        }

        .profile-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 25px;
            border: 5px solid var(--light-bg);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: var(--transition);
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .profile-name {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .profile-name::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: var(--secondary);
        }

        .profile-role {
            display: inline-block;
            background: var(--secondary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .profile-details {
            text-align: left;
            margin: 30px 0;
        }

        .detail-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px dashed rgba(139, 90, 43, 0.2);
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            background: var(--light-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .detail-content h3 {
            font-size: 1rem;
            color: var(--dark-wood);
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .detail-content p {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--dark-wood);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(139, 90, 43, 0.2);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--light-bg);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(139, 90, 43, 0.1);
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
        @media (max-width: 768px) {
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
            
            .profile-container {
                margin: 120px 20px 60px;
                padding: 30px 20px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">                <img src="log.png" alt="Artisanat Marocain">

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
    
    <div class="profile-container">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin['name']) ?>&background=8B5A2B&color=fff&size=150" alt="Admin" class="profile-avatar">
        
        <h1 class="profile-name"><?= htmlspecialchars($admin['name']) ?></h1>
        <span class="profile-role"><?= htmlspecialchars($admin['role']) ?></span>
        
        <div class="profile-details">
            <div class="detail-item">
                <div class="detail-icon">
                    <i class="fas fa-user-tag"></i>
                </div>
                <div class="detail-content">
                    <h3>Nom d'utilisateur</h3>
                    <p><?= htmlspecialchars($admin['username']) ?></p>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="detail-content">
                    <h3>Email</h3>
                    <p><?= htmlspecialchars($admin['email']) ?></p>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="detail-content">
                    <h3>Téléphone</h3>
                    <p><?= htmlspecialchars($admin['phone']) ?></p>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="detail-content">
                    <h3>Membre depuis</h3>
                    <p><?= date('d/m/Y', strtotime($admin['created_at'])) ?></p>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="mailto:<?= htmlspecialchars($admin['email']) ?>" class="btn btn-primary">
                <i class="fas fa-envelope"></i> Envoyer un email
            </a>
            <a href="edit_profile.php" class="btn btn-secondary">
                <i class="fas fa-edit"></i> Modifier le profil
            </a>
        </div>
    </div>
    
    <footer>
        <p>Artisanat Beldi &copy; <?= date('Y') ?> - Tous droits réservés</p>
    </footer>
</body>
</html>