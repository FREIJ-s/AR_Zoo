<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $firstname;

    #[ORM\Column(length: 100)]
    private string $lastname;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password;

    #[ORM\Column(length: 50)]
    private string $userprofile;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $creationDate;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $lastConnexion = null;

    #[ORM\OneToMany(mappedBy: "employee", targetEntity: Access::class, cascade: ["remove"])]
    private Collection $accesses;

    #[ORM\OneToMany(mappedBy: "veterinary", targetEntity: InfoAnimal::class, cascade: ["remove"])]
    private Collection $infoAnimals;

    public function __construct()
    {
        $this->accesses = new ArrayCollection();
        $this->infoAnimals = new ArrayCollection();
        $this->creationDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getUserprofile(): string
    {
        return $this->userprofile;
    }

    public function setUserprofile(string $userprofile): self
    {
        $this->userprofile = $userprofile;
        return $this;
    }

    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function getLastConnexion(): ?\DateTime
    {
        return $this->lastConnexion;
    }

    public function setLastConnexion(?\DateTime $lastConnexion): self
    {
        $this->lastConnexion = $lastConnexion;
        return $this;
    }

    public function getAccesses(): Collection
    {
        return $this->accesses;
    }

    public function addAccess(Access $access): self
    {
        if (!$this->accesses->contains($access)) {
            $this->accesses->add($access);
            $access->setEmployee($this);
        }
        return $this;
    }

    public function removeAccess(Access $access): self
    {
        if ($this->accesses->removeElement($access)) {
            if ($access->getEmployee() === $this) {
                $access->setEmployee(null);
            }
        }
        return $this;
    }

    public function getInfoAnimals(): Collection
    {
        return $this->infoAnimals;
    }

    public function addInfoAnimal(InfoAnimal $infoAnimal): self
    {
        if (!$this->infoAnimals->contains($infoAnimal)) {
            $this->infoAnimals->add($infoAnimal);
            $infoAnimal->setVeterinary($this);
        }
        return $this;
    }

    public function removeInfoAnimal(InfoAnimal $infoAnimal): self
    {
        if ($this->infoAnimals->removeElement($infoAnimal)) {
            if ($infoAnimal->getVeterinary() === $this) {
                $infoAnimal->setVeterinary(null);
            }
        }
        return $this;
    }

    // ===========================
    // 🔐 AUTHENTIFICATION SYMFONY
    // ===========================

    public function getRoles(): array
    {
        return [$this->userprofile];
    }

    public function eraseCredentials(): void
    {
        // Effacer les données sensibles si nécessaire
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
