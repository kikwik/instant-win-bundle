<?php

namespace Kikwik\InstantWinBundle\Traits;

trait LeadTrait
{
    /**
     * @ORM\Column(type="boolean")
     */
    private $isInstantWinner = false;


    public function getIsInstantWinner(): ?bool
    {
        return $this->isInstantWinner;
    }

    public function setIsInstantWinner(bool $isInstantWinner): self
    {
        $this->isInstantWinner = $isInstantWinner;

        return $this;
    }
}