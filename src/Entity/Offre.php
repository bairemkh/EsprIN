<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="FK_Provider", columns={"offerProvider"})})
 * @ORM\Entity
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdOffer", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idoffer;

    /**
     * @var string
     *
     * @ORM\Column(name="catOffre", type="string", length=20, nullable=false)
     */
    private $catoffre;

    /**
     * @var string
     *
     * @ORM\Column(name="titleOffer", type="string", length=20, nullable=false)
     */
    private $titleoffer;

    /**
     * @var string
     *
     * @ORM\Column(name="descOffer", type="text", length=65535, nullable=false)
     */
    private $descoffer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imgOffre", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $imgoffre = 'NULL';

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
     *   @ORM\JoinColumn(name="offerProvider", referencedColumnName="cinUser")
     * })
     */
    private $offerprovider;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="idoffer")
     * @ORM\JoinTable(name="intrest",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IdOffer", referencedColumnName="IdOffer")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="cinIntrested", referencedColumnName="cinUser")
     *   }
     * )
     */
    private $cinintrested;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cinintrested = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdoffer(): ?int
    {
        return $this->idoffer;
    }

    public function getCatoffre(): ?string
    {
        return $this->catoffre;
    }

    public function setCatoffre(string $catoffre): self
    {
        $this->catoffre = $catoffre;

        return $this;
    }

    public function getTitleoffer(): ?string
    {
        return $this->titleoffer;
    }

    public function setTitleoffer(string $titleoffer): self
    {
        $this->titleoffer = $titleoffer;

        return $this;
    }

    public function getDescoffer(): ?string
    {
        return $this->descoffer;
    }

    public function setDescoffer(string $descoffer): self
    {
        $this->descoffer = $descoffer;

        return $this;
    }

    public function getImgoffre(): ?string
    {
        return $this->imgoffre;
    }

    public function setImgoffre(?string $imgoffre): self
    {
        $this->imgoffre = $imgoffre;

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

    public function getOfferprovider(): ?User
    {
        return $this->offerprovider;
    }

    public function setOfferprovider(?User $offerprovider): self
    {
        $this->offerprovider = $offerprovider;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getCinintrested(): Collection
    {
        return $this->cinintrested;
    }

    public function addCinintrested(User $cinintrested): self
    {
        if (!$this->cinintrested->contains($cinintrested)) {
            $this->cinintrested[] = $cinintrested;
        }

        return $this;
    }

    public function removeCinintrested(User $cinintrested): self
    {
        $this->cinintrested->removeElement($cinintrested);

        return $this;
    }

}
