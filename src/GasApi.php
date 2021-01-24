<?php


namespace Flerex\SpainGas;

use Flerex\SpainGas\Contracts\GasApi as GasApiContract;
use Flerex\SpainGas\QueryBuilders\StationFinderBuilder;

class GasApi implements GasApiContract
{

    /**
     * Returns an instance of the builder class that allows
     * to interact with the stations API endpoint.
     *
     * @return StationFinderBuilder
     */
    public static function gasStations(): StationFinderBuilder
    {
        return new StationFinderBuilder;
    }

    /**
     * Non-instantiable class.
     */
    private function __construct()
    {
    }
}
