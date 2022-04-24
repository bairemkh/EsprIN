<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Responded
 *
 * @ORM\Table(name="responded", indexes={@ORM\Index(name="FK responded", columns={"idForum"}), @ORM\Index(name="IDX_ABE5AFA6222EB8D3", columns={"cinUser"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RespondedRepository")
 */
class Responded
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime

     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var \Forum
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Forum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idForum", referencedColumnName="idForum")
     * })
     */
    private $idforum;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cinUser", referencedColumnName="cinUser")
     * })
     */
    private $cinuser;

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


    public function getIdforum(): ?Forum
    {
        return $this->idforum;
    }


    public function setIdforum(?Forum $idforum): void
    {
        $this->idforum = $idforum;
    }


    public function getCinuser(): ?User
    {
        return $this->cinuser;
    }


    public function setCinuser(?User $cinuser): void
    {
        $this->cinuser = $cinuser;
    }


}
