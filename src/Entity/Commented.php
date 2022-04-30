<?php

namespace App\Entity;

use App\Repository\CommentedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentedRepository::class)
 */
class Commented
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")

     */
    private $idComment;
    /**
     * @var string
     * @Assert\NotBlank(message="comment is required")
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "la description doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "la description ne peut pas dépasser {{ limit }} caractères")
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdat ;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="text", length=65535, nullable=false, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

    /**
     * @var \User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userWhoCommented", referencedColumnName="cinUser")
     * })
     */
    private $userwhocommented;

    /**
     * @var \Post
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="postCommented", referencedColumnName="idPost")
     * })
     */
    private $postcommented;

    public function getIdComment()
    {
        return $this->idComment;
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
     * @return \DateTime
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * @param \DateTime $createdat
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;
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


    public function getUserwhocommented()
    {
        return $this->userwhocommented;
    }


    public function setUserwhocommented( User $userwhocommented)
    {
        $this->userwhocommented = $userwhocommented;
    }

    /**
     * @return Post
     */
    public function getPostcommented(): Post
    {
        return $this->postcommented;
    }

    /**
     * @param Post $postcommented
     */
    public function setPostcommented(Post $postcommented): void
    {
        $this->postcommented = $postcommented;
    }
}
