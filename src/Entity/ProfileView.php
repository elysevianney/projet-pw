<?php

namespace App\Entity;

use App\Repository\ProfileViewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileViewRepository::class)]
class ProfileView
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'profileViews')]
    private ?User $profileOwner = null;

    #[ORM\ManyToOne(inversedBy: 'profileViews2')]
    private ?User $viewer = null;

    public function __construct(User $profileOwner, User $viewer)
    {
        $this->profileOwner = $profileOwner;
        $this->viewer = $viewer;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfileOwner(): ?User
    {
        return $this->profileOwner;
    }

    public function setProfileOwner(?User $profileOwner): static
    {
        $this->profileOwner = $profileOwner;

        return $this;
    }

    public function getViewer(): ?User
    {
        return $this->viewer;
    }

    public function setViewer(?User $viewer): static
    {
        $this->viewer = $viewer;

        return $this;
    }
}
