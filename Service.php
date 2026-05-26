<?php
// /models/Service.php
require_once __DIR__ . '/Produit.php';

class Service extends Produit {
    private int  $delaiJours;
    private bool $inclutSupport;

    public function __construct(
        int    $id,
        string $nom,
        string $description,
        float  $prix,
        float  $ancienPrix,
        int    $delaiJours,
        bool   $inclutSupport
    ) {
        parent::__construct($id, $nom, $description, $prix, $ancienPrix, 'service');
        $this->delaiJours    = $delaiJours;
        $this->inclutSupport = $inclutSupport;
    }

    public function getDelaiJours(): int      { return $this->delaiJours; }
    public function inclutSupport(): bool     { return $this->inclutSupport; }

    public function afficherDelai(): string {
        return 'Livraison sous ' . $this->delaiJours . ' jours';
    }
}
