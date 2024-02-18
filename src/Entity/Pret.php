<?php

namespace App\Entity;

use App\Repository\PretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    /**
     * @var $valeur float|null
     *
     * @Assert\Type(type="float")
     */
    private ?float $valeur = null;

    #[ORM\Column(length: 255)]
    private ?string $motif = null;

    #[ORM\Column(nullable: true)]
    private ?int $salaire = null;

    #[ORM\Column(nullable: true)]
    private ?bool $garantie = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeur_garantie = null;

    #[ORM\OneToMany(mappedBy: 'pret', targetEntity: Remboursement::class, cascade: ['remove'])]
    private Collection $remboursements;

    public function __construct()
    {
        $this->remboursements = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Remboursement>
     */
    public function getRemboursements(): Collection
    {
        return $this->remboursements;
    }

    public function addRemboursement(Remboursement $remboursement): static
    {
        if (!$this->remboursements->contains($remboursement)) {
            $this->remboursements->add($remboursement);
            $remboursement->setPret($this);
        }

        return $this;
    }

    public function removeRemboursement(Remboursement $remboursement): static
    {
        if ($this->remboursements->removeElement($remboursement)) {
            // set the owning side to null (unless already changed)
            if ($remboursement->getPret() === $this) {
                $remboursement->setPret(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->motif; // Ou toute autre propriété que vous souhaitez afficher comme chaîne
    }
}
