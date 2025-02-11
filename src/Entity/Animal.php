<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $creationDate;

    #[ORM\ManyToOne(targetEntity: AnimalBreed::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?AnimalBreed $breed = null;

    #[ORM\ManyToOne(targetEntity: Habitat::class, inversedBy: "animals")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Habitat $habitat = null;

    #[ORM\OneToMany(mappedBy: "animal", targetEntity: ImageAnimal::class, cascade: ["remove"])]
    private Collection $images;

    #[ORM\OneToOne(mappedBy: "animal", targetEntity: InfoAnimal::class, cascade: ["remove"])]
    private ?InfoAnimal $infoAnimal = null;

    public function __construct()
    {
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

    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function getBreed(): ?AnimalBreed
    {
        return $this->breed;
    }

    public function setBreed(?AnimalBreed $breed): self
    {
        $this->breed = $breed;
        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): self
    {
        $this->habitat = $habitat;
        return $this;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImageAnimal $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnimal($this);
        }
        return $this;
    }

    public function removeImage(ImageAnimal $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getAnimal() === $this) {
                $image->setAnimal(null);
            }
        }
        return $this;
    }

    public function getInfoAnimal(): ?InfoAnimal
    {
        return $this->infoAnimal;
    }

    public function setInfoAnimal(?InfoAnimal $infoAnimal): self
    {
        $this->infoAnimal = $infoAnimal;
        return $this;
    }
}
