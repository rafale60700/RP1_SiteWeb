<?php
// index.php
require_once __DIR__ . '/templates/header.php';
?>

<main class="container">
    <div style="text-align: center;">
        <h1 style="font-size: 3em; margin-bottom: 15px;">Transformez votre Business 🚀</h1>
        <p style="font-size: 1.3em; margin-bottom: 40px;">
            Formations professionnelles, templates premium et services numériques
            pour entrepreneurs ambitieux – par GSB
        </p>
        <a class="btn" href="/checkout.php" style="font-size: 1.1em; padding: 18px 40px;">
            Découvrir nos offres
        </a>
    </div>

    <div class="cards" style="margin-top: 80px;">
        <div class="card">
            <div style="font-size: 3em; margin-bottom: 15px;">📚</div>
            <h3>Formations Expert</h3>
            <p>Maîtrisez les technologies modernes avec nos formations complètes et pratiques. Du débutant à l'expert.</p>
        </div>
        <div class="card">
            <div style="font-size: 3em; margin-bottom: 15px;">🎨</div>
            <h3>Templates Premium</h3>
            <p>Gagnez du temps avec nos templates professionnels prêts à l'emploi. Code propre et personnalisable.</p>
        </div>
        <div class="card">
            <div style="font-size: 3em; margin-bottom: 15px;">🛠️</div>
            <h3>Service Dédié</h3>
            <p>Création sur mesure de votre boutique en ligne, conçue pour développer une activité rentable.</p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 80px; padding: 60px 40px;
                background: linear-gradient(135deg, rgba(102,126,234,.1) 0%, rgba(118,75,162,.1) 100%);
                border-radius: 15px;">
        <h2 style="font-size: 2.2em; margin-bottom: 20px;">Prêt à commencer ?</h2>
        <p style="font-size: 1.2em; margin-bottom: 30px;">
            Rejoignez nos membres et accédez à nos ressources exclusives
        </p>
        <?php if (isLoggedIn()): ?>
            <a class="btn" href="/dashboard.php" style="font-size: 1.1em;">Accéder à mon espace</a>
        <?php else: ?>
            <a class="btn" href="/register.php" style="font-size: 1.1em; margin-right: 15px;">Créer un compte gratuit</a>
            <a class="btn" href="/login.php"
               style="background: white; color: #667eea; border: 2px solid #667eea;">Se connecter</a>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 80px;">
        <h2 style="font-size: 2em; margin-bottom: 10px;">Ils témoignent de leur réussite</h2>
    </div>
    <div class="cards" style="margin-top: 40px;">
        <div class="card">
            <h3>Léandro L.</h3>
            <p>« Parti de presque rien, j'ai aujourd'hui réussi à compléter mes revenus chaque mois. »</p>
        </div>
        <div class="card">
            <h3>Marie T.</h3>
            <p>« La formation PHP m'a permis de créer mon premier site en moins de deux semaines. Je recommande à 100 %. »</p>
        </div>
        <div class="card">
            <h3>Kevin R.</h3>
            <p>« Le service de création de boutique est top, livré en 6 jours et exactement ce que je voulais. »</p>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
