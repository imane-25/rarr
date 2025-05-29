// Dans votre header.php ou template principal
<?php
$cartCount = 0;
if ($user) {
    $stmt = $pdo->prepare("SELECT SUM(ci.quantity) as total 
                          FROM cart_items ci
                          JOIN carts c ON ci.cart_id = c.id
                          WHERE c.user_id = ? AND c.status = 'active'");
    $stmt->execute([$user['id']]);
    $result = $stmt->fetch();
    $cartCount = $result['total'] ?? 0;
}
?>

<span class="cart-count"><?= $cartCount ?></span>