<!-- Ajoutez ceci dans la section <head> -->
<style>
    /* Styles spécifiques pour la page Contact - Version Luxe */
    .contact-hero {
        background: linear-gradient(rgba(92, 64, 51, 0.7), rgba(92, 64, 51, 0.7)), url('https://images.unsplash.com/photo-1540574163026-643ea20ade25?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        height: 60vh;
        min-height: 500px;
        display: flex;
        align-items: center;
        position: relative;
    }
    
    .contact-hero-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
        color: white;
        width: 100%;
    }
    
    .contact-hero h2 {
        font-size: 72px;
        line-height: 1.1;
        margin-bottom: 25px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    
    .contact-hero p {
        font-size: 18px;
        line-height: 1.8;
        margin-bottom: 40px;
        font-weight: 300;
        max-width: 600px;
    }
    
    .btn-contact {
        display: inline-block;
        padding: 18px 45px;
        background-color: var(--gold);
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
    
    .btn-contact:hover {
        background-color: var(--dark-wood);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Section Contact améliorée */
    .contact-section {
        padding: 100px 40px;
        background-color: #f9f5f0;
    }
    
    .contact-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .contact-info-card {
        background: white;
        padding: 50px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        border-top: 5px solid var(--gold);
        position: relative;
        overflow: hidden;
    }
    
    .contact-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://www.transparenttextures.com/patterns/morocco.png');
        opacity: 0.03;
        pointer-events: none;
    }
    
    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 40px;
        position: relative;
        z-index: 1;
    }
    
    .contact-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(212, 175, 55, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 25px;
        flex-shrink: 0;
    }
    
    .contact-icon i {
        font-size: 24px;
        color: var(--gold);
    }
    
    .contact-text h4 {
        font-size: 22px;
        margin-bottom: 10px;
        color: var(--deep-blue);
        font-family: 'Playfair Display', serif;
    }
    
    .contact-text p {
        color: var(--dark-wood);
        line-height: 1.8;
    }
    
    .business-hours {
        margin-top: 50px;
    }
    
    .business-hours h4 {
        font-size: 22px;
        margin-bottom: 20px;
        color: var(--deep-blue);
        font-family: 'Playfair Display', serif;
        position: relative;
        padding-bottom: 10px;
    }
    
    .business-hours h4::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: var(--gold);
    }
    
    .hours-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .hours-table tr {
        border-bottom: 1px solid rgba(92, 64, 51, 0.1);
    }
    
    .hours-table tr:last-child {
        border-bottom: none;
    }
    
    .hours-table td {
        padding: 15px 0;
        color: var(--dark-wood);
    }
    
    .hours-table td:first-child {
        font-weight: 500;
    }
    
    .hours-table td:last-child {
        text-align: right;
        font-weight: 600;
        color: var(--gold);
    }
    
    /* Formulaire de contact amélioré */
    .contact-form-card {
        background: white;
        padding: 50px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        position: relative;
    }
    
    .contact-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://www.transparenttextures.com/patterns/arabesque.png');
        opacity: 0.03;
        pointer-events: none;
    }
    
    .contact-form h3 {
        font-size: 28px;
        margin-bottom: 30px;
        color: var(--deep-blue);
        font-family: 'Playfair Display', serif;
        position: relative;
    }
    
    .contact-form h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: var(--gold);
    }
    
    .form-group {
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
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
        border: 1px solid rgba(92, 64, 51, 0.2);
        border-radius: 4px;
        font-family: 'Montserrat', sans-serif;
        transition: var(--transition);
        background-color: rgba(255,255,255,0.8);
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
        padding: 18px 45px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 1px;
        width: 100%;
        border-radius: 4px;
    }
    
    .submit-btn:hover {
        background: var(--dark-wood);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Carte interactive */
    .map-container {
        margin-top: 80px;
        height: 500px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }
    
    .map-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://www.transparenttextures.com/patterns/morocco-blue.png');
        opacity: 0.03;
        pointer-events: none;
        z-index: 1;
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
        position: relative;
        z-index: 2;
    }
    
    /* FAQ améliorée */
    .faq-section {
        padding: 100px 40px;
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(249,245,240,0.9) 100%);
        position: relative;
    }
    
    .faq-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://www.transparenttextures.com/patterns/cream-paper.png');
        opacity: 0.3;
        pointer-events: none;
    }
    
    .faq-container {
        max-width: 1000px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    
    .faq-item {
        margin-bottom: 30px;
        border-bottom: 1px solid rgba(92, 64, 51, 0.1);
        padding-bottom: 30px;
        transition: var(--transition);
    }
    
    .faq-item:last-child {
        border-bottom: none;
    }
    
    .faq-item h3 {
        font-family: 'Playfair Display', serif;
        color: var(--deep-blue);
        margin-bottom: 15px;
        font-size: 22px;
        cursor: pointer;
        position: relative;
        padding-right: 40px;
    }
    
    .faq-item h3::after {
        content: '+';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        font-size: 24px;
        color: var(--gold);
        transition: var(--transition);
    }
    
    .faq-item.active h3::after {
        content: '-';
    }
    
    .faq-item p {
        color: var(--dark-wood);
        line-height: 1.8;
        display: none;
        padding-top: 10px;
    }
    
    .faq-item.active p {
        display: block;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .contact-container {
            grid-template-columns: 1fr;
        }
        
        .contact-hero h2 {
            font-size: 56px;
        }
    }
    
    @media (max-width: 768px) {
        .contact-hero {
            height: 50vh;
            min-height: 400px;
        }
        
        .contact-hero h2 {
            font-size: 42px;
        }
        
        .contact-hero p {
            font-size: 16px;
        }
        
        .contact-info-card,
        .contact-form-card {
            padding: 30px;
        }
        
        .contact-item {
            flex-direction: column;
        }
        
        .contact-icon {
            margin-bottom: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .contact-hero h2 {
            font-size: 32px;
        }
        
        .contact-section,
        .faq-section {
            padding: 60px 20px;
        }
    }
</style>

<!-- Remplacez la section hero existante par ceci -->
<section class="contact-hero">
    <div class="contact-hero-content">
        <h2>Contactez nos artisans</h2>
        <p>Une question sur nos créations ? Une commande spéciale ? Notre équipe est à votre écoute pour vous guider dans votre découverte de l'artisanat marocain.</p>
        <a href="#contact-form" class="btn-contact">Envoyer un message</a>
    </div>
</section>

<!-- Section Contact améliorée -->
<section class="contact-section">
    <div class="contact-container">
        <div class="contact-info-card">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">
                    <h4>Notre Atelier-Boutique</h4>
                    <p>Rue de la Kasbah, 40000 Marrakech</p>
                    <p>À deux pas de la Place Jemaa el-Fna</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="contact-text">
                    <h4>Par Téléphone</h4>
                    <p>+212 6 12 34 56 78</p>
                    <p>Appel direct du lundi au samedi</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-text">
                    <h4>Par Email</h4>
                    <p>beldi@gmail.com</p>
                    <p>Réponse garantie sous 24h</p>
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
                    <tr>
                        <td>Jours fériés</td>
                        <td>Sur rendez-vous</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="contact-form-card" id="contact-form">
            <form class="contact-form">
                <h3>Votre Message</h3>
                
                <div class="form-group">
                    <label for="name">Votre Nom Complet*</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Votre Email*</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Téléphone (facultatif)</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="subject">Sujet de votre message</label>
                    <select id="subject" name="subject">
                        <option value="question">Question sur un produit</option>
                        <option value="commande">Commande spéciale</option>
                        <option value="livraison">Information livraison</option>
                        <option value="autre">Autre demande</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Votre Message*</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Envoyer le message</button>
            </form>
        </div>
    </div>
    
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3399.676646963717!2d-7.991799924044654!3d31.62618424287098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8d96179e51%3A0x5950b6534f87adb8!2sMarrakech%2C%20Maroc!5e0!3m2!1sfr!2sfr!4v1620000000000!5m2!1sfr!2sfr" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<!-- FAQ améliorée -->
<section class="faq-section">
    <div class="section-header">
        <h2>Questions Fréquentes</h2>
        <p>Retrouvez ici les réponses aux questions les plus posées par nos clients.</p>
    </div>
    
    <div class="faq-container">
        <div class="faq-item">
            <h3>Quels sont les délais de fabrication pour une commande spéciale ?</h3>
            <p>Les délais varient selon la complexité de la pièce et la charge de travail de nos artisans. En moyenne, comptez entre 2 et 6 semaines pour une pièce sur mesure. Nous vous fournissons un délai précis lors de la validation de votre commande.</p>
        </div>
        
        <div class="faq-item">
            <h3>Proposez-vous des services de livraison internationale ?</h3>
            <p>Oui, nous expédions dans le monde entier via des transporteurs spécialisés dans les objets fragiles et de valeur. Chaque pièce est soigneusement emballée avec des matériaux de protection adaptés. Les frais et délais dépendent de la destination.</p>
        </div>
        
        <div class="faq-item">
            <h3>Puis-je visiter vos ateliers à Marrakech ?</h3>
            <p>Nous organisons des visites guidées de nos ateliers sur rendez-vous du lundi au vendredi. C'est l'occasion de rencontrer nos artisans et de découvrir les techniques traditionnelles. Contactez-nous pour planifier votre visite.</p>
        </div>
        
        <div class="faq-item">
            <h3>Quelles sont vos politiques de retour et d'échange ?</h3>
            <p>En raison du caractère artisanal et souvent sur mesure de nos produits, les retours ne sont pas acceptés sauf en cas de dommage pendant le transport. Dans ce cas, nous organisons le remplacement ou la réparation de la pièce.</p>
        </div>
    </div>
</section>

<!-- Ajoutez ce script pour la FAQ interactive -->
<script>
    // FAQ interactive
    document.querySelectorAll('.faq-item h3').forEach(question => {
        question.addEventListener('click', () => {
            const item = question.parentElement;
            item.classList.toggle('active');
        });
    });
    
    // Animation des éléments au scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.contact-item, .contact-form-card, .faq-item');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Initial state for animation
    document.querySelectorAll('.contact-item, .contact-form-card, .faq-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1)';
    });
    
    window.addEventListener('load', animateOnScroll);
    window.addEventListener('scroll', animateOnScroll);
    
    // Initialisation d'EmailJS
    (function() {
        emailjs.init("7zbC33g0M8dUwKkr6"); // Votre clé publique
    })();
    
    // Gestion de l'envoi du formulaire
    document.querySelector('.contact-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Ajout de la date automatiquement
        const now = new Date();
        this.date = now.toLocaleString('fr-FR');
        
        emailjs.sendForm('service_56b9pls', 'template_b1uxevp', this)
            .then(function() {
                // Créer et afficher la modale de succès
                const successModal = document.createElement('div');
                successModal.className = 'success-modal';
                successModal.innerHTML = `
                    <div class="success-modal-content">
                        <span class="close-modal">&times;</span>
                        <div class="success-icon"><i class="fas fa-check-circle"></i></div>
                        <h3>Message envoyé avec succès !</h3>
                        <p>Nous avons bien reçu votre demande et vous répondrons dans les plus brefs délais.</p>
                        <button class="btn modal-close-btn">Fermer</button>
                    </div>
                `;
                document.body.appendChild(successModal);
                
                // Fermer la modale
                const closeModal = () => {
                    document.body.removeChild(successModal);
                    document.querySelector('.contact-form').reset();
                };
                
                successModal.querySelector('.close-modal').addEventListener('click', closeModal);
                successModal.querySelector('.modal-close-btn').addEventListener('click', closeModal);
                successModal.addEventListener('click', (e) => {
                    if (e.target === successModal) closeModal();
                });
            }, function(error) {
                alert('Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.');
                console.error('EmailJS Error:', error);
            });
    });
</script>

<!-- Style pour la modale de succès -->
<style>
    .success-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3000;
        animation: fadeIn 0.3s;
    }
    
    .success-modal-content {
        background: white;
        padding: 40px;
        border-radius: 10px;
        text-align: center;
        max-width: 500px;
        width: 90%;
        position: relative;
        animation: slideUp 0.4s;
    }
    
    .close-modal {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 28px;
        color: #aaa;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .close-modal:hover {
        color: var(--dark-wood);
    }
    
    .success-icon {
        font-size: 60px;
        color: #4CAF50;
        margin-bottom: 20px;
    }
    
    .success-modal h3 {
        font-family: 'Playfair Display', serif;
        color: var(--deep-blue);
        margin-bottom: 15px;
        font-size: 24px;
    }
    
    .success-modal p {
        color: var(--dark-wood);
        line-height: 1.6;
        margin-bottom: 25px;
    }
    
    .modal-close-btn {
        background: var(--gold);
        color: white;
        border: none;
        padding: 12px 30px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 4px;
        font-weight: 600;
    }
    
    .modal-close-btn:hover {
        background: var(--dark-wood);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(50px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>