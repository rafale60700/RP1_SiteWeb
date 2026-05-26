<?php
// /models/CatalogueProduits.php
require_once __DIR__ . '/Produit.php';
require_once __DIR__ . '/Formation.php';
require_once __DIR__ . '/Service.php';

class CatalogueProduits {
    /** @var Produit[] */
    private array $produits = [];

    /**
     * Charge tous les produits depuis la BDD (jointure TPT)
     */
    public function charger(PDO $conn): void {
        $this->produits = [];

        // Formations (Table Per Type)
        $stmt = $conn->prepare("
            SELECT p.id, p.name, p.description, p.price, p.old_price,
                   f.niveau, f.duree_heures
            FROM products p
            INNER JOIN formations f ON f.product_id = p.id
            ORDER BY p.price
        ");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->produits[] = new Formation(
                (int)$row['id'],
                $row['name'],
                $row['description'],
                (float)$row['price'],
                (float)$row['old_price'],
                $row['niveau'],
                (int)$row['duree_heures']
            );
        }

        // Services (Table Per Type)
        $stmt = $conn->prepare("
            SELECT p.id, p.name, p.description, p.price, p.old_price,
                   s.delai_jours, s.inclut_support
            FROM products p
            INNER JOIN services s ON s.product_id = p.id
            ORDER BY p.price
        ");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->produits[] = new Service(
                (int)$row['id'],
                $row['name'],
                $row['description'],
                (float)$row['price'],
                (float)$row['old_price'],
                (int)$row['delai_jours'],
                (bool)$row['inclut_support']
            );
        }

        // Templates (produits simples)
        $stmt = $conn->prepare("
            SELECT p.id, p.name, p.description, p.price, p.old_price
            FROM products p
            WHERE p.type = 'template'
            ORDER BY p.price
        ");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->produits[] = new Produit(
                (int)$row['id'],
                $row['name'],
                $row['description'],
                (float)$row['price'],
                (float)$row['old_price'],
                'template'
            );
        }
    }

    /** @return Produit[] */
    public function getParType(string $type): array {
        return array_filter(
            $this->produits,
            fn(Produit $p) => $p->getType() === $type
        );
    }

    public function getParId(int $id): ?Produit {
        foreach ($this->produits as $produit) {
            if ($produit->getId() === $id) {
                return $produit;
            }
        }
        return null;
    }

    /** @return Produit[] */
    public function getTous(): array {
        return $this->produits;
    }
}
