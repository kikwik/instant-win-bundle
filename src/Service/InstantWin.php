<?php

namespace Kikwik\InstantWinBundle\Service;


use Kikwik\InstantWinBundle\Interfaces\CompetitionManagerInterface;
use Kikwik\InstantWinBundle\Interfaces\ConfigurationRepositoryInterface;
use Kikwik\InstantWinBundle\Interfaces\LeadRepositoryInterface;

class InstantWin
{
    private $leadRepository;
    private $configuration;


    public function __construct(ConfigurationRepositoryInterface $configurationRepository, LeadRepositoryInterface $leadRepository)
    {
        $this->leadRepository = $leadRepository;
        $this->configuration = $configurationRepository->findTheOnlyOne();
    }

    public function lottery(\DateTime $when = null, int $currentWinnersCount = null):bool
    {
        // check if configuration exists
        if(!$this->configuration)
            return false;
        
        // check if instant win is enabled
        if(!$this->configuration->getIsInstantWinEnabled())
            return false;

        $currentTs = $when ? $when->getTimestamp() : time();

        if(is_null($currentWinnersCount))
        {
            $currentWinnersCount = $this->leadRepository->getWinnersCount();
        }

        // check for max winner count
        $maxWinnerCount = $this->configuration->getInstantWinMaxCount();
        if($currentWinnersCount >= $maxWinnerCount)
            return false;

        // check for winner count so far
        $expectedWinnerCount = $this->configuration->getExpectedWinnerCount($when);
        if($currentWinnersCount >= $expectedWinnerCount)
            return false;
        elseif($currentWinnersCount <= $expectedWinnerCount-2) // we missed last period, let's win!
            return true;

        // random lottery!
        list($periosStartTs,$periodEndTs) = $this->configuration->getInstantWinPeriod($when);
        if($periosStartTs && $periodEndTs)
        {
            return mt_rand($periosStartTs, $periodEndTs) <= $currentTs-(($periodEndTs-$periosStartTs)/2);
        }

        return false;
    }
}