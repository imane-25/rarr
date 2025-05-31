<?php
// Configuration base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artisanat_beldi";

try {
    // Connexion PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des utilisateurs
    $stmt = $pdo->query("SELECT id, nom, prenom, age, ville, adresse, pays, code_postal, email, telephone, photo, date_inscription FROM utilisateurs ORDER BY id DESC");
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Gestion des utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f1e5;
            margin: 20px;
            color: #5C4033;
        }
        h1 {
            text-align: center;
            color: #8B5A2B;
            margin-bottom: 30px;
            font-family: 'Playfair Display', serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #D4A76A;
            padding: 10px 15px;
            text-align: left;
        }
        th {
            background-color: #8B5A2B;
            color: #FFF;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #F8F1E5;
        }
        img {
            max-width: 50px;
            max-height: 50px;
            border-radius: 6px;
            object-fit: cover;
        }
        td.address {
            white-space: pre-wrap; /* pour que nl2br fonctionne bien */
        }
        .no-users {
            text-align: center;
            padding: 20px;
            color: #8B5A2B;
            font-style: italic;
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
                    <li><a href="h.php"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="das.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="pro.php"><i class="fas fa-box-open"></i> Produits</a></li>
                    <li><a href="pp.php"><i class="fas fa-credit-card"></i> Commandes</a></li>

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
    <h1>Liste des utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Âge</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>Pays</th>
                <th>Code Postal</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date d'inscription</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($utilisateurs)): ?>
                <?php foreach ($utilisateurs as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td>
                            <?php if (!empty($user['photo'])): ?>
                                <img src="<?= htmlspecialchars($user['photo']) ?>" alt="Photo de <?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?>" />
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($user['nom']) ?></td>
                        <td><?= htmlspecialchars($user['prenom']) ?></td>
                        <td><?= (int)$user['age'] ?></td>
                        <td><?= htmlspecialchars($user['ville']) ?></td>
                        <td class="address"><?= nl2br(htmlspecialchars($user['adresse'])) ?></td>
                        <td><?= htmlspecialchars($user['pays']) ?></td>
                        <td><?= htmlspecialchars($user['code_postal']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['telephone'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user['date_inscription']) ?></td><td>
    <a class="btn-modifier" href="modifier_utilisateur.php?id=<?= urlencode($user['id']) ?>">Modifier</a>
</td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="12" class="no-users">Aucun utilisateur trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
