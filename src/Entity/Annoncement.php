<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annoncement
 *
 * @ORM\Table(name="annoncement", indexes={@ORM\Index(name="FK annonce sender", columns={"idSender"})})
 * @ORM\Entity
 */
class Annoncement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAnn", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idann;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=50, nullable=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=20, nullable=false)
     */
    private $destination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var int
     *
     * @ORM\Column(name="catAnn", type="integer", nullable=false)
     */
    private $catann;

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
     *   @ORM\JoinColumn(name="idSender", referencedColumnName="cinUser")
     * })
     */
    private $idsender;


}
