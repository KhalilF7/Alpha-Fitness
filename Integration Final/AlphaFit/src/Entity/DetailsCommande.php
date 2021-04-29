<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailsCommande
 *
 * @ORM\Table(name="details_commande", indexes={@ORM\Index(name="fk_idProduit", columns={"idproduit"}), @ORM\Index(name="fk_idCommande", columns={"numc"})})
 * @ORM\Entity
 */
class DetailsCommande
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
     * @var \Stock
     *
     * @ORM\ManyToOne(targetEntity=Stock::class, inversedBy="details_commandes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproduit", referencedColumnName="id")
     * })
     */
    private $idproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="qteproduit", type="integer", nullable=false)
     */
    private $qteproduit;

    /**
     * @var float
     *
     * @ORM\Column(name="prixproduit", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixproduit;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numc", referencedColumnName="idcommande")
     * })
     */
    private $numc;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Stock
     */
    public function getIdproduit(): ?Stock
    {
        return $this->idproduit;
    }

    /**
     * @param Stock $idproduit
     */
    public function setIdproduit(Stock $idproduit): void
    {
        $this->idproduit = $idproduit;
    }



    public function getQteproduit(): ?int
    {
        return $this->qteproduit;
    }

    public function setQteproduit(int $qteproduit): self
    {
        $this->qteproduit = $qteproduit;

        return $this;
    }

    public function getPrixproduit(): ?float
    {
        return $this->prixproduit;
    }

    public function setPrixproduit(float $prixproduit): self
    {
        $this->prixproduit = $prixproduit;

        return $this;
    }

    public function getNumc(): ?Commande
    {
        return $this->numc;
    }

    public function setNumc(?Commande $numc): self
    {
        $this->numc = $numc;

        return $this;
    }

}
