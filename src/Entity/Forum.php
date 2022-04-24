<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Forum
 *
 * @ORM\Table(name="forum", indexes={@ORM\Index(name="FK owner", columns={"idOwner"})})
 * @ORM\Entity
 *  * @ORM\Entity(repositoryClass="App\Repository\ForumRepository")
 */
class Forum
{
    /**
     * @var int
     *
     * @ORM\Column(name="idForum", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idforum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $datecreation = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=40, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="categorieForum", type="string", length=20, nullable=false)
     */
    private $categorieforum;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrLikesForum", type="integer", nullable=false)
     */
    private $nbrlikesforum;

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
     *   @ORM\JoinColumn(name="idOwner", referencedColumnName="cinUser")
     * })
     */
    private $idowner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="idforum")
     */
    private $idcreater;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcreater = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdforum(): int
    {
        return $this->idforum;
    }

    /**
     * @param int $idforum
     */
    public function setIdforum(int $idforum): void
    {
        $this->idforum = $idforum;
    }

    /**
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * @param \DateTime $datecreation
     */
    public function setDatecreation($datecreation): void
    {
        $this->datecreation = $datecreation;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
    public function getCategorieforum(): string
    {
        return $this->categorieforum;
    }

    /**
     * @param string $categorieforum
     */
    public function setCategorieforum(string $categorieforum): void
    {
        $this->categorieforum = $categorieforum;
    }

    /**
     * @return int
     */
    public function getNbrlikesforum(): int
    {
        return $this->nbrlikesforum;
    }

    /**
     * @param int $nbrlikesforum
     */
    public function setNbrlikesforum(int $nbrlikesforum): void
    {
        $this->nbrlikesforum = $nbrlikesforum;
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


    public function getIdowner(): ?User
    {
        return $this->idowner;
    }


    public function setIdowner(?User $idowner): void
    {
        $this->idowner = $idowner;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdcreater()
    {
        return $this->idcreater;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idcreater
     */
    public function setIdcreater($idcreater): void
    {
        $this->idcreater = $idcreater;
    }

    public function addIdcreater(User $idcreater): self
    {
        if (!$this->idcreater->contains($idcreater)) {
            $this->idcreater[] = $idcreater;
            $idcreater->addIdforum($this);
        }

        return $this;
    }

    public function removeIdcreater(User $idcreater): self
    {
        if ($this->idcreater->removeElement($idcreater)) {
            $idcreater->removeIdforum($this);
        }

        return $this;
    }

}
