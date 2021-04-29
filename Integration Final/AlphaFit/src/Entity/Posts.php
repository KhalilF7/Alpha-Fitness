<?php

namespace App\Entity;

use App\Repository\PostsRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Posts
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass=PostsRepository::class)
 */
class Posts
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="idp",type="integer",length=255,nullable=true)
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(name="contenuP",type="string", length=255, nullable=true)
     */
    private $contenup;


    /**
     * @var string
     * @Assert\Image()
     * @ORM\Column(name="imgpost", type="string", length=255, nullable=true)
     */
    private $imgpost;




 /**
     * @ORM\Column(name="nbcmt",type="integer", nullable=true)
     */
    private $nbcmt = 'NULL';

    /**
     * @var integer
     * @ORM\Column(name="views", type="integer", nullable=true)
     */
    private $views= 'NULL';

    /**
     * @var integer
     * @ORM\Column(name="likes",type="integer", nullable=true)
     */
    private $likes= 'NULL';

    /**
     * @var integer
     * @ORM\Column(name="report",type="integer", nullable=true)
     */
    private $report= 'NULL';


    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateP", type="datetime", nullable=true)
     */
    private $dateP;
    /**
     * @ORM\OneToMany(targetEntity="PostRating",mappedBy="post")
     * @ORM\JoinColumn(name="rating",referencedColumnName="id")
     */
    private $rating;

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating): void
    {
        $this->rating = $rating;
    }


//*****************************************user****************************//

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="users")
     * @ORM\JoinColumn(name="idPoster", referencedColumnName="IDUser")
     */
    private $idPoster;





    /**
     * @return ?User
     */
    public function getIdPoster(): ?User
    {
        return $this->idPoster;
    }

    /**
     * @param User $idPoster
     */
    public function setIdPoster(User $idPoster): void
    {
        $this->idPoster = $idPoster;
    }




//*****************************************************************************************//


    /**
     * @ORM\OneToMany(targetEntity="Comments",mappedBy="Post")
     * @ORM\JoinColumn(name="comments", referencedColumnName="idC")
     */
    private $comments;

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }


    /**
     * Set contenup
     *
     * @param string $contenup
     *
     * @return Posts
     */
    public function setContenup($contenup)
    {
        $this->contenup = $contenup;

        return $this;
    }

    /**
     * Get contenup
     *
     * @return string
     */
    public function getContenup()
    {
        return $this->contenup;
    }

    /**
     * Set nbcmt
     *
     * @param integer $nbcmt
     *
     * @return Posts
     */
    public function setNbcmt($nbcmt)
    {
        $this->nbcmt = $nbcmt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateP()
    {
        return $this->dateP;
    }

    /**
     * @param \DateTime $dateP
     */
    public function setDateP(\DateTime $dateP)
    {
        $this->dateP = $dateP;
    }

    /**
     * Get nbcmt
     *
     * @return integer
     */
    public function getNbcmt()
    {
        return $this->nbcmt;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Posts
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Posts
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set report
     *
     * @param integer $report
     *
     * @return Posts
     */
    public function setReport($report)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return integer
     */
    public function getReport()
    {
        return $this->report;
    }



    /**
     * @return string
     */
    public function getImgpost()
    {
        return $this->imgpost;
    }

    /**
     * @param string $imgpost
     */
    public function setImgpost(string $imgpost): void
    {
        $this->imgpost = $imgpost;
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
    public function setId(int $id): void
    {
        $this->id = $id;
    }




    //**************RATING**********////////////





}
