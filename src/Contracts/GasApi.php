<?php

namespace Flerex\SpainGas\Contracts;

use Flerex\SpainGas\QueryBuilders\StationDetailsBuilder;
use Flerex\SpainGas\QueryBuilders\StationLocationBuilder;
use Flerex\SpainGas\QueryBuilders\TownBuilder;

interface GasApi
{
    /**
     * Returns an instance of the builder class that allows
     * to interact with the stations API endpoint.
     *
     * @return StationLocationBuilder
     */
    public static function locateGasStations(): StationLocationBuilder;

    /**
     * Returns an instance of the builder class that allows
     * to interact with the stations info API endpoint.
     *
     * @return StationDetailsBuilder
     */
    public static function gasStations(): StationDetailsBuilder;

    /**
     * Returns an instance of the builder class that allows
     * to interact with the town API endpoint.
     *
     * @return TownBuilder
     */
    public static function towns(): TownBuilder;
}
