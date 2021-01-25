<?php


namespace Flerex\SpainGas;

use Flerex\SpainGas\Contracts\GasApi as GasApiContract;
use Flerex\SpainGas\QueryBuilders\StationDetailsBuilder;
use Flerex\SpainGas\QueryBuilders\StationLocationBuilder;

final class GasApi implements GasApiContract
{

    /** @inheritDoc */
    public static function locateGasStations(): StationLocationBuilder
    {
        return new StationLocationBuilder;
    }

    /** @inheritDoc */
    public static function gasStations(): StationDetailsBuilder
    {
        return new StationDetailsBuilder;
    }

    /**
     * Non-instantiable class.
     */
    private function __construct()
    {
    }
}
