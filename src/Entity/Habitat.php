<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatRepository::class)]
class Habitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $creationDate;

    #[ORM\OneToMany(mappedBy: "habitat", targetEntity: Animal::class, cascade: ["remove"])]
    private Collection $animals;

    #[ORM\OneToMany(mappedBy: "habitat", targetEntity: Access::class, cascade: ["remove"])]
    private Collection $accesses;

    #[ORM\OneToMany(mappedBy: "habitat", targetEntity: ImageHabitat::class, cascade: ["remove"])]
    private Collection $images;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->accesses = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->creationDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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

    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setHabitat($this);
        }
        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            if ($animal->getHabitat() === $this) {
                $animal->setHabitat(null);
            }
        }
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
            $access->setHabitat($this);
        }
        return $this;
    }

    public function removeAccess(Access $access): self
    {
        if ($this->accesses->removeElement($access)) {
            if ($access->getHabitat() === $this) {
                $access->setHabitat(null);
            }
        }
        return $this;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImageHabitat $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setHabitat($this);
        }
        return $this;
    }

    public function removeImage(ImageHabitat $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getHabitat() === $this) {
                $image->setHabitat(null);
            }
        }
        return $this;
    }
}
