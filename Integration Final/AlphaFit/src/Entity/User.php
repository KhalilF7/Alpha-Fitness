<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UserName", columns={"UserName"})}, indexes={@ORM\Index(name="CardName", columns={"CardName"})})
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"username", "password", "email", "role", "datedenaissance"},
 *     message="User existant"
 * )
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDUser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\OneToOne (targetEntity="Carte" , mappedBy="user")
     * @ORM\Column(name="UserName", type="string", length=20, nullable=false)
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z]+([a-zA-Z0-9_]*)$/i",
     *     htmlPattern = "[a-zA-Z]+([a-zA-Z0-9_]*)", message="Le nom de User ne peut pas être que des chiffres"
     * )
     * @Assert\NotBlank(message="Vous devez saisir le Username")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=200, nullable=false)
     *
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Le Mot de passe doit contenir au minimun {{ limit }} characters",
     *      maxMessage = "Le Mot de passe doit contenir au maximum {{ limit }} characters"
     * )
     * @Assert\NotBlank(message="Vous devez écrire password")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=20, nullable=false)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     *@Assert\NotBlank(message="Vous devez saisir votre Email")
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ImageUser", type="string", length=2000, nullable=true, options={"default"="NULL"})
     */
    private $imageuser = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="Role", type="string", length=20, nullable=false)
     */
    private $role;

    /**
     * @var \DateTime
     * @ORM\Column(name="DateDeNaissance", type="date", nullable=true, options={"default"="NULL"})
     *
     */
    private $datedenaissance ;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PasswordOublie", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $passwordoublie = NULL;

    /**
     * @var int
     *
     * @ORM\Column(name="online", type="integer", nullable=false)
     */
    private $online;


    /**
     * @return int
     */
    public function getIduser(): int
    {
        return $this->iduser;
    }

    /**
     * @param int $iduser
     */
    public function setIduser(int $iduser): void
    {
        $this->iduser = $iduser;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getImageuser(): ?string
    {
        return $this->imageuser;
    }

    /**
     * @param string|null $imageuser
     */
    public function setImageuser(?string $imageuser): void
    {
        $this->imageuser = $imageuser;
    }

    /**
     * @return string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return \DateTime
     */
    public function getDatedenaissance() :?\DateTime
    {
        return $this->datedenaissance;
    }

    /**
     * @param \DateTime|null $datedenaissance
     */
    public function setDatedenaissance(?DateTime $datedenaissance): void
    {
        $this->datedenaissance = $datedenaissance;
    }

    /**
     * @return int|null
     */
    public function getPasswordoublie(): ?int
    {
        return $this->passwordoublie;
    }

    /**
     * @param int|null $passwordoublie
     */
    public function setPasswordoublie(?int $passwordoublie): void
    {
        $this->passwordoublie = $passwordoublie;
    }

    /**
     * @return int
     */
    public function getOnline(): ?int
    {
        return $this->online;
    }

    /**
     * @param int $online
     */
    public function setOnline(int $online): void
    {
        $this->online = $online;
    }


    public function __toString(): string
    {
        return $this->getUsername();
    }


    public function getRoles()
    {
        return [$this->role];
    }

    public function setRoles(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * @ORM\ManyToMany(targetEntity=Suggestions::class, mappedBy="likes")
     */
    private $likes;
    /**
     * @ORM\ManyToMany(targetEntity=Suggestions::class, mappedBy="likes")
     */
    private $likesp;

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param mixed $likes
     */
    public function setLikes($likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @return mixed
     */
    public function getLikesp()
    {
        return $this->likesp;
    }

    /**
     * @param mixed $likesp
     */
    public function setLikesp($likesp): void
    {
        $this->likesp = $likesp;
    }
    /**
     * @ORM\OneToMany (targetEntity="Comments",mappedBy="idCommenter")
     * @ORM\JoinColumn(name="comments", referencedColumnName="idC", nullable=true)
     */
    private $Comments;
    /**
     * @ORM\OneToMany(targetEntity="Posts",mappedBy="idPoster")
     * @ORM\JoinColumn(name="posts", referencedColumnName="idp", nullable=true)
     */
    private $post;

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->Comments;
    }

    /**
     * @param mixed $Comments
     */
    public function setComments($Comments): void
    {
        $this->Comments = $Comments;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }
    /**
     * @ORM\OneToMany(targetEntity="PostRating",mappedBy="user")
     * @ORM\JoinColumn(name="rating",referencedColumnName="id")
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity="Suggestions",mappedBy="participantId")
     * @ORM\JoinColumn(name="suggestions", referencedColumnName="id", nullable=true)
     */
    private $suggestions;

    /**
     * @return mixed
     */
    public function getSuggestions()
    {
        return $this->suggestions;
    }

    /**
     * @param mixed $suggestions
     */
    public function setSuggestions($suggestions): void
    {
        $this->suggestions = $suggestions;
    }


}
