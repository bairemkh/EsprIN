<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="FK Provider", columns={"offerProvider"})})
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

    /**
     * @return int
     */
    public function getIdoffer(): int
    {
        return $this->idoffer;
    }

    /**
     * @param int $idoffer
     */
    public function setIdoffer(int $idoffer): void
    {
        $this->idoffer = $idoffer;
    }

    /**
     * @return string
     */
    public function getCatoffre(): string
    {
        return $this->catoffre;
    }

    /**
     * @param string $catoffre
     */
    public function setCatoffre(string $catoffre): void
    {
        $this->catoffre = $catoffre;
    }

    /**
     * @return string
     */
    public function getTitleoffer(): string
    {
        return $this->titleoffer;
    }

    /**
     * @param string $titleoffer
     */
    public function setTitleoffer(string $titleoffer): void
    {
        $this->titleoffer = $titleoffer;
    }

    /**
     * @return string
     */
    public function getDescoffer(): string
    {
        return $this->descoffer;
    }

    /**
     * @param string $descoffer
     */
    public function setDescoffer(string $descoffer): void
    {
        $this->descoffer = $descoffer;
    }

    /**
     * @return string|null
     */
    public function getImgoffre(): ?string
    {
        return $this->imgoffre;
    }

    /**
     * @param string|null $imgoffre
     */
    public function setImgoffre(?string $imgoffre): void
    {
        $this->imgoffre = $imgoffre;
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
     * @return \User
     */
    public function getOfferprovider(): \User
    {
        return $this->offerprovider;
    }

    /**
     * @param \User $offerprovider
     */
    public function setOfferprovider(\User $offerprovider): void
    {
        $this->offerprovider = $offerprovider;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCinintrested()
    {
        return $this->cinintrested;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $cinintrested
     */
    public function setCinintrested($cinintrested): void
    {
        $this->cinintrested = $cinintrested;
    }

}
