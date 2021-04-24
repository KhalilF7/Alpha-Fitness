<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fk_produit_categorie", columns={"idcategorie"})})
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
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Nom obligatoire")
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Prix obligatoire")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="imgproduit", type="string", length=200, nullable=false)
     */
    private $imgproduit;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcategorie", referencedColumnName="id")
     * })
     * @Assert\NotNull(message="Choisissez une Catégorie")
     */
    private $idcategorie;

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
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return float
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getImgproduit(): ?string
    {
        return $this->imgproduit;
    }

    /**
     * @param string $imgproduit
     */
    public function setImgproduit(string $imgproduit): void
    {
        $this->imgproduit = $imgproduit;
    }

    /**
     * @return Categorie
     */
    public function getIdcategorie(): ?Categorie
    {
        return $this->idcategorie;
    }

    /**
     * @param Categorie $idcategorie
     */
    public function setIdcategorie(Categorie $idcategorie): void
    {
        $this->idcategorie = $idcategorie;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

}
