<?php

namespace App\Entity;

use App\Repository\AccessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessRepository::class)]
#[ORM\Table(name: "Access")]
class Access
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: "accesses")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Employee $employee = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Habitat::class, inversedBy: "accesses")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Habitat $habitat = null;

    #[ORM\Column(length: 50)]
    private string $accessType;

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;
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

    public function getAccessType(): string
    {
        return $this->accessType;
    }

    public function setAccessType(string $accessType): self
    {
        $this->accessType = $accessType;
        return $this;
    }
}
