<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\Town;

final class Location
{
    /**
     * Decimal latitude of the coordinates of the gas station.
     * @var float
     */
    public float $latitude;

    /**
     * Decimal longitude of the coordinates of the gas station.
     * @var float
     */
    public float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Converts the Location to a DegreesLocation object that works with degrees instead of decimal coordinates.
     *
     * @return DegreesLocation
     */
    public function toDegrees(): DegreesLocation
    {
        return new DegreesLocation($this->latitude, $this->longitude);
    }
}
