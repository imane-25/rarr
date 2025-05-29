<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Artisanat Marocain</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-brown: #5C4033;
            --light-beige: #FFFFF0;
            --medium-brown: #8B5A2B;
            --error: #E74C3C;
            --success: #2ECC71;
        }
        
        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-beige);
            color: var(--dark-brown);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-image: url('https://example.com/moroccan-pattern.png');
            background-attachment: fixed;
            background-size: 30%;
            background-blend-mode: overlay;
            background-color: rgba(255, 253, 240, 0.9);
        }
        
        .registration-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        
        .registration-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--gold), var(--medium-brown));
        }
        
        h1 {
            color: var(--gold);
            text-align: center;
            margin-bottom: 30px;
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            position: relative;
            padding-bottom: 15px;
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--gold);
        }
        
        h1 i {
            margin-right: 10px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--medium-brown);
            font-size: 0.95rem;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            background-color: #f9f9f9;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
            background-color: white;
        }
        
        button {
            background-color: var(--gold);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            border-radius: 4px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
        }
        
        button:hover {
            background-color: var(--medium-brown);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 90, 43, 0.3);
        }
        
        button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        button:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-col {
            flex: 1;
        }
        
        .password-strength, .password-match {
            height: 5px;
            margin-top: 8px;
            border-radius: 3px;
            width: 100%;
        }
        
        .password-strength {
            background: #eee;
        }
        
        .password-match {
            background: #eee;
        }
        
        .password-strength.weak { background: var(--error); }
        .password-strength.medium { background: #FFA500; }
        .password-strength.strong { background: var(--success); }
        
        .password-match.match { background: var(--success); }
        .password-match.mismatch { background: var(--error); }
        
        .hint {
            font-size: 0.8rem;
            color: #888;
            margin-top: 5px;
            display: block;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .registration-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
        }
        
        /* Animation pour les champs */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-group {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }
        
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }
        .form-group:nth-child(6) { animation-delay: 0.6s; }
        .form-group:nth-child(7) { animation-delay: 0.7s; }
        .form-group:nth-child(8) { animation-delay: 0.8s; }
        .form-group:nth-child(9) { animation-delay: 0.9s; }
        .form-group:nth-child(10) { animation-delay: 1s; }
        button { animation-delay: 1.1s; }
    </style>
</head>
<body>
    <div class="registration-container">
        <h1><i class="fas fa-user-plus"></i> Créer un compte</h1>
        
        <form id="registrationForm" action="register.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="nom">Nom*</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="prenom">Prénom*</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="age">Âge*</label>
                <input type="number" id="age" name="age" min="18" required>
                <span class="hint">Vous devez avoir au moins 18 ans</span>
            </div>
            
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe*</label>
                <input type="password" id="password" name="password" required minlength="8">
                <div class="password-strength"></div>
                <span class="hint">Minimum 8 caractères avec majuscules, minuscules et chiffres</span>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmation du mot de passe*</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <div class="password-match"></div>
            </div>
            
            <div class="form-group">
                <label for="pays">Pays*</label>
                <select id="pays" name="pays" required>
                    <option value="">Sélectionnez...</option>
                    <option value="France">France</option>
                    <option value="Belgique">Belgique</option>
                    <option value="Maroc">Maroc</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ville">Ville*</label>
                <input type="text" id="ville" name="ville" required>
            </div>
            
            <div class="form-group">
                <label for="adresse">Adresse*</label>
                <textarea id="adresse" name="adresse" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="code_postal">Code Postal*</label>
                <input type="text" id="code_postal" name="code_postal" required>
            </div>
            
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" placeholder="+212 6 12 34 56 78">
            </div>
            
            <div class="form-group">
                <label for="photo">Photo de profil</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                <span class="hint">Format JPG ou PNG (max 2MB)</span>
            </div>
            
            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function() {
            const strengthIndicator = document.querySelector('.password-strength');
            const password = this.value;
            
            // Calcul de la force
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            // Mise à jour visuelle
            strengthIndicator.className = 'password-strength';
            if (password.length > 0) {
                if (strength < 2) strengthIndicator.classList.add('weak');
                else if (strength < 4) strengthIndicator.classList.add('medium');
                else strengthIndicator.classList.add('strong');
            }
        });
        
        document.getElementById('confirm_password').addEventListener('input', function() {
            const matchIndicator = document.querySelector('.password-match');
            const password = document.getElementById('password').value;
            
            if (this.value.length > 0) {
                matchIndicator.className = 'password-match ' + 
                    (this.value === password ? 'match' : 'mismatch');
            } else {
                matchIndicator.className = 'password-match';
            }
        });

        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${0.1 + index * 0.1}s`;
            });
        });
    </script>
</body>
</html>