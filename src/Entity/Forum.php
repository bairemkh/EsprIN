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

    public function getIdforum(): ?int
    {
        return $this->idforum;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getCategorieforum(): ?string
    {
        return $this->categorieforum;
    }

    public function setCategorieforum(string $categorieforum): self
    {
        $this->categorieforum = $categorieforum;

        return $this;
    }

    public function getNbrlikesforum(): ?int
    {
        return $this->nbrlikesforum;
    }

    public function setNbrlikesforum(int $nbrlikesforum): self
    {
        $this->nbrlikesforum = $nbrlikesforum;

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

    public function getIdowner(): ?User
    {
        return $this->idowner;
    }

    public function setIdowner(?User $idowner): self
    {
        $this->idowner = $idowner;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdcreater(): Collection
    {
        return $this->idcreater;
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
