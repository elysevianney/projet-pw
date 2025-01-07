<?php

namespace App\Entity;

use App\Repository\DevTechnologyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevTechnologyRepository::class)]
class DevTechnology
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Dev>
     */
    #[ORM\ManyToMany(targetEntity: Dev::class, inversedBy: 'technology')]
    private Collection $dev;

    /**
     * @var Collection<int, Technology>
     */
    #[ORM\ManyToMany(targetEntity: Technologie::class, inversedBy: 'devs')]
    private Collection $technology;

    public function __construct()
    {
        $this->dev = new ArrayCollection();
        $this->technology = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Dev>
     */
    public function getDev(): Collection
    {
        return $this->dev;
    }

    public function addDev(Dev $dev): static
    {
        if (!$this->dev->contains($dev)) {
            $this->dev->add($dev);
        }

        return $this;
    }

    public function removeDev(Dev $dev): static
    {
        $this->dev->removeElement($dev);

        return $this;
    }

    /**
     * @return Collection<int, Technology>
     */
    public function getTechnology(): Collection
    {
        return $this->technology;
    }

    public function addTechnology(Technologie $technology): static
    {
        if (!$this->technology->contains($technology)) {
            $this->technology->add($technology);
        }

        return $this;
    }

    public function removeTechnology(Technologie $technology): static
    {
        $this->technology->removeElement($technology);

        return $this;
    }
}
