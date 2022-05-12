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

    /**
     * @return int
     */
    public function getIdcatann(): int
    {
        return $this->idcatann;
    }

    /**
     * @param int $idcatann
     */
    public function setIdcatann(int $idcatann): void
    {
        $this->idcatann = $idcatann;
    }

    /**
     * @return string
     */
    public function getLibcatann(): string
    {
        return $this->libcatann;
    }

    /**
     * @param string $libcatann
     */
    public function setLibcatann(string $libcatann): void
    {
        $this->libcatann = $libcatann;
    }

    public function __toString()
    {
        return (string) $this->getIdcatann();
    }

}
