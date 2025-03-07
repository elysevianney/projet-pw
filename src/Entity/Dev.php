<?php

namespace App\Entity;

use App\Repository\DevRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevRepository::class)]
class Dev
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column( nullable: true)]
    private ?int $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(nullable: true)]
    private ?int $experience = null;

    #[ORM\Column(nullable: true)]
    private ?int $minimumSalay = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = "dev-profil.jpg";

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

   

    #[ORM\OneToOne(inversedBy: 'dev', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?bool $publicProfile = null;

    /**
     * @var Collection<int, Technologie>
     */
    #[ORM\ManyToMany(targetEntity: Technologie::class, inversedBy: 'devs')]
    private Collection $technologies;

    /**
     * @var Collection<int, Techno>
     */
    #[ORM\ManyToMany(targetEntity: Techno::class, inversedBy: 'devs')]
    private Collection $technos;

    #[ORM\OneToOne(mappedBy: 'dev', cascade: ['persist', 'remove'])]
    private ?DevCritere $devCritere = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = 0.0;

    #[ORM\Column(nullable: true)]
    private ?int $totalRating = 0;

    #[ORM\Column(nullable: true)]
    private ?int $countView = 0;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'devsFav')]
    private Collection $favoritePosts;

    /**
     * @var Collection<int, Company>
     */
    #[ORM\ManyToMany(targetEntity: Company::class, mappedBy: 'favoriteDevs')]
    private Collection $companies;

    

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
        $this->technos = new ArrayCollection();

        $this->rating = 0.0; // Défaut pour les nouvelles instances
        $this->totalRating = 0;

        $this->avatar = "dev-profil.jpg";
        $this->countView = 0;
        $this->favoritePosts = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
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

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getMinimumSalay(): ?int
    {
        return $this->minimumSalay;
    }

    public function setMinimumSalay(?int $minimumSalay): static
    {
        $this->minimumSalay = $minimumSalay;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

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

    public function isPublicProfile(): ?bool
    {
        return $this->publicProfile;
    }

    public function setPublicProfile(?bool $publicProfile): static
    {
        $this->publicProfile = $publicProfile;

        return $this;
    }

    /**
     * @return Collection<int, Technologie>
     */
    public function getTechonolgy(): Collection
    {
        return $this->technologies;
    }

    public function addTechonolgy(Technologie $techonolgie): static
    {
        if (!$this->technologies->contains($techonolgie)) {
            $this->technologies->add($techonolgie);
        }

        return $this;
    }

    public function removeTechonolgy(Technologie $techonolgie): static
    {
        $this->technologies->removeElement($techonolgie);

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

    public function getDevCritere(): ?DevCritere
    {
        return $this->devCritere;
    }

    public function setDevCritere(?DevCritere $devCritere): static
    {
        $this->devCritere = $devCritere;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getTotalRating(): ?int
    {
        return $this->totalRating;
    }

    public function setTotalRating(?int $totalRating): static
    {
        $this->totalRating = $totalRating;

        return $this;
    }

    public function getCountView(): ?int
    {
        return $this->countView;
    }

    public function setCountView(?int $countView): static
    {
        $this->countView = $countView;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getFavoritePosts(): Collection
    {
        return $this->favoritePosts;
    }

    public function addFavoritePost(Post $favoritePost): static
    {
        if (!$this->favoritePosts->contains($favoritePost)) {
            $this->favoritePosts->add($favoritePost);
        }

        return $this;
    }

    public function removeFavoritePost(Post $favoritePost): static
    {
        $this->favoritePosts->removeElement($favoritePost);

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->addFavoriteDev($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        if ($this->companies->removeElement($company)) {
            $company->removeFavoriteDev($this);
        }

        return $this;
    }

    
}
