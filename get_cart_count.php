<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    echo '0';
    exit;
}

$userId = $_SESSION['user']['id'];
$sql = "SELECT SUM(quantity) as total FROM panier WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo $row['total'] ? $row['total'] : '0';
?>