<?php

namespace Flerex\SpainGas\Dtos;

use Flerex\SpainGas\Enums\Province;
use Flerex\SpainGas\Enums\Rank;
use Flerex\SpainGas\Enums\SalesType;
use Flerex\SpainGas\Enums\Town;

final class DegreesLocation
{
    public DegreesCoordinate $latitude;
    public DegreesCoordinate $longitude;

    public function __construct(float $latitude, float $longitude)
    {
       $this->latitude = new DegreesCoordinate($latitude, 'N', 'S');
       $this->longitude = new DegreesCoordinate($longitude, 'E', 'W');
    }
}
