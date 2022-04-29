<?php

namespace Kikwik\InstantWinBundle\Interfaces;


interface ConfigurationInterface
{
    public function getIsInstantWinEnabled(): ?bool;
    public function getInstantWinMaxCount(): int;
    public function getExpectedWinnerCount(\DateTime $whenTimestamp = null): int;
    public function getInstantWinPeriod(\DateTime $whenTimestamp = null): array;

    public function getStartAt(): ?\DateTime;
    public function getEndAt(): ?\DateTime;
}