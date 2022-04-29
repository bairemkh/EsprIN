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


}
