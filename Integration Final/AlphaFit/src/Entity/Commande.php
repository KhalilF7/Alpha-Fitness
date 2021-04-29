<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fk_idclient", columns={"idclient"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcommande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecom", type="date", nullable=false)
     */
    private $datecom;

    /**
     * @var float
     *
     * @ORM\Column(name="montantcom", type="float", precision=10, scale=0, nullable=false)
     */
    private $montantcom;

    /**
     * @var string
     *
     * @ORM\Column(name="etatcom", type="string", length=20, nullable=false)
     */
    private $etatcom;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idclient", referencedColumnName="IDUser")
     * })
     */
    private $idclient;

    public function getIdcommande(): ?int
    {
        return $this->idcommande;
    }

    public function getDatecom(): ?\DateTimeInterface
    {
        return $this->datecom;
    }

    public function setDatecom(\DateTimeInterface $datecom): self
    {
        $this->datecom = $datecom;

        return $this;
    }

    public function getMontantcom(): ?float
    {
        return $this->montantcom;
    }

    public function setMontantcom(float $montantcom): self
    {
        $this->montantcom = $montantcom;

        return $this;
    }

    public function getEtatcom(): ?string
    {
        return $this->etatcom;
    }

    public function setEtatcom(string $etatcom): self
    {
        $this->etatcom = $etatcom;

        return $this;
    }

    public function getIdclient(): ?User
    {
        return $this->idclient;
    }

    public function setIdclient(?User $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    public function __toString(): string
    {
        return $this->idcommande;
    }

}
