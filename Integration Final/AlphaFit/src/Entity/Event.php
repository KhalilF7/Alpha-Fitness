<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idEvent;

    /**
     * @Assert\NotBlank
     */
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descritption;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datedebut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomevenement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbplace;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datefin;
    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;

    public function getIdCategorie(): ?Categories
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categories $idCategorie): self
    {
        $this->idCategorie= $idCategorie;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * @param mixed $idEvent
     */
    public function setIdEvent($idEvent): void
    {
        $this->idEvent = $idEvent;
    }

    /**
     * @return mixed
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param mixed $datedebut
     */
    public function setDatedebut($datedebut): void
    {
        $this->datedebut = $datedebut;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescritption(): ?string
    {
        return $this->descritption;
    }

    public function setDescritption(?string $descritption): self
    {
        $this->descritption = $descritption;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNomevenement(): ?string
    {
        return $this->nomevenement;
    }

    public function setNomevenement(?string $nomevenement): self
    {
        $this->nomevenement = $nomevenement;

        return $this;
    }

    public function getNbplace(): ?int
    {
        return $this->nbplace;
    }

    public function setNbplace(?int $nbplace): self
    {
        $this->nbplace = $nbplace;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }
}
