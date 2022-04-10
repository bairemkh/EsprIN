<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Commented
 *
 * @ORM\Entity
 */
class Commented
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     * @Assert\NotBlank(message="comment is required")
     * @Assert\Length(
     *      min = 10,
     *      max = 1000,
     *      minMessage = "la description doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "la description ne peut pas dépasser {{ limit }} caractères"
     * )
     */
    private $content;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idcomment;
    /**
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="text", length=65535, nullable=false, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userWhoCommented", referencedColumnName="cinUser")
     * })
     */
    private $userwhocommented;

    /**
     * @var Post
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="postCommented", referencedColumnName="idPost")
     * })
     */
    private $postcommented;


    public function getContent()
    {
        return $this->content;
    }


    public function setContent(string $content)
    {
        $this->content = $content;
    }


    public function getCreatedat()
    {
        return $this->createdat;
    }


    public function setCreatedat($createdat)
    {
     $this->createdat = $createdat;
    }

    public function getIdcomment()
    {
        return $this->idcomment;
    }


    public function setIdcomment($id)
    {
        $this->idcomment = $id;
    }
    public function getState()
    {
        return $this->state;
    }


    public function setState(string $state)
    {
        $this->state = $state;
    }


    public function getUserwhocommented()
    {
        return $this->userwhocommented;
    }


    public function setUserwhocommented(User $userwhocommented)
    {
        $this->userwhocommented = $userwhocommented;
    }


    public function getPostcommented()
    {
        return $this->postcommented;
    }


    public function setPostcommented( Post $postcommented)
    {
        $this->postcommented = $postcommented;
    }


}
