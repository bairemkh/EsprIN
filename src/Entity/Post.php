<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post", indexes={@ORM\Index(name="IDX_5A8A6C8DC6C397F0", columns={"idOwer"})})
 * @ORM\Entity
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPost", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpost;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="mediaURL", type="text", length=65535, nullable=false)
     */
    private $mediaurl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=20, nullable=false)
     */
    private $categorie;

    /**
     * @var int
     *
     * @ORM\Column(name="likeNum", type="integer", nullable=false)
     */
    private $likenum = '0';

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
     *   @ORM\JoinColumn(name="idOwer", referencedColumnName="cinUser")
     * })
     */
    private $idower;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="likepost")
     */
    private $likeuser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->likeuser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdpost(): int
    {
        return $this->idpost;
    }

    /**
     * @param int $idpost
     */
    public function setIdpost(int $idpost): void
    {
        $this->idpost = $idpost;
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
    public function getMediaurl(): string
    {
        return $this->mediaurl;
    }

    /**
     * @param string $mediaurl
     */
    public function setMediaurl(string $mediaurl): void
    {
        $this->mediaurl = $mediaurl;
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
    public function getCategorie(): string
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie(string $categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return int
     */
    public function getLikenum()
    {
        return $this->likenum;
    }

    /**
     * @param int $likenum
     */
    public function setLikenum($likenum): void
    {
        $this->likenum = $likenum;
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
    public function getIdower(): \User
    {
        return $this->idower;
    }

    /**
     * @param \User $idower
     */
    public function setIdower(\User $idower): void
    {
        $this->idower = $idower;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikeuser()
    {
        return $this->likeuser;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $likeuser
     */
    public function setLikeuser($likeuser): void
    {
        $this->likeuser = $likeuser;
    }

}
