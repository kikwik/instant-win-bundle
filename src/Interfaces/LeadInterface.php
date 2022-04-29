<?php

namespace Kikwik\InstantWinBundle\Interfaces;

interface LeadInterface
{
    public function getIsInstantWinner(): ?bool;
    public function setIsInstantWinner(bool $isInstantWinner): self;
}