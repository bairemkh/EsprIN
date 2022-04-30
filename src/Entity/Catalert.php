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

    /**
     * @return int
     */
    public function getIdcatalert(): int
    {
        return $this->idcatalert;
    }

    /**
     * @param int $idcatalert
     */
    public function setIdcatalert(int $idcatalert): void
    {
        $this->idcatalert = $idcatalert;
    }

    /**
     * @return string
     */
    public function getLibcatalert(): string
    {
        return $this->libcatalert;
    }

    /**
     * @param string $libcatalert
     */
    public function setLibcatalert(string $libcatalert): void
    {
        $this->libcatalert = $libcatalert;
    }

    public function __toString()
    {
        return $this->getLibcatalert();
    }


}
