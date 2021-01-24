<?php
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace Flerex\SpainGas\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static Fuel ALL()
 * @method static Fuel PETROL_95_E5()
 * @method static Fuel PETROL_95_E10()
 * @method static Fuel PETROL_95_E5_PREMIUM()
 * @method static Fuel PETROL_98_E5()
 * @method static Fuel PETROL_98_E10()
 * @method static Fuel DIESEL_A()
 * @method static Fuel DIESEL_PREMIUM()
 * @method static Fuel DIESEL_B()
 * @method static Fuel BIOETHANOL()
 * @method static Fuel BIODIESEL()
 * @method static Fuel LIQUEFIED_PETROLEUM_GAS()
 * @method static Fuel LPG()
 * @method static Fuel COMPRESSED_NATURAL_GAS()
 * @method static Fuel CNG()
 * @method static Fuel LIQUEFIED_NATURAL_GAS()
 * @method static Fuel LNG()
 * @method static Fuel HYDROGEN()
 */
class Fuel extends Enum
{
    private const ALL = null;
    private const PETROL_95_E5 = 1;
    private const PETROL_95_E10 = 23;
    private const PETROL_95_E5_PREMIUM = 20;
    private const PETROL_98_E5 = 3;
    private const PETROL_98_E10 = 21;
    private const DIESEL_A = 4;
    private const DIESEL_PREMIUM = 5;
    private const DIESEL_B = 6;
    private const BIOETHANOL = 16;
    private const BIODIESEL = 8;
    private const LIQUEFIED_PETROLEUM_GAS = 17;
    private const LPG = 17;
    private const COMPRESSED_NATURAL_GAS = 18;
    private const CNG = 18;
    private const LIQUEFIED_NATURAL_GAS = 19;
    private const LNG = 19;
    private const HYDROGEN = 22;
}
