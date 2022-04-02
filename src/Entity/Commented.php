<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commented
 *
 * @ORM\Table(name="commented", indexes={@ORM\Index(name="Fk post commented", columns={"postCommented"}), @ORM\Index(name="IDX_5FA1A85B35321851", columns={"userWhoCommented"})})
 * @ORM\Entity
 */
class Commented
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="text", length=65535, nullable=false, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userWhoCommented", referencedColumnName="cinUser")
     * })
     */
    private $userwhocommented;

    /**
     * @var \Post
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="postCommented", referencedColumnName="idPost")
     * })
     */
    private $postcommented;

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
    public function getUserwhocommented(): \User
    {
        return $this->userwhocommented;
    }

    /**
     * @param \User $userwhocommented
     */
    public function setUserwhocommented(\User $userwhocommented): void
    {
        $this->userwhocommented = $userwhocommented;
    }

    /**
     * @return \Post
     */
    public function getPostcommented(): \Post
    {
        return $this->postcommented;
    }

    /**
     * @param \Post $postcommented
     */
    public function setPostcommented(\Post $postcommented): void
    {
        $this->postcommented = $postcommented;
    }


}
