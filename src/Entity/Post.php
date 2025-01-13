<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $experience = null;

    #[ORM\Column]
    private ?int $salary = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Techno>
     */
    #[ORM\ManyToMany(targetEntity: Techno::class, inversedBy: 'posts')]
    private Collection $technos;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $relation = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $countView = null;

    /**
     * @var Collection<int, PostView>
     */
    #[ORM\OneToMany(targetEntity: PostView::class, mappedBy: 'post')]
    private Collection $postViews;

    /**
     * @var Collection<int, Dev>
     */
    #[ORM\ManyToMany(targetEntity: Dev::class, mappedBy: 'favoritePosts')]
    private Collection $devsFav;

    public function __construct()
    {
        $this->technos = new ArrayCollection();
        $this->countView = 0 ;
        $this->postViews = new ArrayCollection();
        $this->devsFav = new ArrayCollection(); 
    }
    public function incrementUniqueViews(): void
    {
        $this->countView++;
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

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(?string $relation): static
    {
        $this->relation = $relation;

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
     * @return Collection<int, PostView>
     */
    public function getPostViews(): Collection
    {
        return $this->postViews;
    }

    public function addPostView(PostView $postView): static
    {
        if (!$this->postViews->contains($postView)) {
            $this->postViews->add($postView);
            $postView->setPost($this);
        }

        return $this;
    }

    public function removePostView(PostView $postView): static
    {
        if ($this->postViews->removeElement($postView)) {
            // set the owning side to null (unless already changed)
            if ($postView->getPost() === $this) {
                $postView->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dev>
     */
    public function getDevsFav(): Collection
    {
        return $this->devsFav;
    }

    public function addDevsFav(Dev $devsFav): static
    {
        if (!$this->devsFav->contains($devsFav)) {
            $this->devsFav->add($devsFav);
            $devsFav->addFavoritePost($this);
        }

        return $this;
    }

    public function removeDevsFav(Dev $devsFav): static
    {
        if ($this->devsFav->removeElement($devsFav)) {
            $devsFav->removeFavoritePost($this);
        }

        return $this;
    }
}
