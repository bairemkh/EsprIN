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
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="imgURL", type="text", length=65535, nullable=false, options={"default"="147142.png"})
     */
    private $imgurl = '147142.png';

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
     * @ORM\Column(name="state", type="string", length=15, nullable=false, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

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
        $this->idoffer = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likepost = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idevent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idforum = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * @return Collection<int, Offre>
     */
    public function getIdoffer(): Collection
    {
        return $this->idoffer;
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

    /**
     * @return Collection<int, Post>
     */
    public function getLikepost(): Collection
    {
        return $this->likepost;
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

    /**
     * @return Collection<int, Event>
     */
    public function getIdevent(): Collection
    {
        return $this->idevent;
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

    /**
     * @return Collection<int, Forum>
     */
    public function getIdforum(): Collection
    {
        return $this->idforum;
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

}
