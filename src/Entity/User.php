<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\HasLifecycleCallbacks()]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const GENDERS = [
        'M' => "Male",
        'F' => "Female",
        'N' => "Neither",
    ];


    // ---------------------
    //  Créé par le make:user
    // ---------------------

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;



    // ---------------------
    //  Ajouté par le make:entity User
    // ---------------------

    #[ORM\Column(length: 40)]
    private ?string $firstname = null;

    #[ORM\Column(length: 40)]
    private ?string $lastname = null;

    #[ORM\Column(length: 81)]
    private ?string $fullname = null;

    #[ORM\Column(length: 43)]
    private ?string $screenname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    // NOTE: convertion en énumération
    // #[ORM\Column(length: 255)]
    #[ORM\Column(type: Types::STRING, columnDefinition: "enum('M','F','N')")]
    private ?string $gender = null;

    // NOTE: fixer la longueur de la colonne
    // #[ORM\Column(length: 2)]
    #[ORM\Column(type: Types::STRING, length: 2, options: ['fixed' => true])]
    private ?string $country = null;

    // NOTE: définition de la valeur par défaut
    #[ORM\Column]
    // private ?int $connectionsCounter = null;
    private int $connectionsCounter = 0;

    #[ORM\Column]
    private ?\DateTimeImmutable $registerAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLoginAt = null;








    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    // NOTE: Automatiosation de la génération du "fullname"
    // public function setFullname(string $fullname): self
    // {
    //     $this->fullname = $fullname;
    //     return $this;
    // }
    #[ORM\PrePersist]
    public function setFullname(): self
    {
        // Concaténation de "firstname lastname" => "John DOE"
        $this->fullname = $this->firstname;               // John
        $this->fullname.= " ";                            // espace
        $this->fullname.= $this->lastname;                // DOE

        return $this;
    }

    public function getScreenname(): ?string
    {
        return $this->screenname;
    }

    // NOTE: Automatiosation de la génération du "screenname"
    // public function setScreenname(string $screenname): self
    // {
    //     $this->screenname = $screenname;
    //     return $this;
    // }

    #[ORM\PrePersist]
    public function setScreenname(): self
    {
        // Concaténation de "firstname lastname" => John D.
        $this->screenname = $this->firstname;               // John
        $this->screenname.= " ";                            // espace
        $this->screenname.= substr($this->lastname, 0, 1);  // D
        $this->screenname.= ".";                            // .

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getConnectionsCounter(): ?int
    {
        return $this->connectionsCounter;
    }

    // NOTE: Automatisation de l'incrémentation
    // public function setConnectionsCounter(int $connectionsCounter): self
    // {
    //     $this->connectionsCounter = $connectionsCounter;
    //     return $this;
    // }
    public function setConnectionsCounter(): self
    {
        // Incrémentation du compteur
        $this->connectionsCounter++;

        return $this;
    }

    public function getRegisterAt(): ?\DateTimeImmutable
    {
        return $this->registerAt;
    }

    // NOTE: Automatisation de l'injection de la donnée
    // public function setRegisterAt(\DateTimeImmutable $registerAt): self
    // {
    //     $this->registerAt = $registerAt;
    //     return $this;
    // }
    #[ORM\PrePersist]
    public function setRegisterAt(): self
    {
        $this->registerAt = new \DateTimeImmutable;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeInterface
    {
        return $this->lastLoginAt;
    }

    // Note: Automatisation de l'injection de la donnée
    //xxx->setLastLoginAt(new \DateTime) 
    // public function setLastLoginAt(?\DateTimeInterface $lastLoginAt): self
    // {
    //     $this->lastLoginAt = $lastLoginAt;
    //     return $this;
    // }

    // xxxx->setLastLoginAt()
    #[ORM\PreUpdate]
    public function setLastLoginAt(): self
    {
        $this->lastLoginAt = new \DateTime;

        return $this;
    }
}
