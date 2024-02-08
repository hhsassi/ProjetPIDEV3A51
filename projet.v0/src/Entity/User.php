<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Mime\Message;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Email cannot be blank')]
    #[Assert\Email(message: 'Invalid email format')]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Password cannot be blank')]
    #[Assert\Length(min: 8, max: 8, exactMessage: 'Password must be exactly {{ limit }} characters long')]
    private ?string $password = null;

    #[ORM\Column(length: 8)]
    #[Assert\NotBlank(message: 'Cin cannot be blank')]
    #[Assert\Length(min: 8, max: 8, exactMessage: 'Cin must be exactly {{ limit }} characters long')]
    #[Assert\Type(type: 'string', message: 'Cin must be a string')]
    private ?string $cin = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Nom cannot be blank')]
    #[Assert\Length(min: 2, max: 20, minMessage: 'Nom must be at least {{ limit }} characters long', maxMessage: 'Nom cannot be longer than {{ limit }} characters')]
    #[Assert\Type(type: 'string', message: 'Nom must be a string')]
    private ?string $nom = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Prenom cannot be blank')]
    #[Assert\Length(min: 2, max: 20, minMessage: 'Prenom must be at least {{ limit }} characters long', maxMessage: 'Prenom cannot be longer than {{ limit }} characters')]
    #[Assert\Type(type: 'string', message: 'Prenom must be a string')]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'NumTel cannot be blank')]
    #[Assert\Regex(pattern: '/^\d+$/', message: 'NumTel must contain only numbers')]
    private ?string $numTel = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Adress cannot be blank')]
    private ?string $adress = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Dob cannot be blank')]
    #[Assert\Type(type: '\DateTimeInterface', message: 'Dob must be a valid date')]
    private ?\DateTimeInterface $dob = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): static
    {
        $this->dob = $dob;

        return $this;
    }
}
