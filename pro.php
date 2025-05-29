<?php
$pdo = new PDO("mysql:host=localhost;dbname=artisanat_beldi", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ajouter un produit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($title && $price && $description) {
        $stmt = $pdo->prepare("INSERT INTO products (title, price, description) VALUES (?, ?, ?)");
        $stmt->execute([$title, $price, $description]);
        header("Location: products_admin.php");
        exit();
    }
}

// Supprimer un produit
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: products_admin.php");
    exit();
}

// Récupérer tous les produits
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits | Artisanat Beldi</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            --primary: #8B5A2B;
            --secondary: #D4A76A;
            --light: #F8F1E5;
            --dark: #3A2C1A;
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
            padding-top: 100px;
        }

        /* Header Styles */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 1px solid rgba(163, 145, 86, 0.2);
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
        }

        .logo-text h1 {
            font-size: 28px;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin: 0;
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
            letter-spacing: 1px;
            position: relative;
            padding: 5px 0;
            transition: var(--transition);
        }

        nav ul li a:hover {
            color: var(--gold);
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

        nav ul li a:hover::after {
            width: 100%;
        }

        /* Admin Content Styles */
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
            position: relative;
            padding-bottom: 15px;
        }

        h1:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--gold);
        }

        h2 {
            font-size: 1.8rem;
            margin: 30px 0 20px;
            color: var(--primary);
        }

        /* Formulaire */
        .product-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
            border: 1px solid rgba(139, 90, 43, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary);
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            transition: var(--transition);
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: var(--secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 167, 106, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: var(--transition);
            text-align: center;
        }

        .btn:hover {
            background: var(--dark-wood);
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 8px;
        }

        /* Tableau des produits */
        .product-count {
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: block;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: var(--shadow);
            border-radius: 10px;
            overflow: hidden;
        }

        .products-table thead {
            background: var(--primary);
            color: white;
        }

        .products-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        .products-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(139, 90, 43, 0.1);
        }

        .products-table tr:last-child td {
            border-bottom: none;
        }

        .products-table tr:hover {
            background: rgba(212, 167, 106, 0.05);
        }

        .price {
            font-weight: 600;
            color: var(--primary);
        }

        .action-link {
            color: var(--terracotta);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
        }

        .action-link:hover {
            color: #c0392b;
            text-decoration: underline;
        }

        .action-link i {
            margin-right: 5px;
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
            }
            
            .admin-container {
                padding: 30px 15px;
            }

            h1 {
                font-size: 2rem;
                margin: 30px 0;
            }
            
            .products-table {
                display: block;
                overflow-x: auto;
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
                    <li><a href="das.php">DashBoard</a></li>
                    <li><a href="pro.php">Produits</a></li>
                    <li><a href="pp.php">Paiement</a></li>
                    <li><a href="cont.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="admin-container">
        <h1><i class="fas fa-cubes"></i> Gestion des Produits</h1>

        <!-- Formulaire d'ajout -->
        <form class="product-form" method="POST">
            <h2><i class="fas fa-plus-circle"></i> Ajouter un produit</h2>
            
            <div class="form-group">
                <label for="title">Titre du produit</label>
                <input type="text" id="title" name="title" placeholder="Ex: Tapis berbère" required>
            </div>
            
            <div class="form-group">
                <label for="price">Prix (€)</label>
                <input type="number" step="0.01" id="price" name="price" placeholder="Ex: 149.99" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description détaillée du produit..." required></textarea>
            </div>
            
            <button type="submit" name="add" class="btn"><i class="fas fa-save"></i> Ajouter le produit</button>
        </form>

        <!-- Liste des produits -->
        <h2><i class="fas fa-list-ul"></i> Catalogue des produits</h2>
        <span class="product-count"><?= count($products) ?> produit(s) enregistré(s)</span>
        
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['title']) ?></td>
                    <td class="price"><?= number_format($product['price'], 2) ?> €</td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td>
                        <a class="action-link" href="?delete=<?= $product['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>