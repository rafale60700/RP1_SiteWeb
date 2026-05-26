<?php
// process_payment.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/models/CatalogueProduits.php';

requireLogin();

$productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

if (!$productId) {
    header('Location: /checkout.php');
    exit();
}

$db        = new Database();
$conn      = $db->getConnection();
$catalogue = new CatalogueProduits();
$catalogue->charger($conn);
$produit = $catalogue->getParId($productId);

if (!$produit) {
    header('Location: /checkout.php');
    exit();
}

try {
    // Insertion achat – le trigger after_purchase_insert met à jour user_profiles
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, product_id, amount) VALUES (?, ?, ?)");
    $stmt->execute([getUserId(), $produit->getId(), $produit->getPrix()]);

    // Passer en premium si service acheté
    if ($produit->getType() === 'service') {
        $stmt = $conn->prepare("UPDATE users SET is_premium = TRUE WHERE id = ?");
        $stmt->execute([getUserId()]);
    }

    header('Location: /success.php?product=' . urlencode($produit->getNom()));
    exit();
} catch (Exception $e) {
    header('Location: /checkout.php?error=payment_failed');
    exit();
}
