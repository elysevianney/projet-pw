<?php

namespace App\Entity;

use App\Repository\PostViewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostViewRepository::class)]
class PostView
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postViews')]
    private ?Post $post = null;

    #[ORM\ManyToOne(inversedBy: 'postViews')]
    private ?User $viewer = null;

    public function __construct(Post $post, User $viewer)
    {
        $this->post = $post;
        $this->viewer = $viewer;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

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
