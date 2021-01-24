<?php
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace Flerex\SpainGas\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static SalesType ASSOCIATES()
 * @method static SalesType PUBLIC()
 * @method static SalesType ALL()
 */
class SalesType extends Enum
{
    private const ASSOCIATES = "R";
    private const PUBLIC = "P";
    private const ALL = "T";
}
