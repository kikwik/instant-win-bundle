<?php

namespace Kikwik\InstantWinBundle\Traits;

trait LeadRepositoryTrait
{
    public function getWinnersCount(): int
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->andWhere('l.isInstantWinner = :winner')->setParameter('winner',true)
            ->getQuery()
            ->getSingleScalarResult();
    }
}