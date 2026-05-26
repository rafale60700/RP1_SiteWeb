<?php
// checkout.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/models/CatalogueProduits.php';

$formations = [];
$templates  = [];
$services   = [];
$erreurBDD  = '';

try {
    $db        = new Database();
    $conn      = $db->getConnection();
    $catalogue = new CatalogueProduits();
    $catalogue->charger($conn);
    $formations = $catalogue->getParType('formation');
    $templates  = $catalogue->getParType('template');
    $services   = $catalogue->getParType('service');
} catch (Exception $e) {
    $erreurBDD = $e->getMessage();
}

require_once __DIR__ . '/templates/header.php';
?>

<main class="container">
    <h1>Nos Offres</h1>
    <p>Découvrez nos formations, templates et services pour booster votre business.</p>

    <?php if ($erreurBDD): ?>
        <div class="alert alert-error">Erreur BDD : <?= htmlspecialchars($erreurBDD) ?></div>
    <?php endif; ?>

    <?php if (!isLoggedIn()): ?>
        <div class="alert alert-error">
            Vous devez être connecté pour effectuer un achat.
            <a href="/login.php" style="color:#721c24;font-weight:600;text-decoration:underline;">Se connecter</a>
        </div>
    <?php endif; ?>

    <!-- FORMATIONS -->
    <h2 style="margin-top:40px;color:#667eea;">📚 Formations</h2>
    <div class="cards">
        <?php if (empty($formations)): ?>
            <p style="color:#999;">Aucune formation disponible pour le moment.</p>
        <?php endif; ?>
        <?php foreach ($formations as $produit): /** @var Formation $produit */ ?>
            <div class="card">
                <h3><?= htmlspecialchars($produit->getNom()) ?></h3>
                <p><?= htmlspecialchars($produit->getDescription()) ?></p>
                <p style="margin-bottom:8px;">
                    <span class="badge-niveau">📊 <?= htmlspecialchars($produit->getNiveau()) ?></span>
                    &nbsp;⏱ <?= htmlspecialchars($produit->afficherDuree()) ?>
                </p>
                <p style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:1.5em;font-weight:bold;color:#667eea;"><?= $produit->afficherPrix() ?></span>
                    <?php if ($produit->getAncienPrix() > 0): ?>
                        <span style="text-decoration:line-through;color:#999;font-size:1.1em;"><?= $produit->afficherAncienPrix() ?></span>
                    <?php endif; ?>
                </p>
                <a class="btn" href="/process_payment.php?product_id=<?= $produit->getId() ?>">Acheter maintenant</a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- TEMPLATES -->
    <h2 style="margin-top:40px;color:#667eea;">🎨 Templates</h2>
    <div class="cards">
        <?php if (empty($templates)): ?>
            <p style="color:#999;">Aucun template disponible pour le moment.</p>
        <?php endif; ?>
        <?php foreach ($templates as $produit): /** @var Produit $produit */ ?>
            <div class="card">
                <h3><?= htmlspecialchars($produit->getNom()) ?></h3>
                <p><?= htmlspecialchars($produit->getDescription()) ?></p>
                <p style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:1.5em;font-weight:bold;color:#667eea;"><?= $produit->afficherPrix() ?></span>
                    <?php if ($produit->getAncienPrix() > 0): ?>
                        <span style="text-decoration:line-through;color:#999;font-size:1.1em;"><?= $produit->afficherAncienPrix() ?></span>
                    <?php endif; ?>
                </p>
                <a class="btn" href="/process_payment.php?product_id=<?= $produit->getId() ?>">Télécharger</a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- SERVICES -->
    <h2 style="margin-top:40px;color:#667eea;">🛠️ Services</h2>
    <div class="cards">
        <?php if (empty($services)): ?>
            <p style="color:#999;">Aucun service disponible pour le moment.</p>
        <?php endif; ?>
        <?php foreach ($services as $produit): /** @var Service $produit */ ?>
            <div class="card">
                <h3><?= htmlspecialchars($produit->getNom()) ?></h3>
                <p><?= htmlspecialchars($produit->getDescription()) ?></p>
                <p style="margin-bottom:8px;">
                    🚚 <?= htmlspecialchars($produit->afficherDelai()) ?>
                    &nbsp;<?= $produit->inclutSupport() ? '✅ Support inclus' : '' ?>
                </p>
                <p style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:1.5em;font-weight:bold;color:#667eea;"><?= $produit->afficherPrix() ?></span>
                    <?php if ($produit->getAncienPrix() > 0): ?>
                        <span style="text-decoration:line-through;color:#999;font-size:1.1em;"><?= $produit->afficherAncienPrix() ?></span>
                    <?php endif; ?>
                </p>
                <a class="btn" href="/process_payment.php?product_id=<?= $produit->getId() ?>">Souscrire</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
