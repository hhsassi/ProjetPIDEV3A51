<?php

namespace App\Entity;

use App\Repository\EtatsFinancierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatsFinancierRepository::class)]
class EtatsFinancier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $bilanFinancier = null;

    #[ORM\Column(length: 255)]
    private ?string $compteDesResultats = null;

    #[ORM\Column(length: 255)]
    private ?string $tableauDesFlux = null;

    #[ORM\Column(length: 255)]
    private ?string $ratioDeRentabilite = null;

    #[ORM\Column(length: 255)]
    private ?string $ratioEndettement = null;

    #[ORM\ManyToOne(inversedBy: 'etatsFinancier')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBilanFinancier(): ?string
    {
        return $this->bilanFinancier;
    }

    public function setBilanFinancier(string $bilanFinancier): static
    {
        $this->bilanFinancier = $bilanFinancier;

        return $this;
    }

    public function getCompteDesResultats(): ?string
    {
        return $this->compteDesResultats;
    }

    public function setCompteDesResultats(string $compteDesResultats): static
    {
        $this->compteDesResultats = $compteDesResultats;

        return $this;
    }

    public function getTableauDesFlux(): ?string
    {
        return $this->tableauDesFlux;
    }

    public function setTableauDesFlux(string $tableauDesFlux): static
    {
        $this->tableauDesFlux = $tableauDesFlux;

        return $this;
    }

    public function getRatioDeRentabilite(): ?string
    {
        return $this->ratioDeRentabilite;
    }

    public function setRatioDeRentabilite(string $ratioDeRentabilite): static
    {
        $this->ratioDeRentabilite = $ratioDeRentabilite;

        return $this;
    }

    public function getRatioEndettement(): ?string
    {
        return $this->ratioEndettement;
    }

    public function setRatioEndettement(string $ratioEndettement): static
    {
        $this->ratioEndettement = $ratioEndettement;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }
}
