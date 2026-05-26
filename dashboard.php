<?php
// dashboard.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/models/CatalogueProduits.php';

requireLogin();

$db   = new Database();
$conn = $db->getConnection();

// Appel de la procédure stockée sp_stats_utilisateur
$stmt = $conn->prepare("CALL sp_stats_utilisateur(?)");
$stmt->execute([getUserId()]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

// Historique des achats
$stmt = $conn->prepare("
    SELECT pr.id, pr.name, pr.type, p.purchase_date, p.amount
    FROM purchases p
    JOIN products pr ON p.product_id = pr.id
    WHERE p.user_id = ?
    ORDER BY p.purchase_date DESC
");
$stmt->execute([getUserId()]);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Catalogue pour attributs spécifiques (niveau, délai…)
$catalogue = new CatalogueProduits();
$catalogue->charger($conn);

// Grouper par type
$parType = ['formation' => [], 'template' => [], 'service' => []];
foreach ($purchases as $purchase) {
    $type = $purchase['type'] ?? 'template';
    if (isset($parType[$type])) {
        $parType[$type][] = $purchase;
    }
}

require_once __DIR__ . '/templates/header.php';
?>

<main class="container">
    <h1>Bienvenue <?= htmlspecialchars(getUserName()) ?> 👋</h1>
    <p>Gérez vos formations, templates et services depuis votre espace personnel.</p>

    <!-- Stats issues de la procédure stockée -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <h3><?= (int)($stats['total_achats'] ?? 0) ?></h3>
            <p>Achats effectués</p>
        </div>
        <div class="stat-card">
            <h3><?= number_format((float)($stats['total_depense'] ?? 0), 2) ?> €</h3>
            <p>Montant total dépensé</p>
        </div>
        <div class="stat-card">
            <h3><?= (int)($stats['nb_formations'] ?? 0) ?></h3>
            <p>Formations actives</p>
        </div>
        <div class="stat-card">
            <h3><?= (int)($stats['nb_templates'] ?? 0) ?></h3>
            <p>Templates téléchargés</p>
        </div>
    </div>

    <?php if (empty($purchases)): ?>
        <div style="text-align:center; margin-top:60px;">
            <p style="font-size:1.2em; color:#666;">Vous n'avez pas encore effectué d'achat.</p>
            <a class="btn" href="/checkout.php" style="margin-top:20px; display:inline-block;">Découvrir nos offres</a>
        </div>
    <?php else: ?>

        <?php if (!empty($parType['formation'])): ?>
            <h2 style="margin-top:50px; color:#667eea;">📚 Mes Formations</h2>
            <ul>
                <?php foreach ($parType['formation'] as $item):
                    $produit = $catalogue->getParId((int)$item['id']);
                ?>
                    <li>
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <?php if ($produit instanceof Formation): ?>
                            &nbsp;<span class="badge-niveau"><?= htmlspecialchars($produit->getNiveau()) ?></span>
                            &nbsp;⏱ <?= htmlspecialchars($produit->afficherDuree()) ?>
                        <?php endif; ?>
                        <br>
                        <small>Acheté le <?= date('d/m/Y', strtotime($item['purchase_date'])) ?>
                            – <?= number_format((float)$item['amount'], 2) ?> €</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($parType['template'])): ?>
            <h2 style="margin-top:50px; color:#667eea;">🎨 Mes Templates</h2>
            <ul>
                <?php foreach ($parType['template'] as $item): ?>
                    <li>
                        <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                        <small>Acheté le <?= date('d/m/Y', strtotime($item['purchase_date'])) ?>
                            – <?= number_format((float)$item['amount'], 2) ?> €</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($parType['service'])): ?>
            <h2 style="margin-top:50px; color:#667eea;">🛠️ Mes Services</h2>
            <ul>
                <?php foreach ($parType['service'] as $item):
                    $produit = $catalogue->getParId((int)$item['id']);
                ?>
                    <li>
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <?php if ($produit instanceof Service): ?>
                            &nbsp;🚚 <?= htmlspecialchars($produit->afficherDelai()) ?>
                        <?php endif; ?>
                        <br>
                        <small>Souscrit le <?= date('d/m/Y', strtotime($item['purchase_date'])) ?>
                            – <?= number_format((float)$item['amount'], 2) ?> €</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
