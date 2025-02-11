<?php

namespace App\Entity;

use App\Repository\InfoAnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoAnimalRepository::class)]
class InfoAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $status;

    #[ORM\Column(length: 255)]
    private string $food;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $weight;

    #[ORM\Column(type: "date")]
    private \DateTime $datePassage;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: "infoAnimals")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Employee $veterinary = null;

    #[ORM\OneToOne(targetEntity: Animal::class, inversedBy: "infoAnimal")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Animal $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getFood(): string
    {
        return $this->food;
    }

    public function setFood(string $food): self
    {
        $this->food = $food;
        return $this;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getDatePassage(): \DateTime
    {
        return $this->datePassage;
    }

    public function setDatePassage(\DateTime $datePassage): self
    {
        $this->datePassage = $datePassage;
        return $this;
    }

    public function getVeterinary(): ?Employee
    {
        return $this->veterinary;
    }

    public function setVeterinary(?Employee $veterinary): self
    {
        $this->veterinary = $veterinary;
        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;
        return $this;
    }
}
