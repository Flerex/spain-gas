<?php

namespace Flerex\SpainGas\Contracts;

use Flerex\SpainGas\QueryBuilders\StationDetailsBuilder;
use Flerex\SpainGas\QueryBuilders\StationFinderBuilder;

interface GasApi
{
    /**
     * Returns an instance of the builder class that allows
     * to interact with the stations API endpoint.
     *
     * @return StationFinderBuilder
     */
    public static function gasStations(): StationFinderBuilder;

    /**
     * Returns an instance of the builder class that allows
     * to interact with the stations info API endpoint.
     *
     * @return StationDetailsBuilder
     */
    public static function stationsDetails(): StationDetailsBuilder;
}
