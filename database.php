<?php
// /config/database.php

class Database {
    private $host     = 'db5020549773.hosting-data.io';
    private $db_name  = 'dbs15721233';
    private $username = 'dbu856012';
    private $password = '12-Soleil&';
    private $conn;

    public function getConnection(): ?PDO {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Afficher l'erreur clairement au lieu d'un HTTP 500 muet
            echo "<h2>Erreur de connexion à la base de données</h2>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            exit();
        }
        return $this->conn;
    }
}
