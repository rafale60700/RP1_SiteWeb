-- ============================================================
-- GSB-SHOP – Procédure stockée
-- À importer SÉPARÉMENT dans phpMyAdmin après create_tables.sql
-- ============================================================

USE dbs15721233;

DROP PROCEDURE IF EXISTS sp_stats_utilisateur;

DELIMITER $$
CREATE PROCEDURE sp_stats_utilisateur(IN p_user_id INT)
BEGIN
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
