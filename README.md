# RP1_VisualStudio
Dépôt RP1 Guichard Rafaël BTS SIO : code source du site web, bases de données SQL, et documentations annexes.

GSB-SHOP
Guide de déploiement et d'utilisation
Projet BTS SIO SLAM — Session 2026 — Guichard Rafaël
Projet
GSB-SHOP — Plateforme de vente de formations et services numériques
Auteur
Guichard Rafaël — N° candidat 2248268444
URL du site
https://rafaelguichard.fr
Hébergeur
IONOS (Hébergement Web Plus)
Dépôt GitHub
https://github.com/rafale60700/RP1_Web


1. Accès au serveur FTP (IONOS)
Le serveur FTP permet de consulter, modifier ou mettre à jour les fichiers du site directement sur le serveur IONOS. Voici comment y accéder étape par étape.

1.1 Logiciel recommandé : FileZilla

1.2 Paramètres de connexion FTP
Ouvrez FileZilla, puis renseignez les informations suivantes dans la barre de connexion rapide en haut :

Hôte (Host) : sftp://access-5019890197.webspace-host.com

Identifiant : su93377

Mot de passe : 12-Soleil&

Port : 3306

Cliquez sur Connexion rapide. Une fois connecté, vous verrez l'arborescence du serveur à droite.

1.3 Structure des fichiers sur le serveur
Les fichiers du site se trouvent dans le dossier :
/
(racine de public_html — le dossier racine du site)

Fichier / Dossier
Rôle
index.php
Page d'accueil du site
checkout.php
Catalogue des produits (formations, templates, services)
dashboard.php
Espace membre — historique des achats
login.php
Page de connexion
register.php
Page d'inscription
process_payment.php
Traitement de l'achat simulé
success.php
Page de confirmation d'achat
mentions-legales.php
Page des mentions légales
config/
Connexion BDD (database.php) et sessions (session.php)
models/
Classes PHP POO : Produit, Formation, Service, CatalogueProduits
templates/
Header et footer communs à toutes les pages
style/
Feuille de style CSS (style.css)
sql/
Scripts SQL de création de la BDD



2. Utilisation du compte de test
Un compte apprenant est disponible pour tester toutes les fonctionnalités du site sans avoir à créer un nouveau compte.

2.1 Identifiants du compte de test

URL du site : https://rafaelguichard.fr

Email : rafael@test.com

Mot de passe : Test1234!

2.2 Parcours de test recommandé
Suivez ces étapes dans l'ordre pour tester l'ensemble des fonctionnalités :

1. Rendez-vous sur https://rafaelguichard.fr et vérifiez que la page d'accueil s'affiche correctement avec les formations et services en vitrine.
2. Cliquez sur « Connexion » dans la barre de navigation et connectez-vous avec les identifiants ci-dessus.
3. Accédez au catalogue via « Nos offres » — vous devez voir 3 formations, 2 templates et 2 services.
4. Cliquez sur « Acheter maintenant » sur n'importe quel produit — l'achat est simulé, aucun paiement réel n'est effectué.
5. Après l'achat, vous êtes redirigé vers la page de confirmation, puis cliquez sur « Mon espace ».
6. Dans le tableau de bord, vérifiez que les statistiques (nombre d'achats, montant total) sont bien mises à jour et que l'historique affiche l'achat effectué.
7. Cliquez sur « Mentions légales » en bas de page pour vérifier la présence des informations légales.
8. Cliquez sur « Déconnexion » pour terminer la session.

2.3 Fonctionnalités disponibles en tant que membre
Consultation du catalogue complet (formations, templates, services)
Achat simulé de n'importe quel produit du catalogue
Accès au tableau de bord avec historique des achats
Statistiques calculées par la procédure stockée SQL : total dépensé, nb formations, templates, services
Déconnexion sécurisée

Le site est un projet pédagogique fictif. Aucun paiement réel n'est débité. Les données saisies restent sur le serveur de démonstration uniquement.

2.4 Créer un nouveau compte
Il est également possible de créer un compte via le formulaire d'inscription :
9. Cliquez sur « Inscription » dans la navigation.
10. Renseignez votre nom, email et un mot de passe (6 caractères minimum).
11. À la validation, un profil est automatiquement créé en base de données (via le trigger after_user_insert).
12. Vous êtes redirigé directement vers votre tableau de bord.

