<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalert
 *
 * @ORM\Table(name="catalert")
 * @ORM\Entity
 */
class Catalert
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCatAlert", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcatalert;

    /**
     * @var string
     *
     * @ORM\Column(name="libCatAlert", type="string", length=30, nullable=false)
     */
    private $libcatalert;


}
