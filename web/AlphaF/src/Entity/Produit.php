<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity
 */
class Produit
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
     * @ORM\Column(name="nom", type="string", length=200, nullable=false)
     * @Assert\NotBlank(message="Nom obligatoire")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=20, nullable=false)
     * @Assert\NotNull(message="Choisissez une Catégorie")
     */
    private $categorie;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Prix obligatoire")
     */
    private $prix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imgproduit", type="string", length=1000, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(message="Image obligatoire")
     */
    private $imgproduit = 'NULL';

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie(string $categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getImgproduit()
    {
        return $this->imgproduit;
    }

    /**
     * @param string $imgproduit
     */
    public function setImgproduit(?string $imgproduit)
    {
        $this->imgproduit = $imgproduit;
    }

    public function __toString(): string
    {
        return $this->nom;
    }


}
