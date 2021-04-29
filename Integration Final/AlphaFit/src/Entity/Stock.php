<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 */
/** @UniqueEntity(
 * fields={"idproduit"},
 * errorPath="idproduit",
 * message="Il semble que vous ayez déjà ajouté ce produit."
 *)
 * Stock
 *
 * @ORM\Table(name="stock", indexes={@ORM\Index(name="fk_stock_produit", columns={"idproduit"})})
 * @ORM\Entity
 */
class Stock
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateentree", type="date", nullable=false)
     * @Assert\NotBlank(message="Choisissez une date")
     */
    private $dateentree;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     * @Assert\NotBlank(message="Quantité obligatoire")
     */
    private $quantite;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="stocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproduit", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="Choisissez un produit")
     */
    private $idproduit;

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
     * @return \DateTime
     */
    public function getDateentree(): ?\DateTime
    {
        return $this->dateentree;
    }

    /**
     * @param \DateTime $dateentree
     */
    public function setDateentree(\DateTime $dateentree): void
    {
        $this->dateentree = $dateentree;
    }

    /**
     * @return int
     */
    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * @return Produit
     */
    public function getIdproduit(): ?Produit
    {
        return $this->idproduit;
    }

    /**
     * @param Produit $idproduit
     */
    public function setIdproduit(Produit $idproduit): void
    {
        $this->idproduit = $idproduit;
    }

    public function __toString(): string
    {
        return $this->idproduit;
    }

}
