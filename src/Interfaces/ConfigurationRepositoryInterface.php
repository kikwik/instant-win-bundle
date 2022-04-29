<?php

namespace Kikwik\InstantWinBundle\Interfaces;

interface ConfigurationRepositoryInterface
{
    public function findTheOnlyOne(): ?ConfigurationInterface;
}