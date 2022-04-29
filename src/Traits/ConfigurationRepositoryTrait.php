<?php

namespace Kikwik\InstantWinBundle\Traits;

use Kikwik\InstantWinBundle\Interfaces\ConfigurationInterface;

trait ConfigurationRepositoryTrait
{
    public function findTheOnlyOne(): ?ConfigurationInterface
    {
        return $this->createQueryBuilder('c')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}