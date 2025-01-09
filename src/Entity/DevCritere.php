<?php

namespace App\Entity;

use App\Repository\DevCritereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevCritereRepository::class)]
class DevCritere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $minimumSalary = null;

    #[ORM\Column(nullable: true)]
    private ?int $maximumSalary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(nullable: true)]
    private ?int $experience = null;

    /**
     * @var Collection<int, Techno>
     */
    #[ORM\ManyToMany(targetEntity: Techno::class, inversedBy: 'devCriteres')]
    private Collection $technos;

    #[ORM\OneToOne(inversedBy: 'devCritere', cascade: ['persist', 'remove'])]
    private ?Dev $dev = null;

   

    

    public function __construct()
    {
        $this->technos = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinimumSalary(): ?int
    {
        return $this->minimumSalary;
    }

    public function setMinimumSalary(?int $minimumSalary): static
    {
        $this->minimumSalary = $minimumSalary;

        return $this;
    }

    public function getMaximumSalary(): ?int
    {
        return $this->maximumSalary;
    }

    public function setMaximumSalary(?int $maximumSalary): static
    {
        $this->maximumSalary = $maximumSalary;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return Collection<int, Techno>
     */
    public function getTechnos(): Collection
    {
        return $this->technos;
    }

    public function addTechno(Techno $techno): static
    {
        if (!$this->technos->contains($techno)) {
            $this->technos->add($techno);
        }

        return $this;
    }

    public function removeTechno(Techno $techno): static
    {
        $this->technos->removeElement($techno);

        return $this;
    }

    public function getDev(): ?Dev
    {
        return $this->dev;
    }

    public function setDev(?Dev $dev): static
    {
        $this->dev = $dev;

        return $this;
    }

    

}
