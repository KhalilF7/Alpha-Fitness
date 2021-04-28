<?php

namespace App\Entity;

use App\Repository\PostRatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRatingRepository::class)
 */
class PostRating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="rating")
     * @ORM\JoinColumn(name="user",referencedColumnName="IDUser")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="Posts",inversedBy="rating")
     * @ORM\JoinColumn(name="post",referencedColumnName="idp")
     */
    private $post;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }
}
