<?php

namespace App\Entity;

use App\Repository\CompanyCritereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyCritereRepository::class)]
class CompanyCritere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $minimumSalary = null;

    #[ORM\Column(nullable: true)]
    private ?int $maximumSalary = null;

    #[ORM\Column(nullable: true)]
    private ?int $experience = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    /**
     * @var Collection<int, Techno>
     */
    #[ORM\ManyToMany(targetEntity: Techno::class, inversedBy: 'companyCriteres')]
    private Collection $technos;

    #[ORM\OneToOne(inversedBy: 'companyCritere', cascade: ['persist', 'remove'])]
    private ?Company $company = null;

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

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): static
    {
        $this->experience = $experience;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }
}
