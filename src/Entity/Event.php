<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={@ORM\Index(name="FK organizer", columns={"idOrganizer"})})
 * @ORM\Entity
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var string
     *
     * @ORM\Column(name="titleEvent", type="string", length=20, nullable=false)
     */
    private $titleevent;

    /**
     * @var string
     *
     * @ORM\Column(name="contentEvent", type="text", length=65535, nullable=false)
     */
    private $contentevent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imgURL", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $imgurl = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="EventLocal", type="string", length=30, nullable=false)
     */
    private $eventlocal;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrParticipant", type="integer", nullable=false)
     */
    private $nbrparticipant = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=false, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=true, options={"default"="NULL"})
     */
    private $datedebut = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true, options={"default"="NULL"})
     */
    private $datefin = 'NULL';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOrganizer", referencedColumnName="cinUser")
     * })
     */
    private $idorganizer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="idevent")
     */
    private $cinuser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cinuser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdevent(): ?int
    {
        return $this->idevent;
    }

    public function getTitleevent(): ?string
    {
        return $this->titleevent;
    }

    public function setTitleevent(string $titleevent): self
    {
        $this->titleevent = $titleevent;

        return $this;
    }

    public function getContentevent(): ?string
    {
        return $this->contentevent;
    }

    public function setContentevent(string $contentevent): self
    {
        $this->contentevent = $contentevent;

        return $this;
    }

    public function getImgurl(): ?string
    {
        return $this->imgurl;
    }

    public function setImgurl(?string $imgurl): self
    {
        $this->imgurl = $imgurl;

        return $this;
    }

    public function getEventlocal(): ?string
    {
        return $this->eventlocal;
    }

    public function setEventlocal(string $eventlocal): self
    {
        $this->eventlocal = $eventlocal;

        return $this;
    }

    public function getNbrparticipant(): ?int
    {
        return $this->nbrparticipant;
    }

    public function setNbrparticipant(int $nbrparticipant): self
    {
        $this->nbrparticipant = $nbrparticipant;

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

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(?\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

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

    public function getIdorganizer(): ?User
    {
        return $this->idorganizer;
    }

    public function setIdorganizer(?User $idorganizer): self
    {
        $this->idorganizer = $idorganizer;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getCinuser(): Collection
    {
        return $this->cinuser;
    }

    public function addCinuser(User $cinuser): self
    {
        if (!$this->cinuser->contains($cinuser)) {
            $this->cinuser[] = $cinuser;
            $cinuser->addIdevent($this);
        }

        return $this;
    }

    public function removeCinuser(User $cinuser): self
    {
        if ($this->cinuser->removeElement($cinuser)) {
            $cinuser->removeIdevent($this);
        }

        return $this;
    }

}
