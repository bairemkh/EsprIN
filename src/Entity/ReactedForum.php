<?php

namespace App\Entity;
use App\Repository\ReactedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactedRepository::class)
 * @ORM\Table(name="`reacted forum`")
 */
class ReactedForum
{

    /**
     * @ORM\Id
     * @var int
     * @ORM\Column(name="idCreater", type="integer", nullable=false)
     */
    private $idcreater;

    /**
     * @ORM\Id
     * @var int
     * @ORM\Column(name="idForum", type="integer", nullable=false)
     */
    private $idforum;




    public function getIdcreater()
    {
        return $this->idcreater;
    }


    public function setIdcreater(int $idcreater): void
    {
        $this->idcreater = $idcreater;
    }


    public function getIdforum()
    {
        return $this->idforum;
    }


    public function setIdforum(int $idforum): void
    {
        $this->idforum = $idforum;
    }



}