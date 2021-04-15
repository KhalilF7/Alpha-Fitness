<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UserName", columns={"UserName"})})
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="UserName", type="string", length=20, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=20, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=20, nullable=false)
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateDeNaissance", type="date", nullable=true, options={"default"="NULL"})
     */
    private $datedenaissance = 'NULL';

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


}
