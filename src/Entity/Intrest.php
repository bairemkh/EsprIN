<?php

namespace App\Entity;

use App\Repository\IntrestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntrestRepository::class)
 */
class Intrest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $intrested;

    /**
     * @ORM\Column(type="integer")
     */
    private $intresting_offer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntrested(): ?int
    {
        return $this->intrested;
    }

    public function setIntrested(int $intrested): self
    {
        $this->intrested = $intrested;

        return $this;
    }

    public function getIntrestingOffer(): ?int
    {
        return $this->intresting_offer;
    }

    public function setIntrestingOffer(int $intresting_offer): self
    {
        $this->intresting_offer = $intresting_offer;

        return $this;
    }
}
