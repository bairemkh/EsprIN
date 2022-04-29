<?php

namespace App\Entity;

use App\Repository\ParticipateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participate
 *
 * @ORM\Table(name="participate", indexes={@ORM\Index(name="FK_event", columns={"event"}), @ORM\Index(name="FK_participent", columns={"participent"})})
 * @ORM\Entity(repositoryClass=ParticipateRepository::class)
 */
class Participate
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cinUser", referencedColumnName="cinUser")
     * })
     */
    private $participent;

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEvent", referencedColumnName="idEvent")
     * })
     */
    private $event;



    public function getParticipent(): ?User
    {
        return $this->participent;
    }

    public function setParticipent(User $participent): self
    {
        $this->participent = $participent;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
