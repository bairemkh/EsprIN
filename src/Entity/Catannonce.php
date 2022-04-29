<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catannonce
 *
 * @ORM\Table(name="catannonce")
 * @ORM\Entity
 */
class Catannonce
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCatAnn", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcatann;

    /**
     * @var string
     *
     * @ORM\Column(name="libCatAnn", type="string", length=30, nullable=false)
     */
    private $libcatann;


}
