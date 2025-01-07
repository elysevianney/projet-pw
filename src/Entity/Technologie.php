<?php

namespace App\Entity;

use App\Repository\TechnologieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnologieRepository::class)]
class Technologie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Dev>
     */
    #[ORM\ManyToMany(targetEntity: Dev::class, mappedBy: 'technologie')]
    private Collection $devs;


    public function __construct()
    {
        $this->devs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Dev>
     */
    public function getDevs(): Collection
    {
        return $this->devs;
    }

    public function addDev(Dev $dev): static
    {
        if (!$this->devs->contains($dev)) {
            $this->devs->add($dev);
            $dev->addTechonolgy($this);
        }

        return $this;
    }

    public function removeDev(Dev $dev): static
    {
        if ($this->devs->removeElement($dev)) {
            $dev->removeTechonolgy($this);
        }

        return $this;
    }   
}
