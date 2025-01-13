<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column(nullable: true)]
    private ?int $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = "entreprise-logo.png";

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\OneToOne(inversedBy: 'company', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'company', cascade: ['persist', 'remove'])]
    private ?CompanyCritere $companyCritere = null;

    /**
     * @var Collection<int, Dev>
     */
    #[ORM\ManyToMany(targetEntity: Dev::class, inversedBy: 'companies')]
    private Collection $favoriteDevs;

    public function __construct()
    {
        $this->logo = "entreprise-logo.png";
        $this->favoriteDevs = new ArrayCollection();
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): static
    {
        $this->postalCode = $postalCode;

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCompanyCritere(): ?CompanyCritere
    {
        return $this->companyCritere;
    }

    public function setCompanyCritere(?CompanyCritere $companyCritere): static
    {
        // unset the owning side of the relation if necessary
        if ($companyCritere === null && $this->companyCritere !== null) {
            $this->companyCritere->setCompany(null);
        }

        // set the owning side of the relation if necessary
        if ($companyCritere !== null && $companyCritere->getCompany() !== $this) {
            $companyCritere->setCompany($this);
        }

        $this->companyCritere = $companyCritere;

        return $this;
    }

    /**
     * @return Collection<int, Dev>
     */
    public function getFavoriteDevs(): Collection
    {
        return $this->favoriteDevs;
    }

    public function addFavoriteDev(Dev $favoriteDev): static
    {
        if (!$this->favoriteDevs->contains($favoriteDev)) {
            $this->favoriteDevs->add($favoriteDev);
        }

        return $this;
    }

    public function removeFavoriteDev(Dev $favoriteDev): static
    {
        $this->favoriteDevs->removeElement($favoriteDev);

        return $this;
    }
}
