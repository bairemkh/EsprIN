<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeRepository::class)
 * @ORM\Table(name="`likepost`")
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var int
     *
     * @ORM\Column(name="likeUser", type="integer", nullable=false)
     */
    private $likeuser;

    /**
     * @var int
     *
     * @ORM\Column(name="likePost", type="integer", nullable=false)
     */
    private $likepost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikeuser()
    {
        return $this->likeuser;
    }


    public function setLikeuser($likeuser): void
    {
        $this->likeuser = $likeuser;
    }

    public function getLikepost()
    {
        return $this->likepost;
    }

    /**
     */
    public function setLikepost($likepost): void
    {
        $this->likepost = $likepost;
    }
}
