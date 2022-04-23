<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={@ORM\Index(name="FK_organizer", columns={"idOrganizer"})})
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

}
