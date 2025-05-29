<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "beldi_artisanat";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $created_at = date('Y-m-d H:i:s');

    // Préparer et lier
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, address, phone, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $password, $address, $phone, $created_at);

    // Exécuter la requête
    if ($stmt->execute()) {
        $success_message = "<div class='success-message'>Inscription réussie ! Bienvenue chez Beldi Artisanat.</div>";
    } else {
        $error_message = "<div class='error-message'>Erreur : " . $stmt->error . "</div>";
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Beldi Artisanat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
        
        .logo span {
            color: var(--accent-color);
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        nav ul li a:hover {
            color: var(--accent-color);
        }
        
        .main {
            padding: 3rem 0;
            min-height: 70vh;
        }
        
        .registration-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--accent-color);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border 0.3s ease;
        }
        
        input:focus {
            border-color: var(--accent-color);
            outline: none;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .login-link a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .footer-section {
            flex: 1;
            min-width: 250px;
            margin-bottom: 1.5rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-section h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--accent-color);
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-section ul li a {
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-section ul li a:hover {
            color: var(--accent-color);
            padding-left: 5px;
        }
        
        .social-icons a {
            color: white;
            margin-right: 1rem;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            color: var(--accent-color);
        }
        
        .copyright {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 1.5rem;
        }
        
        .success-message {
            background-color: var(--success-color);
            color: white;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .error-message {
            background-color: var(--secondary-color);
            color: white;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin-top: 1rem;
                justify-content: center;
            }
            
            .footer-content {
                flex-direction: column;
            }
        }
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .login-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            width: 90%;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-header h1 {
            font-family: 'Playfair Display', serif;
            color: var(--dark-wood);
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #777;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-wood);
        }
        
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Montserrat', sans-serif;
            transition: var(--transition);
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--gold);
        }
        
        .login-btn {
            width: 100%;
            padding: 15px;
            background: var(--gold);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 16px;
        }
        
        .login-btn:hover {
            background: var(--dark-wood);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 30px;
        }
        
        .login-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .login-footer a:hover {
            color: var(--dark-wood);
        }
        
        .error-message {
            color: var(--terracotta);
            margin-top: 5px;
            font-size: 14px;
            display: none;
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
        
        /* Footer */
        footer {
            margin-top: auto;
            background-color: var(--dark-wood);
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        
        .footer-bottom p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .login-container {
                margin: 80px auto;
                padding: 30px;
            }
            
            .header-container {
                flex-direction: column;
                padding: 15px 20px;
            }
            
            nav {
                margin: 20px 0;
            }
        }.main {
    padding: 3rem 0;
    min-height: 70vh;
    margin-top: 80px; /* Ajustement pour éviter que le formulaire soit caché */
}
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="log.png" alt="Artisanat Marocain">
                <div class="logo-text">
                    <h1><span class="first-letter">B</span>eldi</h1>
                    <p>Artisanat du Maroc</p>
                </div>
            </div>
        </div>
    </header>


    <main class="main">
        <div class="container">
            <div class="registration-container">
                <h1 class="page-title">Créer un Compte</h1>
                
                <?php 
                if (isset($success_message)) {
                    echo $success_message;
                } elseif (isset($error_message)) {
                    echo $error_message;
                }
                ?>
                
                <form id="registrationForm" action="register.php" method="POST">
                    <div class="form-group">
                        <label for="username">Nom complet :</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirmer le mot de passe :</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Adresse :</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Numéro de téléphone :</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
    <label for="date_naissance">Date de naissance :</label>
    <input type="date" id="date_naissance" name="date_naissance" 
       max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" 
       required>
</div>

<div class="form-group">
        <label for="pays">Pays :</label>
        <select id="pays" name="pays" required onchange="updateVilles()">
            <option value="">-- Sélectionnez --</option>
            <option value="Maroc">🇲🇦 Maroc</option>
            <option value="France">🇫🇷 France</option>
            <option value="Belgique">🇧🇪 Belgique</option>
        </select>
    </div>

    <div class="form-group">
        <label for="ville">Ville :</label>
        <select id="ville" name="ville" required disabled>
            <option value="">-- Sélectionnez un pays d'abord --</option>
        </select>
    </div>

    <script>
        const villesDatabase = {
            "Maroc": {
                "Casablanca": "CAS",
                "Rabat": "RAB",
                "Marrakech": "MAR",
                "Tanger": "TAN",
                "Agadir": "AGA"
            },
            "France": {
                "Paris": "PAR",
                "Lyon": "LYO",
                "Marseille": "MAR",
                "Toulouse": "TOU",
                "Nice": "NIC"
            },
            "Belgique": {
                "Bruxelles": "BRU",
                "Anvers": "ANV",
                "Gand": "GAN",
                "Liège": "LIE",
                "Namur": "NAM"
            }
        };

        function updateVilles() {
            const pays = document.getElementById("pays").value;
            const villeSelect = document.getElementById("ville");
            
            villeSelect.innerHTML = '';
            villeSelect.disabled = true;
            
            if (!pays) {
                villeSelect.innerHTML = '<option value="">-- Sélectionnez un pays d\'abord --</option>';
                return;
            }
            
            const defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "-- Sélectionnez une ville --";
            villeSelect.appendChild(defaultOption);
            
            Object.keys(villesDatabase[pays]).forEach(villeNom => {
                const option = document.createElement("option");
                option.value = villesDatabase[pays][villeNom]; // Stocke le code
                option.textContent = villeNom; // Affiche le nom complet
                villeSelect.appendChild(option);
            });
            
            villeSelect.disabled = false;
        }
    </script>


</form>
                    <a href="register.php" class="btn">S'inscrire</a>
                    <div class="login-link">
                        Déjà un compte ? <a href="login.php">Connectez-vous</a>
                    </div><script>('registrationForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Les mots de passe ne correspondent pas.');
        return false;
    }
    return true;
});</script>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>À propos de nous</h3>
                    <p>Beldi Artisanat propose des produits artisanaux marocains authentiques, fabriqués à la main par des artisans locaux.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="boutique.php">Boutique</a></li>
                        <li><a href="apropos.php">À propos</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Rue Artisanale, Marrakech</p>
                    <p><i class="fas fa-phone"></i> +212 6 12 34 56 78</p>
                    <p><i class="fas fa-envelope"></i> contact@beldi-artisanat.com</p>
                    
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> Beldi Artisanat. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert('Les mots de passe ne correspondent pas.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>