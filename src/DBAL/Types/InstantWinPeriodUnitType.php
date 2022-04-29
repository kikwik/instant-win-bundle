<?php


namespace Kikwik\InstantWinBundle\DBAL\Types;


use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class InstantWinPeriodUnitType extends AbstractEnumType
{
    public const MINUTES    = 'minutes';
    public const HOURS      = 'hours';
    public const DAYS       = 'days';
    public const WEEKS      = 'weeks';
    public const MONTHS     = 'months';

    protected static array $choices = [
        self::MINUTES   => 'Minuti',
        self::HOURS     => 'Ore',
        self::DAYS      => 'Giorni',
        self::WEEKS     => 'Settimane',
        self::MONTHS    => 'Mesi',
    ];
}