<?php
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace Flerex\SpainGas\Enums;


use MyCLabs\Enum\Enum;

/**
 * @method static ServiceType ANY()
 * @method static ServiceType SELF_SERVICE()
 * @method static ServiceType ASSISTED()
 * @method static ServiceType UNATTENDED()
 */
class ServiceType extends Enum
{
    private const ANY = null;
    private const SELF_SERVICE = "A";
    private const ASSISTED = "P";
    private const UNATTENDED = "D";
}
