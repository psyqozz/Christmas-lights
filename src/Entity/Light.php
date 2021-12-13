<?php

namespace App\Entity;

use App\Repository\LightRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LightRepository::class)
 */
class Light
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $position_x;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $position_y;

    /**
     * @ORM\Column(type="int")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string")
     */
    private $typeLight;

    /**
     * @ORM\Column(type="int")
     */
    private $brightness;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPositionX(): ?string
    {
        return $this->postion_x;
    }

    public function setPositionX(string $postion_x): self
    {
        $this->postion_x = $postion_x;

        return $this;
    }

    public function getPositionY(): ?string
    {
        return $this->postion_y;
    }

    public function setPositionY(string $postion_y): self
    {
        $this->postion_y = $postion_y;

        return $this;
    }

    public function getIsActive(): ?int
    {
        return $this->isActive;
    }

    public function setIsActive(int $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getTypeLight(): ?string
    {
        return $this->typeLight;
    }

    public function setTypeLight(string $typeLight): self
    {
        $this->typeLight = $typeLight;

        return $this;
    }

    public function getBrightness(): ?int
    {
        return $this->brightness;
    }

    public function setBrightness(int $brightness): self
    {
        $this->brightness = $brightness;

        return $this;
    }
}
