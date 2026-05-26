<?php
// success.php
require_once __DIR__ . '/config/session.php';
requireLogin();
$productName = $_GET['product'] ?? 'votre produit';
require_once __DIR__ . '/templates/header.php';
?>

<main class="container">
    <div style="text-align:center;">
        <div style="font-size:5em; margin-bottom:20px;">✅</div>
        <h1>Paiement confirmé !</h1>
        <p style="font-size:1.2em;">
            Merci pour votre achat de <strong><?= htmlspecialchars($productName) ?></strong>
        </p>
        <p>Votre accès a été activé instantanément.</p>
        <div style="margin-top:40px;">
            <a class="btn" href="/dashboard.php">Accéder à mon espace</a>
            <a class="btn" href="/checkout.php"
               style="background:white; color:#667eea; border:2px solid #667eea; margin-left:15px;">
                Voir d'autres offres
            </a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
