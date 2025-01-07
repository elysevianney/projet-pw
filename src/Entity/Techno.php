<?php

namespace App\Entity;

use App\Repository\TechnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnoRepository::class)]
class Techno
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
    #[ORM\ManyToMany(targetEntity: Dev::class, mappedBy: 'technos')]
    private Collection $devs;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'technos')]
    private Collection $posts;

    /**
     * @var Collection<int, CompanyCritere>
     */
    #[ORM\ManyToMany(targetEntity: CompanyCritere::class, mappedBy: 'technos')]
    private Collection $companyCriteres;

    public function __construct()
    {
        $this->devs = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->companyCriteres = new ArrayCollection();
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
            $dev->addTechno($this);
        }

        return $this;
    }

    public function removeDev(Dev $dev): static
    {
        if ($this->devs->removeElement($dev)) {
            $dev->removeTechno($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->addTechno($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            $post->removeTechno($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyCritere>
     */
    public function getCompanyCriteres(): Collection
    {
        return $this->companyCriteres;
    }

    public function addCompanyCritere(CompanyCritere $companyCritere): static
    {
        if (!$this->companyCriteres->contains($companyCritere)) {
            $this->companyCriteres->add($companyCritere);
            $companyCritere->addTechno($this);
        }

        return $this;
    }

    public function removeCompanyCritere(CompanyCritere $companyCritere): static
    {
        if ($this->companyCriteres->removeElement($companyCritere)) {
            $companyCritere->removeTechno($this);
        }

        return $this;
    }
}
