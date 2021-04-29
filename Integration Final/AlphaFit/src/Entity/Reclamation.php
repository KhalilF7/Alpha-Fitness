<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Description obligatoire")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Image obligatoire")
     */
    private $Images;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->Images;
    }

    public function setImages(string $Images): self
    {
        $this->Images = $Images;

        return $this;
    }
}
