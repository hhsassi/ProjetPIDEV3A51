<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomP = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionP = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateP = null;

    #[ORM\Column]
    private ?float $sommeVoulueP = null;

    #[ORM\Column]
    private ?float $partOfferteP = null;

    #[ORM\Column(length: 50)]
    private ?string $typeP = null;

    #[ORM\Column(length: 20)]
    private ?string $etatP = null;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: EtatsFinancier::class, orphanRemoval: true)]
    private Collection $etatsFinancier;

    public function __construct()
    {
        $this->etatsFinancier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): static
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->descriptionP;
    }

    public function setDescriptionP(string $descriptionP): static
    {
        $this->descriptionP = $descriptionP;

        return $this;
    }

    public function getDateP(): ?\DateTimeInterface
    {
        return $this->dateP;
    }

    public function setDateP(\DateTimeInterface $dateP): static
    {
        $this->dateP = $dateP;

        return $this;
    }

    public function getSommeVoulueP(): ?float
    {
        return $this->sommeVoulueP;
    }

    public function setSommeVoulueP(float $sommeVoulueP): static
    {
        $this->sommeVoulueP = $sommeVoulueP;

        return $this;
    }

    public function getPartOfferteP(): ?float
    {
        return $this->partOfferteP;
    }

    public function setPartOfferteP(float $partOfferteP): static
    {
        $this->partOfferteP = $partOfferteP;

        return $this;
    }

    public function getTypeP(): ?string
    {
        return $this->typeP;
    }

    public function setTypeP(string $typeP): static
    {
        $this->typeP = $typeP;

        return $this;
    }

    public function getEtatP(): ?string
    {
        return $this->etatP;
    }

    public function setEtatP(string $etatP): static
    {
        $this->etatP = $etatP;

        return $this;
    }

    /**
     * @return Collection<int, EtatsFinancier>
     */
    public function getEtatsFinancier(): Collection
    {
        return $this->etatsFinancier;
    }

    public function addEtatsFinancier(EtatsFinancier $etatsFinancier): static
    {
        if (!$this->etatsFinancier->contains($etatsFinancier)) {
            $this->etatsFinancier->add($etatsFinancier);
            $etatsFinancier->setProjet($this);
        }

        return $this;
    }

    public function removeEtatsFinancier(EtatsFinancier $etatsFinancier): static
    {
        if ($this->etatsFinancier->removeElement($etatsFinancier)) {
            // set the owning side to null (unless already changed)
            if ($etatsFinancier->getProjet() === $this) {
                $etatsFinancier->setProjet(null);
            }
        }

        return $this;
    }
}
