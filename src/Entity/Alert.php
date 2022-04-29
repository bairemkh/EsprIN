<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 *
 * @ORM\Table(name="alert", indexes={@ORM\Index(name="FK sender", columns={"idSender"}), @ORM\Index(name="FK cat alert", columns={"catAlert"})})
 * @ORM\Entity
 */
class Alert
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAlert", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idalert;

    /**
     * @var string
     *
     * @ORM\Column(name="alertTitle", type="string", length=30, nullable=false)
     */
    private $alerttitle;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="destClass", type="string", length=20, nullable=false)
     */
    private $destclass;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $createdat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=false, options={"default"="'Active'"})
     */
    private $state = '\'Active\'';

    /**
     * @var \Catalert
     *
     * @ORM\ManyToOne(targetEntity="Catalert")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="catAlert", referencedColumnName="idCatAlert")
     * })
     */
    private $catalert;

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
