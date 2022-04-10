<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Post
 *
 * @ORM\Entity
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPost", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpost;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=true)
     * @Assert\NotBlank(message="Description is required")
     * @Assert\Length(
     *      min = 10,
     *      max = 1000,
     *      minMessage = "la description doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "la description ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="mediaURL", type="text", length=65535, nullable=true)
     */
    private $mediaurl;

    /**
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';
    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=20, nullable=true)
     */
    private $categorie;

    /**
     * @var int
     *
     * @ORM\Column(name="likeNum", type="integer", nullable=true)
     */
    private $likenum = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=true, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

    /**
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
    //private $likeuser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->likeuser = new \Doctrine\Common\Collections\ArrayCollection();
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


    public function setContent(string $content)
    {
        $this->content = $content;
    }


    public function getMediaurl()
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


    public function getCreatedat()
    {
        return $this->createdat;
    }


    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;
    }


    public function getCategorie()
    {
        return $this->categorie;
    }


    public function setCategorie(string $categorie)
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


    public function setLikenum($likenum)
    {
        $this->likenum = $likenum;
    }


    public function getState()
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


    public function getIdower()
    {
        return $this->idower;
    }


    public function setIdower( User $idower)
    {
        $this->idower = $idower;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
  /*  public function getLikeuser()
    {
        return $this->likeuser;
    }*/

    /**
     * @param \Doctrine\Common\Collections\Collection $likeuser
     */
    /*public function setLikeuser($likeuser): void
    {
        $this->likeuser = $likeuser;
    }*/

}
