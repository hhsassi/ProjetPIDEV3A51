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
    #[Assert\Image(
        maxSize: '1024k',
        mimeTypes: ['image/png', 'image/jpeg'],
        mimeTypesMessage: 'Please upload a valid PNG or JPG image.',
        maxSizeMessage: 'The image cannot be larger than 1MB.'
    )]
    private ?string $badgeCertif = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The description of the certification cannot be blank.")]
    private ?string $descriotionCertif = null;

    #[ORM\Column]
    private ?int $dureeCertif = null;

    #[ORM\Column]
    private ?int $niveauCertif = null;

    #[ORM\OneToMany(mappedBy: 'certification', targetEntity: Cours::class)]
    private Collection $cours;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
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
}
