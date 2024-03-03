<?php

namespace App\Entity;

use App\Repository\RemboursementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RemboursementRepository::class)]
class Remboursement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?float $valeur = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $duree = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?float $valeur_tranche = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 4,
        max: 10,
        minMessage: 'The state must be at least {{ limit }} characters long',
        maxMessage: 'The state cannot be longer than {{ limit }} characters',
    )]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'remboursements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pret $pret = null;

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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getValeurTranche(): ?float
    {
        return $this->valeur_tranche;
    }

    public function setValeurTranche(float $valeur_tranche): static
    {
        $this->valeur_tranche = $valeur_tranche;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPret(): ?Pret
    {
        return $this->pret;
    }

    public function setPret(?Pret $pret): static
    {
        $this->pret = $pret;

        return $this;
    }
}
