<?php
// /public/mentions-legales.php
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/templates/header.php';
?>

<main class="container">
    <h1>Mentions légales</h1>
    <p style="color:#999; font-size:.9em; margin-top:-10px;">Dernière mise à jour : <?= date('d/m/Y') ?></p>

    <div style="background:#fff3cd; border-left:4px solid #ffc107; padding:15px 20px; border-radius:8px; margin: 30px 0;">
        <strong>⚠️ Site fictif</strong> — Ce site est un projet pédagogique réalisé dans le cadre du BTS Services Informatiques aux Organisations (BTS SIO), option SLAM. Il ne constitue en aucun cas une offre commerciale réelle. Aucun paiement n'est effectué et aucun produit ou service n'est réellement livré.
    </div>

    <h2 style="color:#667eea; margin-top:40px;">1. Éditeur du site</h2>
    <p>
        <strong>Nom :</strong> Guichard Rafaël<br>
        <strong>Statut :</strong> Étudiant en BTS SIO option SLAM — Session 2026<br>
        <strong>Établissement :</strong> Lycée Marguerite Jauzelon, Belle-Pierre, La Réunion<br>
        <strong>Projet :</strong> GSB-SHOP — Réalisation Professionnelle n°1 (RP1), Épreuve E6<br>
        <strong>Contact :</strong> disponible via l'établissement scolaire
    </p>

    <h2 style="color:#667eea; margin-top:40px;">2. Hébergement</h2>
    <p>
        Ce site est hébergé par :<br><br>
        <strong>IONOS SE</strong><br>
        Elgendorfer Str. 57<br>
        56410 Montabaur — Allemagne<br>
        Site web : <a href="https://www.ionos.fr" target="_blank" style="color:#667eea;">www.ionos.fr</a><br>
        Téléphone : 0970 808 911
    </p>

    <h2 style="color:#667eea; margin-top:40px;">3. Objet du site</h2>
    <p>
        GSB-SHOP est une plateforme web fictive développée pour le compte du Laboratoire Galaxy Swiss Bourdin (GSB), organisation support utilisée dans le cadre du BTS SIO. Elle simule une boutique en ligne proposant des formations numériques, des templates et des services web.
    </p>
    <p>
        Ce projet a été développé en PHP natif orienté objet, avec une base de données MySQL, dans le but de démontrer les compétences suivantes :
    </p>
    <ul style="margin: 15px 0 15px 30px; line-height:2;">
        <li>Conception et développement d'une solution applicative web</li>
        <li>Architecture PHP orientée objet (héritage, collection, association)</li>
        <li>Modélisation et gestion d'une base de données relationnelle</li>
        <li>Mise en œuvre de triggers et d'une procédure stockée</li>
        <li>Authentification sécurisée et gestion de sessions</li>
    </ul>

    <h2 style="color:#667eea; margin-top:40px;">4. Propriété intellectuelle</h2>
    <p>
        L'ensemble du code source, des maquettes et des contenus présents sur ce site sont des créations originales réalisées à des fins pédagogiques. Toute reproduction à des fins commerciales est interdite sans accord préalable de l'auteur.
    </p>

    <h2 style="color:#667eea; margin-top:40px;">5. Données personnelles</h2>
    <p>
        Les données saisies lors de l'inscription (nom, adresse e-mail, mot de passe hashé) sont stockées uniquement à des fins de démonstration technique. Elles ne sont ni transmises à des tiers ni utilisées à des fins commerciales. Conformément au RGPD, vous pouvez demander la suppression de vos données en contactant l'éditeur.
    </p>

    <h2 style="color:#667eea; margin-top:40px;">6. Responsabilité</h2>
    <p>
        Ce site étant un support pédagogique fictif, l'éditeur ne saurait être tenu responsable de l'utilisation qui en serait faite. Aucune transaction financière réelle n'est possible sur ce site.
    </p>
</main>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
