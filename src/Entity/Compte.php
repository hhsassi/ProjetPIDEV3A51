<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteRepository::class)]
class Compte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $rib = null;

    #[ORM\Column(length: 50)]
    private ?string $typeC = null;

    #[ORM\Column]
    private ?float $soldeC = null;

    #[ORM\Column]
    private ?float $fraisC = null;

    #[ORM\OneToMany(mappedBy: 'compte', targetEntity: Transaction::class)]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(string $rib): static
    {
        $this->rib = $rib;

        return $this;
    }

    public function getTypeC(): ?string
    {
        return $this->typeC;
    }

    public function setTypeC(string $typeC): static
    {
        $this->typeC = $typeC;

        return $this;
    }

    public function getSoldeC(): ?float
    {
        return $this->soldeC;
    }

    public function setSoldeC(float $soldeC): static
    {
        $this->soldeC = $soldeC;

        return $this;
    }

    public function getFraisC(): ?float
    {
        return $this->fraisC;
    }

    public function setFraisC(float $fraisC): static
    {
        $this->fraisC = $fraisC;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }
}
