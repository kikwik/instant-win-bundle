<?php

namespace Kikwik\InstantWinBundle\Traits;


trait ConfigurationTrait
{
    /**************************************/
    /* PROPERTIES                         */
    /**************************************/

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInstantWinEnabled = true;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $instantWinMaxCount = 52;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $instantWinPeriodLength = 1;

    /**
     * @ORM\Column(type="InstantWinPeriodUnitType", nullable=true)
     */
    private $instantWinPeriodUnit = 'weeks';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instantWinSenderName = 'Concorsiweb';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instantWinWinnerMessage = 'Congratulazioni, hai vinto! Ti contatteremo per la consegna del premio.';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instantWinLooserMessage = 'Grazie per avere partecipato. Purtroppo non hai vinto oggi ma c\'e\' ancora l\'estrazione finale.';

    /**************************************/
    /* CUSTOM METHODS                     */
    /**************************************/

    public function getAllInstantWinPeriods(): array
    {
        $periods = [];

        if($this->isInstantWinEnabled)
        {
            $periodStartTs = $this->getStartAt()->getTimestamp();
            $periodModifier = '+'.$this->instantWinPeriodLength.' '.$this->instantWinPeriodUnit;
            do
            {
                $periodEndTs = min(strtotime($periodModifier,$periodStartTs), $this->getEndAt()->getTimestamp()+1);
                $periods[$periodStartTs] = $periodEndTs-1;
                $periodStartTs = $periodEndTs;
            }
            while($periodStartTs < $this->getEndAt()->getTimestamp());
        }

        return $periods;
    }
    
    public function getExpectedWinnerCount(\DateTime $when = null): int
    {
        if(!$this->isInstantWinEnabled)
            return 0;

        $currentTs = $when ? $when->getTimestamp() : time();

        if($currentTs < $this->getStartAt()->getTimestamp())
            return 0;

        $periods = $this->getAllInstantWinPeriods();
        $count = 0;
        foreach($periods as $startTs => $endTs)
        {
            $count++;
            if($startTs <= $currentTs && $currentTs <= $endTs)
            {
                break;
            }
        }
        return min($count,$this->instantWinMaxCount);
    }

    public function getInstantWinPeriod(\DateTime $when = null): array
    {
        if(!$this->isInstantWinEnabled)
            return [null, null];

        $currentTs = $when ? $when->getTimestamp() : time();
        $periods = $this->getAllInstantWinPeriods();
        foreach($periods as $startTs => $endTs)
        {
            if($startTs <= $currentTs && $currentTs <= $endTs)
            {
                return [$startTs, $endTs];
            }
        }
        return [null, null];
    }

    public function getAssignableWinnerCount()
    {
        $periods = $this->getAllInstantWinPeriods();
        return min(count($periods),$this->instantWinMaxCount);
    }
    
    /**************************************/
    /* GETTERS & SETTERS                  */
    /**************************************/
    
    public function getIsInstantWinEnabled(): ?bool
    {
        return $this->isInstantWinEnabled;
    }

    public function setIsInstantWinEnabled(bool $isInstantWinEnabled): self
    {
        $this->isInstantWinEnabled = $isInstantWinEnabled;

        return $this;
    }

    public function getInstantWinMaxCount(): int
    {
        return $this->instantWinMaxCount;
    }

    public function setInstantWinMaxCount(?int $instantWinMaxCount): self
    {
        $this->instantWinMaxCount = $instantWinMaxCount;

        return $this;
    }

    public function getInstantWinPeriodLength(): ?int
    {
        return $this->instantWinPeriodLength;
    }

    public function setInstantWinPeriodLength(?int $instantWinPeriodLength): self
    {
        $this->instantWinPeriodLength = $instantWinPeriodLength;

        return $this;
    }

    public function getInstantWinPeriodUnit()
    {
        return $this->instantWinPeriodUnit;
    }

    public function setInstantWinPeriodUnit($instantWinPeriodUnit): self
    {
        $this->instantWinPeriodUnit = $instantWinPeriodUnit;

        return $this;
    }


    public function getInstantWinSenderName(): ?string
    {
        return $this->instantWinSenderName;
    }

    public function setInstantWinSenderName(?string $instantWinSenderName): self
    {
        $this->instantWinSenderName = $instantWinSenderName;

        return $this;
    }

    public function getInstantWinWinnerMessage(): ?string
    {
        return $this->instantWinWinnerMessage;
    }

    public function setInstantWinWinnerMessage(?string $instantWinWinnerMessage): self
    {
        $this->instantWinWinnerMessage = $instantWinWinnerMessage;

        return $this;
    }

    public function getInstantWinLooserMessage(): ?string
    {
        return $this->instantWinLooserMessage;
    }

    public function setInstantWinLooserMessage(?string $instantWinLooserMessage): self
    {
        $this->instantWinLooserMessage = $instantWinLooserMessage;

        return $this;
    }
}