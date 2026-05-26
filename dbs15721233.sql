-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Hôte : db5020549773.hosting-data.io
-- Généré le : mar. 26 mai 2026 à 21:20
-- Version du serveur : 8.0.36
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbs15721233`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`o15721233`@`%` PROCEDURE `sp_stats_utilisateur` (IN `p_user_id` INT)   BEGIN
    SELECT
        u.name                                             AS nom,
        u.email                                            AS email,
        up.nb_achats                                       AS total_achats,
        up.total_depense                                   AS total_depense,
        COUNT(CASE WHEN pr.type = 'formation' THEN 1 END) AS nb_formations,
        COUNT(CASE WHEN pr.type = 'template'  THEN 1 END) AS nb_templates,
        COUNT(CASE WHEN pr.type = 'service'   THEN 1 END) AS nb_services
    FROM users u
    JOIN user_profiles up ON up.user_id = u.id
    LEFT JOIN purchases p  ON p.user_id  = u.id
    LEFT JOIN products pr  ON pr.id      = p.product_id
    WHERE u.id = p_user_id
    GROUP BY u.id, u.name, u.email, up.nb_achats, up.total_depense;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `product_id` int NOT NULL,
  `niveau` enum('débutant','intermédiaire','avancé') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'débutant',
  `duree_heures` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`product_id`, `niveau`, `duree_heures`) VALUES
(1, 'débutant', 4),
(2, 'avancé', 12),
(3, 'intermédiaire', 8),
(8, 'débutant', 4);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `type` enum('formation','template','service') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `old_price`, `type`, `created_at`) VALUES
(1, 'Formation : Développer votre présence et votre attractivité sur les réseaux sociaux', 'Apprenez à capter l’attention, structurer votre discours et créer des contenus engageants afin de fidéliser votre audience sur les réseaux sociaux. Cette formation vous transmet des méthodes concrètes pour améliorer votre visibilité, renforcer votre image et maximiser l’impact de vos prises de parole en ligne.', '25.99', '50.00', 'formation', '2026-05-26 20:02:54'),
(2, 'Formation : PHP Avancé', 'Maîtrisez PHP et créez des applications professionnelles.', '79.99', '89.99', 'formation', '2026-05-26 20:02:54'),
(3, 'Formation : WIX Avancé', 'Maîtrisez WIX et créez des applications professionnelles facilement.', '59.99', '69.99', 'formation', '2026-05-26 20:02:54'),
(4, 'Template E-commerce WIX', 'Template complet pour concevoir votre premier site web professionnel et poser les bases d’un projet rentable, accessible à distance.', '29.99', '50.00', 'template', '2026-05-26 20:02:54'),
(5, 'Template E-commerce PHP', 'Template complet pour concevoir votre premier site web professionnel et poser les bases d’un projet rentable, accessible à distance.', '49.99', '70.00', 'template', '2026-05-26 20:02:54'),
(6, 'Création de votre boutique e-commerce avec WIX', 'Nous concevons pour vous une boutique e-commerce professionnelle à l’aide de la plateforme WIX, spécialement adaptée à la vente de produits digitaux. La prestation inclut un design soigné, une configuration complète et la mise en ligne du site. Vous obtenez l’ensemble des accès et des droits afin de gérer et faire évoluer votre boutique en toute autonomie. Livraison garantie sous 7 jours maximum.', '100.00', '149.99', 'service', '2026-05-26 20:02:54'),
(7, 'Création de votre boutique e-commerce sur mesure en PHP', 'Nous développons pour vous une boutique e-commerce en PHP, conçue sur mesure pour la vente de produits digitaux. La prestation comprend un design professionnel, une configuration complète et un site prêt à l’emploi. Des explications claires vous sont fournies afin de vous permettre de gérer et de mettre en ligne votre boutique en toute autonomie. Livraison garantie sous 14 jours maximum.', '149.99', '200.00', 'service', '2026-05-26 20:02:54'),
(8, 'Formation : Developper votre presence sur les reseaux sociaux', 'Apprenez a capter l attention, structurer votre discours et creer des contenus engageants afin de fideliser votre audience sur les reseaux sociaux. Cette formation vous transmet des methodes concretes pour ameliorer votre visibilite, renforcer votre image et maximiser l impact de vos prises de parole en ligne.', '25.99', '50.00', 'formation', '2026-05-26 20:17:49');

-- --------------------------------------------------------

--
-- Structure de la table `purchases`
--

CREATE TABLE `purchases` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `purchase_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `product_id`, `purchase_date`, `amount`) VALUES
(1, 1, 4, '2026-05-26 20:03:33', '29.99'),
(2, 1, 4, '2026-05-26 20:09:43', '29.99'),
(3, 2, 8, '2026-05-26 20:37:12', '25.99'),
(4, 2, 4, '2026-05-26 20:37:16', '29.99');

--
-- Déclencheurs `purchases`
--
DELIMITER $$
CREATE TRIGGER `after_purchase_insert` AFTER INSERT ON `purchases` FOR EACH ROW UPDATE user_profiles
SET nb_achats     = nb_achats + 1,
    total_depense = total_depense + NEW.amount
WHERE user_id = NEW.user_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `product_id` int NOT NULL,
  `delai_jours` int NOT NULL DEFAULT '7',
  `inclut_support` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`product_id`, `delai_jours`, `inclut_support`) VALUES
(6, 7, 1),
(7, 14, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_premium` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_premium`, `created_at`) VALUES
(1, 'Rafal', 'rafale60700@gmail.com', '$2y$12$AcbCPNXMcS8QXAx7Pu5JweES7bPydHsF2ZUqEbotLrT2ySrsS9SEC', 0, '2026-05-26 19:53:46'),
(2, 'Rafael Test', 'rafael@test.com', '$2y$10$oJL66TcSQgbxTqdUTX4zPefbsprA0/7Nk455Quya2B4geKo2SMDgC', 0, '2026-05-26 20:17:49');

--
-- Déclencheurs `users`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO user_profiles (user_id, nb_achats, total_depense)
VALUES (NEW.id, 0, 0.00)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_id` int NOT NULL,
  `nb_achats` int DEFAULT '0',
  `total_depense` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_profiles`
--

INSERT INTO `user_profiles` (`user_id`, `nb_achats`, `total_depense`) VALUES
(1, 2, '59.98'),
(2, 2, '55.98');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchase_user` (`user_id`),
  ADD KEY `fk_purchase_product` (`product_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `fk_formation_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `fk_purchase_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_purchase_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_service_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
