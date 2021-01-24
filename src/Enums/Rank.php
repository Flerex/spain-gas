<?php
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace Flerex\SpainGas\Enums;


use MyCLabs\Enum\Enum;

/**
 * Represents how expensive a gas station is compared to others.
 *
 * The algorithm used to categorize the fuel price is not public.
 *
 * @method static Rank CHEAP()
 * @method static Rank AVERAGE()
 * @method static Rank EXPENSIVE()
 * @method static Rank VERY_EXPENSIVE()
 */
class Rank extends Enum
{
    private const CHEAP = 1;
    private const AVERAGE = 2;
    private const EXPENSIVE = 3;
    private const VERY_EXPENSIVE = 4;
}
