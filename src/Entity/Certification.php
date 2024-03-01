<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CertificationRepository::class)]
class Certification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The name of the certification cannot be blank.")]
    private ?string $nomCertif = null;

    #[ORM\Column(length: 255)]
    
    private ?string $badgeCertif = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The description of the certification cannot be blank.")]
    private ?string $descriotionCertif = null;

    #[ORM\Column]
    private ?int $dureeCertif = null;

    #[ORM\Column]
    private ?int $niveauCertif = null;

    #[ORM\OneToMany(mappedBy: 'certification', targetEntity: Cours::class , cascade: ['remove'])]
    private Collection $cours;

    #[ORM\OneToMany(mappedBy: 'certification', targetEntity: InscriptionCertif::class)]
    private Collection $inscriptionCertifs;

    public function __construct()
    {
        $this->inscriptionCertifs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCertif(): ?string
    {
        return $this->nomCertif;
    }

    public function setNomCertif(?string $nomCertif): static
    {
        $this->nomCertif = $nomCertif;

        return $this;
    }

    public function getBadgeCertif(): ?string
    {
        return $this->badgeCertif;
    }

    public function setBadgeCertif(?string $badgeCertif): static
    {
        $this->badgeCertif = $badgeCertif;

        return $this;
    }

    public function getDescriotionCertif(): ?string
    {
        return $this->descriotionCertif;
    }

    public function setDescriotionCertif(?string $descriotionCertif): static
    {
        $this->descriotionCertif = $descriotionCertif;

        return $this;
    }

    public function getDureeCertif(): ?int
    {
        return $this->dureeCertif;
    }

    public function setDureeCertif(int $dureeCertif): static
    {
        $this->dureeCertif = $dureeCertif;

        return $this;
    }

    public function getNiveauCertif(): ?int
    {
        return $this->niveauCertif;
    }

    public function setNiveauCertif(int $niveauCertif): static
    {
        $this->niveauCertif = $niveauCertif;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setCertification($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getCertification() === $this) {
                $cour->setCertification(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InscriptionCertif>
     */
    public function getInscriptionCertifs(): Collection
    {
        return $this->inscriptionCertifs;
    }

    public function addInscriptionCertif(InscriptionCertif $inscriptionCertif): static
    {
        if (!$this->inscriptionCertifs->contains($inscriptionCertif)) {
            $this->inscriptionCertifs->add($inscriptionCertif);
            $inscriptionCertif->setCertification($this);
        }

        return $this;
    }

    public function removeInscriptionCertif(InscriptionCertif $inscriptionCertif): static
    {
        if ($this->inscriptionCertifs->removeElement($inscriptionCertif)) {
            // set the owning side to null (unless already changed)
            if ($inscriptionCertif->getCertification() === $this) {
                $inscriptionCertif->setCertification(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        // Choisissez la propriété qui représente le mieux cet objet, par exemple :
        return $this->nomCertif;
    }
    
}
