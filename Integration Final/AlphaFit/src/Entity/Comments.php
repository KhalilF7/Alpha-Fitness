<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use TuxOne\ValidationBundle\Validator\Constraints as TuxOneAssert;





/**
 * Comments
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 */
class Comments
{

    /**
     * @var integer
     *
     * @ORM\Column(name="idC", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    //********************************users*************************************//

    /**
     * @ORM\ManyToOne  (targetEntity="User",inversedBy="Comments")
     * @ORM\JoinColumn(name="idCommenter", referencedColumnName="IDUser")
     */
    private $idCommenter;

    /**
     * @return ?User
     */
    public function getIdCommenter(): ?User
    {
        return $this->idCommenter;
    }

    /**
     * @param User $idCommenter
     */
    public function setIdCommenter(User $idCommenter): void
    {
        $this->idCommenter = $idCommenter;
    }



//*********************************************************************************************//








    /**
     *
     * @ORM\ManyToOne(targetEntity="Posts",inversedBy="comments")
     * @ORM\JoinColumn(name="post", referencedColumnName="idp")
     */
    private $post;

    /**
     * @var string
     * @Assert\NotBlank


     * @ORM\Column(name="contenuC", type="string", length=400, nullable=false)
     */
    private $contenuc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateC", type="datetime", nullable=true)
     */
    private $datec;




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
     * Set contenuc
     *
     * @param string $contenuc
     *
     * @return Comments
     */
    public function setContenuc($contenuc)
    {
        $this->contenuc = $contenuc;

        return $this;
    }

    /**
     * Get contenuc
     *
     * @return string
     */
    public function getContenuc()
    {
        return $this->contenuc;
    }

    /**
     * Set datec
     *
     * @param \DateTime $datec
     *
     * @return Comments
     */
    public function setDatec($datec)
    {
        $this->datec = $datec;

        return $this;
    }

    /**
     * Get datec
     *
     * @return \DateTime
     */
    public function getDatec()
    {
        return $this->datec;
    }

   



}
