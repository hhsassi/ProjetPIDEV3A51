<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomModule = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionModule = null;

    #[ORM\Column]
    private ?int $dureeModule = null;

    #[ORM\ManyToOne(inversedBy: 'Modules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Certification $certification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomModule(): ?string
    {
        return $this->nomModule;
    }

    public function setNomModule(string $nomModule): static
    {
        $this->nomModule = $nomModule;

        return $this;
    }

    public function getDescriptionModule(): ?string
    {
        return $this->descriptionModule;
    }

    public function setDescriptionModule(string $descriptionModule): static
    {
        $this->descriptionModule = $descriptionModule;

        return $this;
    }

    public function getDureeModule(): ?int
    {
        return $this->dureeModule;
    }

    public function setDureeModule(int $dureeModule): static
    {
        $this->dureeModule = $dureeModule;

        return $this;
    }

    public function getCertification(): ?Certification
    {
        return $this->certification;
    }

    public function setCertification(?Certification $certification): static
    {
        $this->certification = $certification;

        return $this;
    }
}
