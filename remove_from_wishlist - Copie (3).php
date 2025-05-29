<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['id'];
    
    if (isset($_SESSION['wishlist'])) {
        foreach ($_SESSION['wishlist'] as $key => $item) {
            if ($item['id'] == $productId) {
                unset($_SESSION['wishlist'][$key]);
                break;
            }
        }
        
        // Réindexer le tableau
        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
    }
    
    echo json_encode(['success' => true]);
}
?>