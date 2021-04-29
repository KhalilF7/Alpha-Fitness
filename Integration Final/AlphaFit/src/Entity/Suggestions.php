<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use PhpParser\Node\Scalar\String_;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Suggestion
  *@ORM\Entity
 * @ORM\Table(name="suggestion")
 
 */
class Suggestions
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
     * @Assert\NotBlank(message="Ce champs est obligatoir")
     * @ORM\Column(name="description", type="string", length=500, nullable=false)
     */
    private $description;
    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs est obligatoir")
     * @ORM\Column(name="image", type="string", length=500, nullable=false)
     */
    private $image;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs est obligatoir")
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     * @Assert\GreaterThan("today")

     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \User
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="suggestions")
     * @ORM\JoinColumn(name="participant_id", referencedColumnName="IDUser")
     */
    private $participantId;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="Likes")
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return User
     */
    public function getParticipantId(): ?User
    {
        return $this->participantId;
    }

    /**
     * @param User $participantId
     */
    public function setParticipantId(User $participantId): void
    {
        $this->participantId = $participantId;
    }






    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata->addPropertyConstraint('date', new Assert\GreaterThan('today'));
    }
}
