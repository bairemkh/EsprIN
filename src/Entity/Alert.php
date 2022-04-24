<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 *
 * @ORM\Table(name="alert", indexes={@ORM\Index(name="FK sender", columns={"idSender"}), @ORM\Index(name="FK_cat_alert", columns={"catAlert"})})
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSender", referencedColumnName="cinUser")
     * })
     */
    private $idsender;

    /**
     * @var \Catalert
     *
     * @ORM\ManyToOne(targetEntity="Catalert")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="catAlert", referencedColumnName="idCatAlert")
     * })
     */
    private $catalert;

    public function getIdalert(): ?int
    {
        return $this->idalert;
    }

    public function getAlerttitle(): ?string
    {
        return $this->alerttitle;
    }

    public function setAlerttitle(string $alerttitle): self
    {
        $this->alerttitle = $alerttitle;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDestclass(): ?string
    {
        return $this->destclass;
    }

    public function setDestclass(string $destclass): self
    {
        $this->destclass = $destclass;

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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getIdsender(): ?User
    {
        return $this->idsender;
    }

    public function setIdsender(?User $idsender): self
    {
        $this->idsender = $idsender;

        return $this;
    }

    public function getCatalert(): ?Catalert
    {
        return $this->catalert;
    }

    public function setCatalert(?Catalert $catalert): self
    {
        $this->catalert = $catalert;

        return $this;
    }


}
