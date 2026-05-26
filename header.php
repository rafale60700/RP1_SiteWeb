<?php
// /templates/header.php
require_once __DIR__ . '/../config/session.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB-SHOP – Formations & Services Numériques</title>
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>

<header>
    <nav class="container">
        <div class="logo">🚀 GSB-SHOP</div>
        <div class="nav-links">
            <a href="/index.php">Accueil</a>
            <a href="/checkout.php">Nos offres</a>
            <?php if (isLoggedIn()): ?>
                <a href="/dashboard.php">Mon espace</a>
                <a href="/logout.php">Déconnexion (<?= htmlspecialchars(getUserName()) ?>)</a>
            <?php else: ?>
                <a href="/login.php">Connexion</a>
                <a href="/register.php">Inscription</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
