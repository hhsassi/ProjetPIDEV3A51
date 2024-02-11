<?php

namespace App\Entity;

use App\Repository\PretRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $valeur = null;

    #[ORM\Column(length: 255)]
    private ?string $motif = null;

    #[ORM\Column(nullable: true)]
    private ?int $salaire = null;

    #[ORM\Column(nullable: true)]
    private ?bool $garantie = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeur_garantie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(?int $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function isGarantie(): ?bool
    {
        return $this->garantie;
    }

    public function setGarantie(?bool $garantie): static
    {
        $this->garantie = $garantie;

        return $this;
    }

    public function getValeurGarantie(): ?float
    {
        return $this->valeur_garantie;
    }

    public function setValeurGarantie(?float $valeur_garantie): static
    {
        $this->valeur_garantie = $valeur_garantie;

        return $this;
    }
}
