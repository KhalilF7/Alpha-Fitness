<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Titre obligatoire")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="imagecat", type="string", length=200, nullable=false)
     */
    private $imagecat;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getImagecat(): ?string
    {
        return $this->imagecat;
    }

    /**
     * @param string $imagecat
     */
    public function setImagecat(string $imagecat): void
    {
        $this->imagecat = $imagecat;
    }

    public function __toString(): string
    {
        return $this->titre;
    }

}
