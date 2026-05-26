-- ============================================================
-- GSB-SHOP – Structure BDD complète
-- MySQL 8.0 | BDD : dbs15721233
-- Import via phpMyAdmin : Importer > choisir ce fichier > Exécuter
-- ============================================================

USE dbs15721233;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS purchases;
DROP TABLE IF EXISTS formations;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS user_profiles;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- ---- Tables ----

CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) UNIQUE NOT NULL,
    password   VARCHAR(255) NOT NULL,
    is_premium BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_profiles (
    user_id       INT PRIMARY KEY,
    nb_achats     INT DEFAULT 0,
    total_depense DECIMAL(10,2) DEFAULT 0.00,
    CONSTRAINT fk_profile_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(200) NOT NULL,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL,
    old_price   DECIMAL(10,2) DEFAULT NULL,
    type        ENUM('formation','template','service') NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE formations (
    product_id   INT PRIMARY KEY,
    niveau       ENUM('debutant','intermediaire','avance') NOT NULL DEFAULT 'debutant',
    duree_heures INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_formation_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE services (
    product_id     INT PRIMARY KEY,
    delai_jours    INT NOT NULL DEFAULT 7,
    inclut_support TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_service_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE purchases (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT NOT NULL,
    product_id    INT NOT NULL,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    amount        DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_purchase_user    FOREIGN KEY (user_id)    REFERENCES users(id),
    CONSTRAINT fk_purchase_product FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ---- Trigger 1 : crée user_profiles automatiquement à l'inscription ----
DROP TRIGGER IF EXISTS after_user_insert;

CREATE TRIGGER after_user_insert
AFTER INSERT ON users
FOR EACH ROW
INSERT INTO user_profiles (user_id, nb_achats, total_depense) VALUES (NEW.id, 0, 0.00);

-- ---- Trigger 2 : met à jour les stats après chaque achat ----
DROP TRIGGER IF EXISTS after_purchase_insert;

CREATE TRIGGER after_purchase_insert
AFTER INSERT ON purchases
FOR EACH ROW
UPDATE user_profiles SET nb_achats = nb_achats + 1, total_depense = total_depense + NEW.amount WHERE user_id = NEW.user_id;


-- ---- Données produits ----

INSERT INTO products (name, description, price, old_price, type) VALUES
('Formation : Reseaux sociaux et visibilite', 'Apprenez a capter l attention, structurer votre discours et creer des contenus engageants pour fidéliser votre audience sur les réseaux sociaux.', 25.99, 50.00, 'formation'),
('Formation : PHP Avance', 'Maîtrisez PHP orienté objet et créez des applications web professionnelles.', 79.99, 89.99, 'formation'),
('Formation : WIX Avance', 'Créez des sites professionnels facilement grâce à WIX sans coder.', 59.99, 69.99, 'formation');

INSERT INTO formations (product_id, niveau, duree_heures)
SELECT id, 'debutant', 4 FROM products WHERE name LIKE '%Reseaux sociaux%';
INSERT INTO formations (product_id, niveau, duree_heures)
SELECT id, 'avance', 12 FROM products WHERE name LIKE '%PHP Avance%';
INSERT INTO formations (product_id, niveau, duree_heures)
SELECT id, 'intermediaire', 8 FROM products WHERE name LIKE '%WIX Avance%';

INSERT INTO products (name, description, price, old_price, type) VALUES
('Template E-commerce WIX', 'Template complet pour concevoir votre premier site web professionnel et poser les bases d un projet rentable.', 29.99, 50.00, 'template'),
('Template E-commerce PHP', 'Template PHP complet avec panier, pages produits et gestion des commandes.', 49.99, 70.00, 'template');

INSERT INTO products (name, description, price, old_price, type) VALUES
('Creation boutique e-commerce WIX', 'Nous concevons pour vous une boutique e-commerce professionnelle avec WIX. Design soigne, configuration complete. Livraison sous 7 jours.', 100.00, 149.99, 'service'),
('Creation boutique e-commerce PHP sur mesure', 'Nous developpons pour vous une boutique e-commerce PHP sur mesure. Design professionnel, configuration complete. Livraison sous 14 jours.', 149.99, 200.00, 'service');

INSERT INTO services (product_id, delai_jours, inclut_support)
SELECT id, 7, 1 FROM products WHERE name LIKE '%WIX%' AND type = 'service';
INSERT INTO services (product_id, delai_jours, inclut_support)
SELECT id, 14, 1 FROM products WHERE name LIKE '%PHP sur mesure%';

-- ---- Utilisateur de test ----
-- Email : rafael@test.com  |  Mot de passe : Test1234!
INSERT INTO users (name, email, password, is_premium) VALUES
('Rafael Test', 'rafael@test.com', '$2y$10$oJL66TcSQgbxTqdUTX4zPefbsprA0/7Nk455Quya2B4geKo2SMDgC', 0);

