<?php
// /models/Produit.php

class Produit {
    protected int    $id;
    protected string $nom;
    protected string $description;
    protected float  $prix;
    protected float  $ancienPrix;
    protected string $type;

    public function __construct(
        int    $id,
        string $nom,
        string $description,
        float  $prix,
        float  $ancienPrix,
        string $type
    ) {
        $this->id          = $id;
        $this->nom         = $nom;
        $this->description = $description;
        $this->prix        = $prix;
        $this->ancienPrix  = $ancienPrix;
        $this->type        = $type;
    }

    public function getId(): int          { return $this->id; }
    public function getNom(): string      { return $this->nom; }
    public function getDescription(): string { return $this->description; }
    public function getPrix(): float      { return $this->prix; }
    public function getAncienPrix(): float { return $this->ancienPrix; }
    public function getType(): string     { return $this->type; }

    public function afficherPrix(): string {
        return number_format($this->prix, 2) . ' €';
    }

    public function afficherAncienPrix(): string {
        return number_format($this->ancienPrix, 2) . ' €';
    }
}
