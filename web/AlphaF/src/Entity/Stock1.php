<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock1
 *
 * @ORM\Table(name="stock1", indexes={@ORM\Index(name="fk_produit1_stock1", columns={"idproduit"})})
 * @ORM\Entity
 */
class Stock1
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
     */
    private $dateentree;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var \Produit1
     *
     * @ORM\ManyToOne(targetEntity="Produit1")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproduit", referencedColumnName="id")
     * })
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
    public function getDateentree()
    {
        return $this->dateentree;
    }

    /**
     * @param \DateTime $dateentree
     */
    public function setDateentree(\DateTime $dateentree)
    {
        $this->dateentree = $dateentree;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite(int $quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return \Produit1
     */
    public function getIdproduit()
    {
        return $this->idproduit;
    }

    /**
     * @param \Produit1 $idproduit
     */
    public function setIdproduit(\Produit1 $idproduit)
    {
        $this->idproduit = $idproduit;
    }


}
