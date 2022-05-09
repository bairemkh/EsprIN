<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 * @ApiResource(formats={"json"})
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="cinUser", type="integer", nullable=false)
     * @ORM\Id
     * @Groups("users")
     */
    private $cinuser;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @Groups("users")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="passwd", type="text", length=65535, nullable=false)
     * @Groups("users")
     */
    private $passwd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @Groups("users")
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="imgURL", type="text", length=65535, nullable=false, options={"default"="147142.png"})
     * @Groups("users")
     */
    private $imgurl = '147142.png';

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstName", type="string", length=20, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $firstname = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastName", type="string", length=20, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $lastname = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="domaine", type="string", length=30, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $domaine = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="departement", type="string", length=40, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $departement = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="typeClub", type="string", length=20, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $typeclub = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="class", type="string", length=20, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $class = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="localisation", type="string", length=20, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $localisation = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="entrepriseName", type="string", length=20, nullable=true, options={"default"="NULL"})
     * @Groups("users")
     */
    private $entreprisename = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=20, nullable=false)
     * @Groups("users")
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=false, options={"default"="Active"})
     */
    private $state = 'Active';



    public function getCinuser(): ?int
    {
        return $this->cinuser;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setCinuser(int $UserCin): self
    {
        $this->cinuser = $UserCin;

        return $this;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getImgurl(): ?string
    {
        return $this->imgurl;
    }

    public function setImgurl(string $imgurl): self
    {
        $this->imgurl = $imgurl;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(?string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(?string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getTypeclub(): ?string
    {
        return $this->typeclub;
    }

    public function setTypeclub(?string $typeclub): self
    {
        $this->typeclub = $typeclub;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getEntreprisename(): ?string
    {
        return $this->entreprisename;
    }

    public function setEntreprisename(?string $entreprisename): self
    {
        $this->entreprisename = $entreprisename;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }





    public function getRoles()
    {
        // TODO: Implement getRoles() method.

        return array($this->role);
    }

    public function getPassword()
    {
        return $this->passwd;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return (string)$this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __toString()
    {
        return(String)$this->getFirstname();
    }


}
