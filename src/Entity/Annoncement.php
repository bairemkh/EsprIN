<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annoncement
 *
 * @ORM\Table(name="annoncement", indexes={@ORM\Index(name="FK annonce sender", columns={"idSender"})})
 * @ORM\Entity
 *  * @ORM\Entity(repositoryClass="App\Repository\AnnoncementRepository")
 */
class Annoncement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAnn", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idann;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=50, nullable=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=20, nullable=false)
     */
    private $destination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var int
     *
     * @ORM\Column(name="catAnn", type="integer", nullable=false)
     */
    private $catann;

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
     * @return int
     */
    public function getIdann(): int
    {
        return $this->idann;
    }

    /**
     * @param int $idann
     */
    public function setIdann(int $idann): void
    {
        $this->idann = $idann;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
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
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
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
     * @return int
     */
    public function getCatann(): int
    {
        return $this->catann;
    }

    /**
     * @param int $catann
     */
    public function setCatann(int $catann): void
    {
        $this->catann = $catann;
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


    public function getIdsender(): ?User
    {
        return $this->idsender;
    }


    public function setIdsender(?User $idsender): self
    {
        $this->idsender = $idsender;
    }


}
