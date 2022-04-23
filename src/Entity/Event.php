<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={@ORM\Index(name="FK_organizer", columns={"idOrganizer"})})
 * @ORM\Entity
 * * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
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
    private $imgurl = NULL;

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
    private $state = 'Active';

    /**
     * @var ?DateTime
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=true, options={"default"="NULL"})
     */
    private $datedebut = null;

    /**
     * @var ?DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true, options={"default"="NULL"})
     */
    private $datefin = null ;

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

    /**
     * @return int
     */
    public function getIdevent(): int
    {
        return $this->idevent;
    }

    /**
     * @param int $idevent
     */
    public function setIdevent(int $idevent): void
    {
        $this->idevent = $idevent;
    }

    /**
     * @return string
     */
    public function getTitleevent(): string
    {
        return $this->titleevent;
    }

    /**
     * @param string $titleevent
     */
    public function setTitleevent(string $titleevent): void
    {
        $this->titleevent = $titleevent;
    }

    /**
     * @return string
     */
    public function getContentevent(): string
    {
        return $this->contentevent;
    }

    /**
     * @param string $contentevent
     */
    public function setContentevent(string $contentevent): void
    {
        $this->contentevent = $contentevent;
    }

    /**
     * @return string|null
     */
    public function getImgurl()
    {
        return $this->imgurl;
    }

    /**
     * @param string|null $imgurl
     */
    public function setImgurl(?string $imgurl)
    {
        $this->imgurl = $imgurl;
    }

    /**
     * @return string
     */
    public function getEventlocal(): string
    {
        return $this->eventlocal;
    }

    /**
     * @param string $eventlocal
     */
    public function setEventlocal(string $eventlocal): void
    {
        $this->eventlocal = $eventlocal;
    }

    /**
     * @return int
     */
    public function getNbrparticipant()
    {
        return $this->nbrparticipant;
    }

    /**
     * @param int $nbrparticipant
     */
    public function setNbrparticipant($nbrparticipant): void
    {
        $this->nbrparticipant = $nbrparticipant;
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
     * @return \DateTime|null
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param \DateTime|null $datedebut
     */
    public function setDatedebut($datedebut): void
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return \DateTime|null
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param \DateTime|null $datefin
     */
    public function setDatefin($datefin): void
    {
        $this->datefin = $datefin;
    }


    public function getIdorganizer(): ?User
    {
        return $this->idorganizer;
    }


    public function setIdorganizer(?User $idorganizer): void
    {
        $this->idorganizer = $idorganizer;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCinuser()
    {
        return $this->cinuser;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $cinuser
     */
    public function setCinuser($cinuser): void
    {
        $this->cinuser = $cinuser;
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
