<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 *
 * @ORM\Table(name="alert", indexes={@ORM\Index(name="FK sender", columns={"idSender"}), @ORM\Index(name="FK cat alert", columns={"catAlert"})})
 * @ORM\Entity
 */
class Alert
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAlert", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idalert;

    /**
     * @var string
     *
     * @ORM\Column(name="alertTitle", type="string", length=30, nullable=false)
     */
    private $alerttitle;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="destClass", type="string", length=20, nullable=false)
     */
    private $destclass;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=false, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

    /**
     * @var \Catalert
     *
     * @ORM\ManyToOne(targetEntity="Catalert")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="catAlert", referencedColumnName="idCatAlert")
     * })
     */
    private $catalert;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSender", referencedColumnName="cinUser")
     * })
     */
    private $idsender;

    /**
     * @return int
     */
    public function getIdalert(): int
    {
        return $this->idalert;
    }

    /**
     * @param int $idalert
     */
    public function setIdalert(int $idalert): void
    {
        $this->idalert = $idalert;
    }

    /**
     * @return string
     */
    public function getAlerttitle(): string
    {
        return $this->alerttitle;
    }

    /**
     * @param string $alerttitle
     */
    public function setAlerttitle(string $alerttitle): void
    {
        $this->alerttitle = $alerttitle;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getDestclass(): string
    {
        return $this->destclass;
    }

    /**
     * @param string $destclass
     */
    public function setDestclass(string $destclass): void
    {
        $this->destclass = $destclass;
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
     * @return \Catalert
     */
    public function getCatalert(): \Catalert
    {
        return $this->catalert;
    }

    /**
     * @param \Catalert $catalert
     */
    public function setCatalert(\Catalert $catalert): void
    {
        $this->catalert = $catalert;
    }

    /**
     * @return \User
     */
    public function getIdsender(): \User
    {
        return $this->idsender;
    }

    /**
     * @param \User $idsender
     */
    public function setIdsender(\User $idsender): void
    {
        $this->idsender = $idsender;
    }


}
