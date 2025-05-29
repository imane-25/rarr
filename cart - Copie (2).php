<?php
// Début de session sécurisé
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Inclure la configuration de la base de données
require_once 'config.php';

// Récupérer l'utilisateur connecté
$user = $_SESSION['user'];

// Récupérer le panier depuis la base de données si vous stockez les paniers en DB
// Sinon, utilisez $_SESSION['cart'] comme avant
try {
    $stmt = $pdo->prepare("SELECT * FROM commandes WHERE user_id = ? AND statut = 'panier'");
    $stmt->execute([$user['id']]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Si vous utilisez aussi le panier en session pour une meilleure performance
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
        foreach ($cartItems as $item) {
            // Récupérer les détails du produit
            $productStmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $productStmt->execute([$item['product_id']]);
            $product = $productStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $_SESSION['cart'][$item['product_id']] = [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $item['quantity']
                ];
            }
        }
    }
} catch (PDOException $e) {
    // Gérer l'erreur (peut-être logger et afficher un message d'erreur générique)
    error_log("Erreur de base de données: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier | Artisanat Marocain Beldi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --deep-blue: #1E3A8A;
            --terracotta: #E2725B;
            --ivory: #FFFFF0;
            --dark-wood: #5C4033;
            --light-gray: #f5f5f5;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--ivory);
            color: var(--dark-wood);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: var(--dark-wood);
            font-family: 'Playfair Display', serif;
        }
        
        .cart-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .cart-items {
            flex: 2;
            min-width: 300px;
        }
        
        .cart-summary {
            flex: 1;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 120px;
            height: fit-content;
        }
        
        .cart-item {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
        }
        
        .cart-item:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .cart-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
            align-self: center;
        }
        
        .cart-item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .cart-item-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1em;
            color: var(--deep-blue);
        }
        
        .cart-item-price {
            color: var(--gold);
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        
        .cart-item-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-top: 10px;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--light-gray);
            padding: 5px 10px;
            border-radius: 20px;
        }
        
        .quantity-btn {
            background: var(--gold);
            color: white;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        
        .quantity-btn:hover {
            background: var(--dark-wood);
        }
        
        .quantity {
            min-width: 20px;
            text-align: center;
        }
        
        .remove-btn {
            background: none;
            color: var(--terracotta);
            border: 1px solid var(--terracotta);
            padding: 5px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9em;
        }
        
        .remove-btn:hover {
            background: var(--terracotta);
            color: white;
        }
        
        .summary-title {
            font-size: 1.3em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: var(--dark-wood);
            font-family: 'Playfair Display', serif;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 5px 0;
        }
        
        .total-row {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            color: var(--dark-wood);
        }
        
        .checkout-btn {
            background: var(--gold);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 25px;
            font-size: 1.1em;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .checkout-btn:hover {
            background: var(--dark-wood);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .empty-cart p {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: var(--dark-wood);
        }
        
        .empty-cart a {
            display: inline-block;
            background: var(--gold);
            color: white;
            padding: 12px 25px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: var(--transition);
        }
        
        .empty-cart a:hover {
            background: var(--dark-wood);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .container {
                margin-top: 80px;
            }
            
            .cart-container {
                flex-direction: column;
            }
            
            .cart-summary {
                position: static;
                margin-top: 30px;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .cart-item-actions {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>Votre Panier</h1>
        
        <div class="cart-container">
            <div class="cart-items">
                <?php if (empty($_SESSION['cart'])): ?>
                    <div class="empty-cart">
                        <p>Votre panier est vide</p>
                        <a href="collection.php">Découvrez nos collections</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="cart-item" data-id="<?= htmlspecialchars($item['id']) ?>">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                            <div class="cart-item-details">
                                <div class="cart-item-title"><?= htmlspecialchars($item['title']) ?></div>
                                <div class="cart-item-price"><?= number_format($item['price'], 2) ?> DH</div>
                                <div class="cart-item-actions">
                                    <div class="quantity-selector">
                                        <button class="quantity-btn minus">-</button>
                                        <span class="quantity"><?= htmlspecialchars($item['quantity']) ?></span>
                                        <button class="quantity-btn plus">+</button>
                                    </div>
                                    <button class="remove-btn">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-summary">
                <h3 class="summary-title">Résumé de la commande</h3>
                <?php 
                $subtotal = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                ?>
                <div class="summary-row">
                    <span>Sous-total (<?= count($_SESSION['cart']) ?> article<?= count($_SESSION['cart']) > 1 ? 's' : '' ?>)</span>
                    <span><?= number_format($subtotal, 2) ?> DH</span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span>Gratuite</span>
                </div>
                <div class="summary-row total-row">
                    <span>Total</span>
                    <span><?= number_format($subtotal, 2) ?> DH</span>
                </div>
                <button class="checkout-btn" id="checkoutBtn">Passer la commande</button>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la quantité
            document.querySelectorAll('.quantity-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const item = this.closest('.cart-item');
                    const id = item.getAttribute('data-id');
                    const quantityElement = item.querySelector('.quantity');
                    let quantity = parseInt(quantityElement.textContent);
                    
                    if (this.classList.contains('minus') && quantity > 1) {
                        quantity--;
                    } else if (this.classList.contains('plus')) {
                        quantity++;
                    }
                    
                    quantityElement.textContent = quantity;
                    
                    // Mettre à jour la session via AJAX
                    updateCartItem(id, quantity);
                });
            });
            
            // Gestion de la suppression
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Êtes-vous sûr de vouloir supprimer cet article de votre panier ?')) {
                        const item = this.closest('.cart-item');
                        const id = item.getAttribute('data-id');
                        
                        // Supprimer via AJAX
                        removeCartItem(id, () => {
                            item.remove();
                            updateCartSummary();
                            
                            // Si le panier est vide, recharger la page
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                        });
                    }
                });
            });
            
            // Bouton de commande
            const checkoutBtn = document.getElementById('checkoutBtn');
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', function() {
                    window.location.href = 'checkout.php';
                });
            }
            
            function updateCartItem(id, quantity) {
                fetch('update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id,
                        quantity: quantity
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        updateCartSummary();
                    } else {
                        alert('Erreur lors de la mise à jour du panier: ' + (data.message || 'Erreur inconnue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la mise à jour du panier');
                });
            }
            
            function removeCartItem(id, callback) {
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (callback) callback();
                    } else {
                        alert('Erreur lors de la suppression de l\'article: ' + (data.message || 'Erreur inconnue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la suppression de l\'article');
                });
            }
            
            function updateCartSummary() {
                // Recalculer le total
                let subtotal = 0;
                let itemCount = 0;
                
                document.querySelectorAll('.cart-item').forEach(item => {
                    const priceText = item.querySelector('.cart-item-price').textContent;
                    const price = parseFloat(priceText.replace(/[^\d.]/g, ''));
                    const quantity = parseInt(item.querySelector('.quantity').textContent);
                    subtotal += price * quantity;
                    itemCount += quantity;
                });
                
                // Mettre à jour le résumé
                const summaryRows = document.querySelectorAll('.summary-row');
                if (summaryRows.length > 0) {
                    summaryRows[0].innerHTML = `
                        <span>Sous-total (${itemCount} article${itemCount > 1 ? 's' : ''})</span>
                        <span>${subtotal.toFixed(2)} DH</span>
                    `;
                    
                    if (summaryRows.length > 2) {
                        summaryRows[2].innerHTML = `
                            <span>Total</span>
                            <span>${subtotal.toFixed(2)} DH</span>
                        `;
                    }
                }
                
                // Mettre à jour le compteur du panier dans le header
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(el => {
                    el.textContent = itemCount;
                    el.style.display = itemCount > 0 ? 'flex' : 'none';
                });
            }
        });
    </script>
</body>
</html>