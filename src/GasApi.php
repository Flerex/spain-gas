<?php


namespace Flerex\SpainGas;

use Flerex\SpainGas\Contracts\GasApi as GasApiContract;
use Flerex\SpainGas\QueryBuilders\StationDetailsBuilder;
use Flerex\SpainGas\QueryBuilders\StationLocationBuilder;
use Flerex\SpainGas\QueryBuilders\TownBuilder;

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

    /** @inheritDoc */
    public static function towns(): TownBuilder
    {
        return new TownBuilder;
    }

    /**
     * Non-instantiable class.
     */
    private function __construct()
    {
    }
}
