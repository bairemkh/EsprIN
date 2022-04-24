<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post", indexes={@ORM\Index(name="FK_Post_owner", columns={"idOwer"})})
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

    public function getIdpost(): ?int
    {
        return $this->idpost;
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

    public function getMediaurl(): ?string
    {
        return $this->mediaurl;
    }

    public function setMediaurl(string $mediaurl): self
    {
        $this->mediaurl = $mediaurl;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getLikenum(): ?int
    {
        return $this->likenum;
    }

    public function setLikenum(int $likenum): self
    {
        $this->likenum = $likenum;

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

    public function getIdower(): ?User
    {
        return $this->idower;
    }

    public function setIdower(?User $idower): self
    {
        $this->idower = $idower;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikeuser(): Collection
    {
        return $this->likeuser;
    }

    public function addLikeuser(User $likeuser): self
    {
        if (!$this->likeuser->contains($likeuser)) {
            $this->likeuser[] = $likeuser;
            $likeuser->addLikepost($this);
        }

        return $this;
    }

    public function removeLikeuser(User $likeuser): self
    {
        if ($this->likeuser->removeElement($likeuser)) {
            $likeuser->removeLikepost($this);
        }

        return $this;
    }

}
