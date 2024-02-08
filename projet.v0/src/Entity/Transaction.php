<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montantT = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateT = null;

    #[ORM\Column(length: 50)]
    private ?string $ribDest = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantT(): ?float
    {
        return $this->montantT;
    }

    public function setMontantT(float $montantT): static
    {
        $this->montantT = $montantT;

        return $this;
    }

    public function getDateT(): ?\DateTimeInterface
    {
        return $this->dateT;
    }

    public function setDateT(\DateTimeInterface $dateT): static
    {
        $this->dateT = $dateT;

        return $this;
    }

    public function getRibDest(): ?string
    {
        return $this->ribDest;
    }

    public function setRibDest(string $ribDest): static
    {
        $this->ribDest = $ribDest;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): static
    {
        $this->compte = $compte;

        return $this;
    }
}
