<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Dev $dev = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Company $company = null;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'user')]
    private Collection $posts;

    /**
     * @var Collection<int, ProfileView>
     */
    #[ORM\OneToMany(targetEntity: ProfileView::class, mappedBy: 'profileOwner')]
    private Collection $profileViews;

    /**
     * @var Collection<int, ProfileView>
     */
    #[ORM\OneToMany(targetEntity: ProfileView::class, mappedBy: 'viewer')]
    private Collection $profileViews2;

    /**
     * @var Collection<int, PostView>
     */
    #[ORM\OneToMany(targetEntity: PostView::class, mappedBy: 'viewer')]
    private Collection $postViews;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->profileViews = new ArrayCollection();
        $this->profileViews2 = new ArrayCollection();
        $this->postViews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDev(): ?Dev
    {
        return $this->dev;
    }

    public function setDev(?Dev $dev): static
    {
        // unset the owning side of the relation if necessary
        if ($dev === null && $this->dev !== null) {
            $this->dev->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($dev !== null && $dev->getUser() !== $this) {
            $dev->setUser($this);
        }

        $this->dev = $dev;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        // unset the owning side of the relation if necessary
        if ($company === null && $this->company !== null) {
            $this->company->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($company !== null && $company->getUser() !== $this) {
            $company->setUser($this);
        }

        $this->company = $company;

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
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProfileView>
     */
    public function getProfileViews(): Collection
    {
        return $this->profileViews;
    }

    public function addProfileView(ProfileView $profileView): static
    {
        if (!$this->profileViews->contains($profileView)) {
            $this->profileViews->add($profileView);
            $profileView->setProfileOwner($this);
        }

        return $this;
    }

    public function removeProfileView(ProfileView $profileView): static
    {
        if ($this->profileViews->removeElement($profileView)) {
            // set the owning side to null (unless already changed)
            if ($profileView->getProfileOwner() === $this) {
                $profileView->setProfileOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProfileView>
     */
    public function getProfileViews2(): Collection
    {
        return $this->profileViews2;
    }

    public function addProfileViews2(ProfileView $profileViews2): static
    {
        if (!$this->profileViews2->contains($profileViews2)) {
            $this->profileViews2->add($profileViews2);
            $profileViews2->setViewer($this);
        }

        return $this;
    }

    public function removeProfileViews2(ProfileView $profileViews2): static
    {
        if ($this->profileViews2->removeElement($profileViews2)) {
            // set the owning side to null (unless already changed)
            if ($profileViews2->getViewer() === $this) {
                $profileViews2->setViewer(null);
            }
        }

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
            $postView->setViewer($this);
        }

        return $this;
    }

    public function removePostView(PostView $postView): static
    {
        if ($this->postViews->removeElement($postView)) {
            // set the owning side to null (unless already changed)
            if ($postView->getViewer() === $this) {
                $postView->setViewer(null);
            }
        }

        return $this;
    }
}
