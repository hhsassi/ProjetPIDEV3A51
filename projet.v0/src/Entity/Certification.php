<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificationRepository::class)]
class Certification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomCertif = null;

    #[ORM\Column]
    private ?int $niveauCertif = null;

    #[ORM\Column]
    private ?int $dureeCertif = null;

    #[ORM\Column(length: 255)]
    private ?string $badgeCertif = null;

    #[ORM\OneToMany(mappedBy: 'certification', targetEntity: Module::class, orphanRemoval: true)]
    private Collection $Modules;

    public function __construct()
    {
        $this->Modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCertif(): ?string
    {
        return $this->nomCertif;
    }

    public function setNomCertif(string $nomCertif): static
    {
        $this->nomCertif = $nomCertif;

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

    public function getDureeCertif(): ?int
    {
        return $this->dureeCertif;
    }

    public function setDureeCertif(int $dureeCertif): static
    {
        $this->dureeCertif = $dureeCertif;

        return $this;
    }

    public function getBadgeCertif(): ?string
    {
        return $this->badgeCertif;
    }

    public function setBadgeCertif(string $badgeCertif): static
    {
        $this->badgeCertif = $badgeCertif;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->Modules;
    }

    public function addModule(Module $module): static
    {
        if (!$this->Modules->contains($module)) {
            $this->Modules->add($module);
            $module->setCertification($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->Modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getCertification() === $this) {
                $module->setCertification(null);
            }
        }

        return $this;
    }
}
