<?php
// /models/Formation.php
require_once __DIR__ . '/Produit.php';

class Formation extends Produit {
    private string $niveau;
    private int    $dureeHeures;

    public function __construct(
        int    $id,
        string $nom,
        string $description,
        float  $prix,
        float  $ancienPrix,
        string $niveau,
        int    $dureeHeures
    ) {
        parent::__construct($id, $nom, $description, $prix, $ancienPrix, 'formation');
        $this->niveau       = $niveau;
        $this->dureeHeures  = $dureeHeures;
    }

    public function getNiveau(): string    { return $this->niveau; }
    public function getDureeHeures(): int  { return $this->dureeHeures; }

    public function afficherDuree(): string {
        return $this->dureeHeures . 'h de contenu';
    }
}
