<?php

namespace Flerex\SpainGas\Contracts;

use Flerex\SpainGas\QueryBuilders\StationFinderBuilder;

interface GasApi
{
    public static function gasStations(): StationFinderBuilder;
}
