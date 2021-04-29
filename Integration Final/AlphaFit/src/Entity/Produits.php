<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="produits")
 * @ORM\Entity
 */
class Produits
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
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=20, nullable=false)
     */
    private $categorie;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imgproduit", type="string", length=1000, nullable=true)
     */
    private $imgproduit;

    /**
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="produits")
     * @ORM\Column(nullable=false)
     */
    private $participantId;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="Likesp")
     * @ORM\JoinColumn(onDelete="CASCADE")

     */
    private $likes;



    public function __construct()
    {

        $this->likes = new ArrayCollection();


    }
    public function addLike(User $user): self
    {
        if (!$this->likes->contains($user)) {
            $this->likes[] = $user;
        }

        return $this;
    }


    public function removeLike(User $user): self
    {
        $this->likes->removeElement($user);

        return $this;
    }
    /**
     * @return mixed
     */
    public function getParticipantId():?int
    {
        return $this->participantId;
    }

    /**
     * @param mixed $participantId
     */
    public function setParticipantId(?int $participantId): void
    {
        $this->participantId = $participantId;
    }

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
    public function setId(?int $id): void
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
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie(?string $categorie): void
    {
        $this->categorie = $categorie;
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
    public function setPrix(?float $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return string|null
     */
    public function getImgproduit(): ?string
    {
        return $this->imgproduit;
    }

    /**
     * @param string|null $imgproduit
     */
    public function setImgproduit(?string $imgproduit): void
    {
        $this->imgproduit = $imgproduit;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    /**
     * @param ArrayCollection $likes
     */
    public function setLikes(ArrayCollection $likes): void
    {
        $this->likes = $likes;
    }

}
