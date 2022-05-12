<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(formats={"json"})
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{

    /**
     * @var int
     * @Groups("posts")
     * @ORM\Column(name="idPost", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpost;

    /**
     * @var string
     * @Groups("posts")
     * @Assert\NotBlank(message="Post Description is required")
     * @Assert\Length(
     *      min = 10,
     *      max = 1000,
     *      minMessage = "la description doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "la description ne peut pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     * @Groups("posts")
     * @ORM\Column(name="mediaURL", type="text", length=65535, nullable=true)
     */
    private $mediaurl;

    /**
     * @var \DateTime
     * @Groups("posts")
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdat ;

    /**
     * @var string
     * @Groups("posts")
     * @ORM\Column(name="categorie", type="string", length=20, nullable=false)
     */
    private $categorie;

    /**
     * @var int
     * @Groups("posts")
     *
     * @ORM\Column(name="likeNum", type="integer", nullable=false)
     */
    private $likenum = '0';

    /**
     * @var string
     * @Groups("posts")
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=false, options={"default"="Active"})
     */
    private $state = 'Active';

    /**
     * @var \User
     * @Groups("posts")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOwer", referencedColumnName="cinUser")
     * })
     */
    private $idower;

    /**
     * @Groups("posts")
     * @ORM\ManyToMany(targetEntity="User", mappedBy="likepost")
     */
    private $likeuser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->likeuser = new ArrayCollection();
    }


    public function getIdpost()
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


    public function getContent()
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


    public function getCategorie()
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


    public function getIdower(): User
    {
        return $this->idower;
    }


    public function setIdower(User $idower)
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
