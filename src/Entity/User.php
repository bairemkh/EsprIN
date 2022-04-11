<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 * * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="cinUser", type="integer", nullable=false)
     * @ORM\Id
     */
    private $cinuser;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="passwd", type="string", length=50, nullable=false)
     */
    private $passwd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true, options={"default"="current_timestamp()"})
     */
    private $createdat ;

    /**
     * @var string
     *
     * @ORM\Column(name="imgURL", type="text", length=65535, nullable=false, options={"default"="'https://www.jbrhomes.com/wp-content/uploads/blank-avatar.png'"})
     */
    private $imgurl = '\'https://www.jbrhomes.com/wp-content/uploads/blank-avatar.png\'';

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstName", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $firstname = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastName", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $lastname = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="domaine", type="string", length=30, nullable=true, options={"default"="NULL"})
     */
    private $domaine = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="departement", type="string", length=40, nullable=true, options={"default"="NULL"})
     */
    private $departement = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="typeClub", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $typeclub = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="class", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $class = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="localisation", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $localisation = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="entrepriseName", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $entreprisename = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=20, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=false, options={"default"="Connected"})
     */
    private $state = "Connected";

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="cinfollowed")
     */
    private $cinfollower;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Offre", mappedBy="cinintrested")
     */
    private $idoffer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Post", inversedBy="likeuser")
     * @ORM\JoinTable(name="like",
     *   joinColumns={
     *     @ORM\JoinColumn(name="likeUser", referencedColumnName="cinUser")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="likePost", referencedColumnName="idPost")
     *   }
     * )
     */
    private $likepost;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Event", inversedBy="cinuser")
     * @ORM\JoinTable(name="participate",
     *   joinColumns={
     *     @ORM\JoinColumn(name="cinUser", referencedColumnName="cinUser")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idEvent", referencedColumnName="idEvent")
     *   }
     * )
     */
    private $idevent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Forum", inversedBy="idcreater")
     * @ORM\JoinTable(name="reacted forum",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idCreater", referencedColumnName="cinUser")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idForum", referencedColumnName="idForum")
     *   }
     * )
     */
    private $idforum;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cinfollower = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idoffer = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likepost = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idevent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idforum = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getCinuser(): int
    {
        return $this->cinuser;
    }

    /**
     * @param int $cinuser
     */
    public function setCinuser(int $cinuser): void
    {
        $this->cinuser = $cinuser;
    }

    /**
     * @return string
     */
    public function getEmail(): string
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
     * @return string
     */
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     */
    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * @param \DateTime $createdat
     */
    public function setCreatedat($createdat): void
    {
        $this->createdat = $createdat;
    }

    /**
     * @return string
     */
    public function getImgurl(): string
    {
        return $this->imgurl;
    }

    /**
     * @param string $imgurl
     */
    public function setImgurl(string $imgurl): void
    {
        $this->imgurl = $imgurl;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    /**
     * @param string|null $domaine
     */
    public function setDomaine(?string $domaine): void
    {
        $this->domaine = $domaine;
    }

    /**
     * @return string|null
     */
    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    /**
     * @param string|null $departement
     */
    public function setDepartement(?string $departement): void
    {
        $this->departement = $departement;
    }

    /**
     * @return string|null
     */
    public function getTypeclub(): ?string
    {
        return $this->typeclub;
    }

    /**
     * @param string|null $typeclub
     */
    public function setTypeclub(?string $typeclub): void
    {
        $this->typeclub = $typeclub;
    }

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @param string|null $class
     */
    public function setClass(?string $class): void
    {
        $this->class = $class;
    }

    /**
     * @return string|null
     */
    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    /**
     * @param string|null $localisation
     */
    public function setLocalisation(?string $localisation): void
    {
        $this->localisation = $localisation;
    }

    /**
     * @return string|null
     */
    public function getEntreprisename(): ?string
    {
        return $this->entreprisename;
    }

    /**
     * @param string|null $entreprisename
     */
    public function setEntreprisename(?string $entreprisename): void
    {
        $this->entreprisename = $entreprisename;
    }

    /**
     * @return string
     */
    public function getRole(): string
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
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCinfollower()
    {
        return $this->cinfollower;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $cinfollower
     */
    public function setCinfollower($cinfollower): void
    {
        $this->cinfollower = $cinfollower;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdoffer()
    {
        return $this->idoffer;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idoffer
     */
    public function setIdoffer($idoffer): void
    {
        $this->idoffer = $idoffer;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikepost()
    {
        return $this->likepost;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $likepost
     */
    public function setLikepost($likepost): void
    {
        $this->likepost = $likepost;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idevent
     */
    public function setIdevent($idevent): void
    {
        $this->idevent = $idevent;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdforum()
    {
        return $this->idforum;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idforum
     */
    public function setIdforum($idforum): void
    {
        $this->idforum = $idforum;
    }

    public function addCinfollower(User $cinfollower): self
    {
        if (!$this->cinfollower->contains($cinfollower)) {
            $this->cinfollower[] = $cinfollower;
            $cinfollower->addCinfollowed($this);
        }

        return $this;
    }

    public function removeCinfollower(User $cinfollower): self
    {
        if ($this->cinfollower->removeElement($cinfollower)) {
            $cinfollower->removeCinfollowed($this);
        }

        return $this;
    }

    public function addIdoffer(Offre $idoffer): self
    {
        if (!$this->idoffer->contains($idoffer)) {
            $this->idoffer[] = $idoffer;
            $idoffer->addCinintrested($this);
        }

        return $this;
    }

    public function removeIdoffer(Offre $idoffer): self
    {
        if ($this->idoffer->removeElement($idoffer)) {
            $idoffer->removeCinintrested($this);
        }

        return $this;
    }

    public function addLikepost(Post $likepost): self
    {
        if (!$this->likepost->contains($likepost)) {
            $this->likepost[] = $likepost;
        }

        return $this;
    }

    public function removeLikepost(Post $likepost): self
    {
        $this->likepost->removeElement($likepost);

        return $this;
    }

    public function addIdevent(Event $idevent): self
    {
        if (!$this->idevent->contains($idevent)) {
            $this->idevent[] = $idevent;
        }

        return $this;
    }

    public function removeIdevent(Event $idevent): self
    {
        $this->idevent->removeElement($idevent);

        return $this;
    }

    public function addIdforum(Forum $idforum): self
    {
        if (!$this->idforum->contains($idforum)) {
            $this->idforum[] = $idforum;
        }

        return $this;
    }

    public function removeIdforum(Forum $idforum): self
    {
        $this->idforum->removeElement($idforum);

        return $this;
    }
    public function __toString()
    {
        return(String)$this->getFirstname();
    }
}
